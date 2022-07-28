<form action="{{route('save_payment')}}" method="POST">
    {{ csrf_field() }}
    <input type="text" name="purpose" id="purpose" placeholder="Purpose">
    <input type="number" name="amount" id="amount" placeholder="Amount">
    <input type="text" name="on_behalf" id="on_behalf" placeholder="On Behalf">

    <label for="ayment_service">Pay with</label>
    <select name="payment_service" id="payment_service">
        <option value="{{$paystack}}">Paystack</option>
        <option value="{{$flutter}}">Flutter Wave</option>
    </select>
    <button type="submit">Proceed</button>
</form>