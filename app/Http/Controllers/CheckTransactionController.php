<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTransactionController extends Controller
{
    //
    public function myPayment(Request $request) {
        $payments = Payment::where('user_id', Auth::id())
                    ->where('payment_status', Payment::STATUS_SUCCESSFUL)
                    ->paginate(10);
        return view('pages.payment.index', ['payments' => $payments]);
    }

    public function show_receipt(Request $request, $id) {
        $payment = Payment::where('id', $id)->first();

        return view('pages.payment.show', ['payment' => $payment]);
    }

    public function check_payment() {
        $query = request()->query('search');

        if ($query) {
            $payments = Payment::where('reference', 'LIKE', "%{$query}%")
                        ->where('payment_status', Payment::STATUS_SUCCESSFUL)
                        ->paginate(10);
        } else {
            $payments = Payment::paginate(10);
        }

        return view('pages.payment.admin.index', ['payments' => $payments]);
    }
}
