<?php

namespace App\Http\Controllers\Pay;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // dd($request->all());
        if (isset($request->pid)) {
            $product =  Product::where('id', $request->pid)->first();
            $order = new Order;
            $order->product_id = $product->id;
            $order->invoice_no = $product->id . time();
            $order->total = $product->price;
            $order->save();


            $fonepay = [];
            $fonepay['RU'] = route('fonepay.return');
            $fonepay['PID'] = 'NBQM';
            $fonepay['PRN'] = $order->invoice_no;
            $fonepay['AMT'] = $order->total;
            $fonepay['CRN'] = 'NPR';
            $fonepay['DT'] = date('m/d/Y');
            $fonepay['R1'] = 'test';
            $fonepay['R2'] = 'letslearntogether';
            $fonepay['MD'] = 'P';

            $data = $fonepay['PID'] . ',' .
                $fonepay['MD'] . ',' .
                $fonepay['PRN'] . ',' .
                $fonepay['AMT'] . ',' .
                $fonepay['CRN'] . ',' .
                $fonepay['DT'] . ',' .
                $fonepay['R1'] . ',' .
                $fonepay['R2'] . ',' .
                $fonepay['RU'];
            $fonepay['DV'] = hash_hmac('sha512', $data, 'a7e3512f5032480a83137793cb2021dc');

            return view('product.product-checkout.checkout', compact('product', 'order', 'fonepay'));
            // return view('product.product-checkout.checkout', compact('product', 'order'));
        }
    }
}
