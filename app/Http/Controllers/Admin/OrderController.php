<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $fillableUser = [
        'id',
        'slug',
        'full_name',
        'email',
        'phone_number',
        'avatar',
        'created_at',
    ];

    protected $fillableInvest = [
        'id',
        'name',
        'slug',
    ];

    public function index()
    {
        $orders = Order::with([
            'user' => function($query) {
                $query->select([
                    'id',
                    'full_name',
                    'created_at',
                ]);
            },
            'company_invest' => function($query) {
                $query->select([
                    'id',
                    'name',
                ]);
            },
        ])->orderByDesc('created_at')->paginate(10, [
            'id',
            'account_id',
            'invest_id',
            'amount',
            'payment_method',
            'payment_status',
            'created_at',
        ]);

        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->load([
            'user' => function($query) {
                $query->select($this->fillableUser);
            },
            'company_invest' => function($query) {
                $query->select($this->fillableInvest);
            },
            'transaction'
        ]);

        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);
            $order->update($data);
            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);
            File::delete($order->contract_url);
            $order->delete();

            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function search(Request $request)
    {
        $key = $request->keyName;

        $orders = Order::with([
            'user' => function($query) {
                $query->select([
                    'id',
                    'full_name',
                    'created_at',
                ]);
            },
            'company_invest' => function($query) {
                $query->select([
                    'id',
                    'name',
                ]);
            },
        ])->whereHas('user', function ($query) use ($key) {
            $query->where('full_name', 'like', '%'.$key.'%');
        })->paginate(10, [
            'id',
            'account_id',
            'invest_id',
            'amount',
            'payment_method',
            'payment_status',
            'created_at',
        ]);

        $orders->appends(['search' => $key]);

        return response()->json($orders);
    }
}
