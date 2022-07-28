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
            'purpose' => 'required|max:200|String',
            'amount' => 'required',
            'on_behalf' => 'String|nullable'
        ]);

        $payment = new Payment();
        $payment->user_id = Auth::id();
        $payment->on_behalf = $request->input('on_behalf');
        $payment->purpose = $request->input('purpose');
        $payment->amount = $request->input('amount');
        $payment->reference = Payment::ref();
        $payment->payment_date = date('Y-m-d H:i:s');
        $payment->payment_service =  $request->input('payment_service');
        $payment->payment_status = Payment::STATUS_PENDING;
        //dd($payment);
        if ($payment->save()){
            return redirect(route('initiate-payment', $payment, $id));// ->with('action-success','Exam has been successfully created');
        }
        return back()->with('action-fail','Something went wrong. Try Again');
        
     }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGatewayCallback(Request $request, $payment, $id)
    {
        //dd($this->$payment->payment_service);

        //Trying to get selected payment method and direct to the designated page
        $id = Payment::find($id);
        $payment = Payment::where('id', $id);

        if($payment->payment_service == 1){
            return "this is paystack";
        } else {
            return "this is flutter";
        }
        /**
         * Next step
         * 
         * destructure all payment array and input into the for
         * while destruction multiply amount by 100 to add in kobo
         * then submit the form 
         * get data sent from payment gatewas and input the transaction id gotten from the payment
         * the get status if status == successful complete payment
         * else
         * redirect to error / failed page
         */

     //Getting authenticated user 
        // $id = Auth::id();
        // // Getting the specific student and his details
        // $student = Student::where('user_id',$id)->first();
        // $class_id = $student->class_id;
        // $section_id = $student->section_id; 
        // $level_id = $student->level_id; 
        // $student_id = $student->id; 
        
        //$paymentDetails = Paystack::getPaymentData(); //this comes with all the data needed to process the transaction
        // Getting the value via an array method
        // $inv_id = $paymentDetails['data']['metadata']['invoiceId'];// Getting InvoiceId I passed from the form
        // $status = $paymentDetails['data']['status']; // Getting the status of the transaction
        // $amount = $paymentDetails['data']['amount']; //Getting the Amount
        // $number = $randnum = rand(1111111111,9999999999);// this one is specific to application
        // $number = 'year'.$number;
        // dd($status);
        // if($status == "success"){ //Checking to Ensure the transaction was succesful
          
        //     Payment::create(['student_id' => $student_id,'invoice_id'=>$inv_id,'amount'=>$amount,'status'=>1]); // Storing the payment in the database
        //     Student::where('user_id', $id)
        //           ->update(['register_no' => $number,'acceptance_status' => 1]);
                  
        //     return view('student.studentFees'); 
        // }
      
        // Now you have the payment details,
        // you can store the authorization_code in your DB to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
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
