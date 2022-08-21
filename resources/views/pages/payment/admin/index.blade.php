<x-header title="Payment History">

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
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="ml-1">
                            <form class="input-group" action="{{route('check-payment')}}" method="GET">
                                <input type="text" class="form-control" name="search" placeholder="Input Ref No"
                                    value="{{request()->query('search')}}" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <span id="basic-addon1" class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </form>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Amount</th>
                        <th scope="col">On Behalf</th>
                        <th scope="col">Ref no</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                    <tr>
                        <th scope="row">{{$payment->id}}</th>
                        <td>{{$payment->user->name}}</td>
                        <td>{{$payment->user->email}}</td>
                        <td>{{$payment->purpose}}</td>
                        <td>{{$payment->amount}}</td>
                        <td>{{$payment->on_behalf}}</td>
                        <td>{{$payment->reference}}</td>
                        <td>{{$payment->payment_status}}</td>
                        <td>{{$payment->payment_date}}</td>
                        <td>
                            <form action="{{route('get-receipt', $payment->id)}}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary">Generate Receipt</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <p>No results found for Search <strong>{{ request()->query('search') }}</strong></p>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $payments->appends(['search' => request()->query('search')])->links() }}
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>


<x-footer motto="">

</x-footer>