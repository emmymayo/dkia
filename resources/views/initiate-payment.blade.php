<script src="https://js.paystack.co/v1/inline.js"></script>
<form id="paymentForm">
    <div class="form-group">

        <input value="{{ auth()->user()->email }}" type="hidden" id="email-address" required />
    </div>
    <div class="form-group">

        <input value="{{$amount}}" type="hidden" id="amount" required />
    </div>
    <div class="form-group">

        <input value="{{$on_behalf}}" type="hidden" id="first-name" />
    </div>
    <div class="form-group">

        <input value="{{$payment_status}}" type="hidden" id="last-name" />
    </div>
    <div class="form-submit">
        <button class="btn btn-success" type="button" onclick="payWithPaystack()"> Pay </button>
    </div>
</form>
<form method="POST" action="{{route('cancel-payment', $id)}}">
    {{ csrf_field() }}
    <button type="submit">Cancel Payment</button>
</form>

<script>
    var paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', payWithPaystack, false);
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: "{{config('payment.paystack.public_key')}}", // Replace with your public key
            email: document.getElementById('email-address').value,
            amount: document.getElementById('amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
            currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
            ref: "{{$reference}}", // Replace with a reference you generated
            callback: function(response) {
            //this happens after the payment is completed successfully
            var reference = response.reference;
            window.location.href = "{{route('initiate-payment')}}"+"?ref="+reference;

            // Make an AJAX call to your server with the reference to verify the transaction
            },
            onClose: function() {
                alert('Transaction was not completed, window closed.');
            },
        });
        handler.openIframe();
    }
</script>