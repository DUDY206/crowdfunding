<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Mail\ContactForm;
use App\Mail\OrderMailable;
use App\Models\CompanyInvest;
use App\Models\InvestType;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Auth;
use Response;

class OrderController extends Controller
{
    public $fillableCompany = [
        'id',
        'name',
        'slug',
    ];

    public function index()
    {
        $user = Auth::guard('api')->user();
        $orders = Order::with([
            'company_invest' => function ($query) {
                $query->select($this->fillableCompany);
            }
        ])->where('account_id', $user->id)->orderByDesc('created_at')->get();

        return response()->json($orders);
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            $user = $request->user('api');
            //save pd

            $contract = $request->get('contract_value');
            $htmlCustomPdf = response()->view('investor.pdf.contract', compact('contract'));
            $file_path = 'storage/contract/' . $user->id . '-' . $request->get('invest_id') . '-' . Carbon::now()->format('Y-m-d-h-i-s') . '.pdf';
            PDF::setOptions([
                'fontDir' => 'Times-Roman',
                'defaultPaperSize' => 'letter',
            ]);
            PDF::loadHTML($htmlCustomPdf->getContent())->setWarnings(false)->save($file_path);

            // $file_path = 'storage/contract/' . $user->id . '-' . $request->get('invest_id') . '-' . Carbon::now()->format('Y-m-d-h-i-s') . '.pdf';
            // PDF::setOptions([
            //     'fontDir' => 'Times-Roman',
            // ]);
            // $file = PDF::loadHTML($request->get('contract_value'))->setWarnings(false)->save($file_path);

            $params_create = [
                'account_id' => $user->id,
                'contract_url' => $file_path,
            ];

            $order = Order::create(
                $request->all(['invest_id','amount','signature','amount','payment_method','payment_status','invest_type_id'])+$params_create
            );

            //send mail
            if ($request->get('send_mail')!== null) {
                $invest = CompanyInvest::findOrFail($request->get('invest_id'));
                $invest_type = InvestType::findOrFail($request->get('invest_type_id'));
                $contract_pdf_url = $_SERVER['HTTP_ORIGIN'] . '/vi/order/' . $order->id;
                $payment_contact = $_SERVER['HTTP_ORIGIN'] . '/vi/transaction';

                // to investment
                $mailable = new OrderMailable(
                    $file_path,
                    $invest->lang_name->vi,
                    $invest_type->lang_name->vi,
                    $request->get('amount'),
                    $contract_pdf_url,
                    $user->full_name,
                    $order->id,
                    $payment_contact,
                );
                $toEmail = $request->get('send_mail');
                Mail::to($toEmail)->send($mailable);
            }
            DB::commit();

            return response()->json($order);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $user = $GLOBALS['request']->user('api');
        if ($order->account_id === $user->id) {
            return response()->json($order);
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function sendToBladePdf($file)
    {
        return response()->view('investor.pdf.contract');
    }
}
