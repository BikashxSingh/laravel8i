{{-- <!DOCTYPE html>
<html>
	<head>
		<title>Multiple Payment Gateway Integration With Laravel</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body> --}}

@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            @include('inc.messages')

            <div class="container">
                <div class="checkout pt-md-5">
                    <div class="col-mod-12">
                        <h2> Order Details</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="image_container" style="height: 150px;">
                                        <img src="{{ asset(Storage::url($product->pImage ?? '')) }}" class="card-img-top"
                                            style="width: 150px; height: 150px;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">Rs. {{ $product->price }}</p>
                                        <p class="card-text">{{ $product->short_description }}</p>
                                        <p class="card-text">{{ $product->long_description }}</p>
                                        <p class="card-text">{{ $product->thecategory->title ?? '-' }}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3>Pay With </h3>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <form action="https://uat.esewa.com.np/epay/main" method="POST">
                                            @csrf
                                            <input value="{{ $product->price }}" name="tAmt" type="hidden">
                                            <input value="{{ $product->price }}" name="amt" type="hidden">
                                            <input value="0" name="txAmt" type="hidden">
                                            <input value="0" name="psc" type="hidden">
                                            <input value="0" name="pdc" type="hidden">
                                            <input value="EPAYTEST" name="scd" type="hidden">
                                            <input value="{{ $order->invoice_no }}" name="pid" type="hidden">
                                            <input value="{{ route('esewa.success') }}" type="hidden" name="su">
                                            <input value="{{ route('esewa.fail') }}" type="hidden"
                                                name="fu">
                                            {{-- <input value="{{ route('esewa.fail', $order->product_id) }}" type="hidden"
                                                name="fu"> --}}
                                            {{-- <input value="{{ route('esewa.fail.cancel', $order->product_id) }}"
                                                type="hidden" name="fu"> --}}
                                            <h6>Esewa [HTML]</h6>
                                            <input type="image" src="{{ asset('logo/esewa_logo.png') }}" alt="Submit">
                                        </form>
                                    </li>

                                    <li class="list-group-item">
                                        <form action="{{ route('main') }}" method="POST">
                                            @csrf
                                            <input value="{{ $product->id }}" name="product_id" type="hidden">
                                            <input value="{{ $order->id }}" name="order_id" type="hidden">

                                            <h6>Esewa [PHP]</h6>
                                            <input type="image" src="{{ asset('logo/esewa_logo.png') }}" alt="Submit">
                                        </form>

                                    </li>
                                    {{-- <input value="{{ $product->price }}" name="tAmt" type="hidden">
                                        <input value="{{ $product->price }}" name="amt" type="hidden">
                                        <input value="0" name="txAmt" type="hidden">
                                        <input value="0" name="psc" type="hidden">
                                        <input value="0" name="pdc" type="hidden">
                                        <input value="EPAYTEST" name="scd" type="hidden">
                                        <input value="{{ $order->invoice_no }}" name="pid" type="hidden"> --}}

                                    <li class="list-group-item">
                                        <form action="https://dev-merchantapi.fonepay.com/api/merchantRequest"
                                            method="POST">
                                            <input type="hidden" name="PID" value="{{ $fonepay['PID'] }}" />
                                            <input type="hidden" name="MD" value="{{ $fonepay['MD'] }}" />
                                            <input type="hidden" name="PRN" value="{{ $fonepay['PRN'] }}" />
                                            <input type="hidden" name="AMT" value="{{ $fonepay['AMT'] }}" />
                                            <input type="hidden" name="CRN" value="{{ $fonepay['CRN'] }}" />
                                            <input type="hidden" name="DT" value="{{ $fonepay['DT'] }}" />
                                            <input type="hidden" name="R1" value="{{ $fonepay['R1'] }}" />
                                            <input type="hidden" name="R2" value="{{ $fonepay['R2'] }}" />
                                            <input type="hidden" name="DV" value="{{ $fonepay['DV'] }}" />
                                            <input type="hidden" name="RU" value="{{ $fonepay['RU'] }}" />
                                            <input type="image" src="{{ asset('logo/logo.png') }}" alt="Submit">
                                        </form>

                                    </li>
                                    {{-- <li class="list-group-item">
                                        <form action="https://dev-merchantapi.fonepay.com/api/merchantRequest"
                                            method="POST">
                                            <input type="hidden" name="PID" value="NBQM" />
                                            <input type="hidden" name="MD" value="P" />
                                            <input type="hidden" name="PRN" value="{{ $order->invoice_no }}" />
                                            <input type="hidden" name="AMT" value="{{ $order->total }}" />
                                            <input type="hidden" name="CRN" value="NPR" />
                                            <input type="hidden" name="DT" value="{{ date('m/d/Y') }}" />
                                            <input type="hidden" name="R1" value="test" />
                                            <input type="hidden" name="R2" value="letslearntogether" />
                                            <input type="hidden" name="DV"
                                                value="{{ hash_hmac('sha512', $data, 'a7e3512f5032480a83137793cb2021dc') }}" />
                                            <input type="hidden" name="RU" value="{{ route('fonepay.return') }}" />
                                            <input type="image" src="{{ asset('logo/logo.png') }}" alt="Submit">
                                        </form>
                                    </li> --}}

                                    <li>
                                        <button id="payment-button">Pay with Khalti</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('style')
@endpush

@push('script')
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>


    <!-- Place this where you need payment button -->
    <!-- Paste this code anywhere in you body tag -->
    <script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
            ],
            "eventHandler": {
                onSuccess(payload) {
                    // hit merchant api for initiating verfication
                    console.log(payload);
                },
                onError(error) {
                    console.log(error);
                },
                onClose() {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function() {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({
                amount: 1000
            });
        }
    </script>
@endpush
{{-- </body>
	</html> --}}
