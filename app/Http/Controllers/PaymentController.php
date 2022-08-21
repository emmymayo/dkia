<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('pages.payment.create');
    }

    /**
     * Store Payment Details in DB
     * 
     * @return \Illuminate\Http\Response
     */

     public function startTransaction(Request $request)
     {
        // $this->authorize('create', Payment::class);

        $request->validate([
            'purpose' => 'required|max:200|string',
            'amount' => 'required',
            'on_behalf' => 'string|nullable'
        ]);

        $payment = new Payment();
        $payment->user_id = Auth::id();
        $payment->on_behalf = $request->input('on_behalf');
        $payment->purpose = $request->input('purpose');
        $payment->amount = $request->input('amount');
        $payment->reference = Payment::ref();
        $payment->payment_date = date('Y-m-d H:i:s');
        //$payment->payment_service =  $request->input('payment_service');
        $payment->payment_status = Payment::STATUS_PENDING;
        //dd($payment);
        if (!$payment->save()){
            return back()->with('action-fail','Something went wrong. Try Again');
        }
        $payment->payment_status = Payment::STATUS_PROCCESSING;
        $payment->save();
        return view('pages.payment.initiate-payment', $payment);
        
     }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGatewayCallback(Request $request)
    {
        
        $key = config('payment.paystack.secret_key');
  
        $response = Http::retry(3)->withToken($key,'Bearer')
                       ->get('https://api.paystack.co/transaction/verify/'.$request->ref);
        
        $payment = Payment::where('reference', $request->ref)->first();

        if(!$response->successful()){
            $payment->payment_status = Payment::STATUS_FAILED;
            $payment->save();
            echo("Transaction was not verified");
        } else {
            $payment->payment_status = Payment::STATUS_SUCCESSFUL;
            $payment->save();
            return redirect()->route('create-payment');
        }

    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    // public function successTransaction(Request $request)
    // {
    //     $provider = new PayPalClient;
    //     $provider->setApiCredentials(config('paypal'));
    //     $provider->getAccessToken();
    //     $response = $provider->capturePaymentOrder($request['token']);

    //     if (isset($response['status']) && $response['status'] == 'COMPLETED') {
    //         return redirect()
    //             ->route('createTransaction')
    //             ->with('success', 'Transaction complete.');
    //     } else {
    //         return redirect()
    //             ->route('createTransaction')
    //             ->with('error', $response['message'] ?? 'Something went wrong.');
    //     }
    // }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        $payment_delete = Payment::where('reference', $request->ref)->first();
        $payment_delete->delete();

        return redirect()
            ->route('create-payment')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
