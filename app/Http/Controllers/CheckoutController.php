<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request){
        // Save users data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Checkout Proccess
        $code = 'STORE-' . mt_rand(000000,999999);
        $carts = Cart::with('product', 'user')
        ->where('user_id', Auth::user()->id)
        ->get();

        //Create the Transaction
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        foreach ($carts as $cart){
            $trx = 'TRX-' . mt_rand(000000,999999);

            $testing =  TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx
            ]);
        }

        //Delete Cart after Checkout
        Cart::where('user_id', Auth::user()->id)->delete();

        // Midtrans Configurations
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Sending array to midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email
            ],
            // 'enabled_payments' => [
            //     'gopay', 'permata_va', 'bank_transfer'
            // ],
            'vtweb' => [
                //
            ]
            ];
            try {
              // Get Snap Payment Page URL
              $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

              return redirect($paymentUrl);
            }
            catch (Exception $e) {
              echo $e->getMessage();
            }
    }

    public function callback(Request $request){
        // Midtrans Configurations
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Instance midtans notification
        $notification = new Notification();

        //Assign variable
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //Find the transaction by id
        $transaction = Transaction::findOrFail($order_id);

        //Handle notification status
        if($status == 'capture'){
            if($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }
                else{
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'pending') {
            $transaction->status = 'PENDING';
        }
        else if($status == 'deny') {
            $transaction->status = 'CANCELED';
        }
        else if($status == 'expire') {
            $transaction->status = 'CANCELED';
        }
        else if($status == 'cance;') {
            $transaction->status = 'CANCELED';
        }
        //Save transaction
        $transaction->save();

        // Kirimkan email
        if ($transaction)
        {
            if($status == 'capture' && $fraud == 'accept' )
            {
                //
            }
            else if ($status == 'settlement')
            {
                //
            }
            else if ($status == 'success')
            {
                //
            }
            else if($status == 'capture' && $fraud == 'challenge' )
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            }
            else
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }
}
