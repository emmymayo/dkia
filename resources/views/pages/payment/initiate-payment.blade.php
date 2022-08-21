<x-header title="Payment">
    <script src="https://js.paystack.co/v1/inline.js"></script>
</x-header>


<x-nav-header />
<x-sidebar-nav />
<x-sidebar-control />



<div class="content-wrapper" style="min-height: 264px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 lead">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <form class="text-center" id="paymentForm">
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
            {{-- <form class=" my-3 text-center" method="get" action="{{route('cancel-payment', $reference)}}">
                <button class="btn btn-danger" type="submit">Cancel Payment</button>
            </form> --}}

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<x-footer motto="">
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
                    alert('Transaction was not completed, Transaction will be deleted');
                    var reference = "{{$reference}}";
                    window.location.href = "{{route('cancel-payment')}}"+"?ref="+reference;
                },
            });
            handler.openIframe();
        }
    </script>
</x-footer>