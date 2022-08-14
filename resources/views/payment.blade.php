<form action="{{route('save_payment')}}" method="POST">
    {{ csrf_field() }}
    <input type="text" name="purpose" id="purpose" placeholder="Purpose">
    <input type="number" name="amount" id="amount" placeholder="Amount">
    <input type="text" name="on_behalf" id="on_behalf" placeholder="On Behalf">

    <button type="submit">Proceed</button>
</form>