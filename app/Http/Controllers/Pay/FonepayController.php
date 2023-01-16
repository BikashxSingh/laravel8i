<?php

namespace App\Http\Controllers\Pay;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FonepayController extends Controller
{
	public function fonepay_response(Request $request)
	{

		if (isset($request->PRN) && isset($request->PID) && isset($request->AMT)) {

			$order = Order::where('invoice_no', $request->PRN)->first();
			if ($order) {
				$url = 'https://clientapi.fonepay.com/api/merchantRequest/verificationMerchant';

				$data =  'NBQM' . ',';
				$data .= $order->total . ',';
				$data .= $request->PRN . ',';
				$data .= $request->BID . ',';
				$data .= $request->UID;


				$DV = hash_hmac('sha512', $data, 'a7e3512f5032480a83137793cb2021dc');

				$PRN = $request['PRN'];
				$PID = $request['PID'];
				$BID = $request['BID'];
				$AMT = $order->total;
				$RU  = $request['RU'];
				$UID = $request['UID'];

				$queryString = "PRN=$PRN&PID=$PID&BID=$BID&AMT=$AMT&RU=$RU&UID=$UID&DV=$DV";
				$url   = 'https://dev-clientapi.fonepay.com/api/merchantRequest/verificationMerchant?' . $queryString;


				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$content  = curl_exec($ch);

				//dd($content );

				$response = simplexml_load_string($content);
				//dd($response);
				if ($response->success == 'true') {
					if ($response->response_code == 'successful' && $response->statusCode == 0) {
						$order->status = 1;
						$order->save();
						return redirect()->route('payment.response')->with('success_message', 'Transaction completed.');
					}
				} else {
					return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
				}
			}
		}

		return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
	}
}
