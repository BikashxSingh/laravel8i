<?php

namespace App\Http\Controllers\Pay;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EsewaController extends Controller
{
	public function main(Request $request)
	{
		$order = Order::where('id', $request->order_id)->first();
		// dd($order);
		$product = Product::where('id', $request->product_id)->first();

		$url = "https://uat.esewa.com.np/epay/main";

		$data = [
			'amt' => $product->price,
			'pdc' => 0,
			'psc' => 0,
			'txAmt' => 0,
			'tAmt' => $product->price,
			'pid' => $order->invoice_no,
			'scd' => 'EPAYTEST',
			'su' => route('esewa.success'),
			'fu' => route('esewa.fail')
		];

		// dd($data);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// dd($curl);
		$response = curl_exec($curl);
		// dd($response);
		curl_close($curl);

		//
		$url = "https://uat.esewa.com.np/epay/main?" . http_build_query($data);
		return redirect()->away($url);

		// dd($response);
		// return redirect()->route('esewa.success', compact('order', 'response'));
		//
	}

	public function success(Request $request)
	{
		dd($request->all());
		if (isset($request->oid) && isset($request->amt) && isset($request->refId)) {
			$order = Order::where('invoice_no', $request->oid)->first();
			// dd($order);
			if ($order) {
				$url = "https://uat.esewa.com.np/epay/transrec";
				$data = [
					'amt' => $order->total,
					'rid' => $request->refId,
					'pid' => $order->invoice_no,
					'scd' => 'EPAYTEST'
				];

				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($curl);
				// dd($response);
				curl_close($curl);

				$response_code = $this->get_xml_node_value('response_code', $response);
				//dd($response_code);
				if (trim($response_code) == 'Success') {
					$order->status = 1;
					$order->save();
					return redirect()->route('payment.response')->with('success_message', 'Transaction completed.');
				}
				if (trim($response_code) == 'fuccess') {
					$order->status = 0;
					$order->save();
					return redirect()->route('payment.response')->with('error_message', 'Transaction Failed.');
				}
			}
		}
	}

		public function fail(Request $request)
		// public function fail(Request $request, $id)
		// public function fail($id)
		{
			// $data = $request->all();
			// $ids = array_keys($data);
			// $id = $ids[0];
			// dd('product id', $id);
		return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
	}

	public function get_xml_node_value($node, $xml)
	{
		if ($xml == false) {
			return false;
		}
		$found = preg_match('#<' . $node . '(?:\s+[^>]+)?>(.*?)' .
			'</' . $node . '>#s', $xml, $matches);
		if ($found != false) {

			return $matches[1];
		}

		return false;
	}

	public function payment_response()
	{
		return view('product.product-checkout.response-page');
	}
}
