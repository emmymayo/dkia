<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        $paystack = Payment::PAYMENT_PAYSTACK;
        $flutter = Payment::PAYMENT_FLUTTER;

        return view('payment', compact('flutter', 'paystack'));
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
        return view('initiate-payment', $payment);
        
     }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGatewayCallback(Request $request)
    {
        // dd($request);
        $curl = curl_init();
  
        curl_setopt_array($curl, [
            CURLOPT_URL => `https://api.paystack.co/transaction/verify/:$request->ref`,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer SECRET_KEY",
                "Cache-Control: no-cache",
            ]
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        dd($curl);
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
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
        return redirect()
            ->route('createTransaction')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
