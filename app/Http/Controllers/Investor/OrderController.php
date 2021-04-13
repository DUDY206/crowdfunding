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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            //save pdf
            $user = $request->user('api');
            $file_path = 'storage/contract/'.$user->id.'-'.$request->get('invest_id').'-'.Carbon::now()->format('Y-m-d-h-i-s').'.pdf';
            PDF::setOptions(['defaultFont' => 'DejaVu Sans']);
            $file = PDF::loadHTML($request->get('contract_value'))->setWarnings(false)->save($file_path);
            $params_create = [
                'account_id' => $user->id,
                'contract_url' => $file_path,
            ];

            $order = Order::create(
                $request->all(['invest_id','amount','signature','amount','payment_status','invest_type_id'])+$params_create
            );

            //send mail
            if ($request->get('send_mail')!== null) {
                $invest = CompanyInvest::findOrFail($request->get('invest_id'));
                $invest_type = InvestType::findOrFail($request->get('invest_type_id'));
                $contract_pdf_url = $_SERVER['HTTP_ORIGIN'].'/en/order/'    .$order->id;
                $mailable = new OrderMailable($file_path,$invest->lang_name->vi,$invest_type->lang_name->vi,$request->get('amount'),$contract_pdf_url);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
