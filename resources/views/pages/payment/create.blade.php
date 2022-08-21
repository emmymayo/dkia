<x-header title="Payment">

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

            <div class="card m-5">
                <div class="card-header">
                    <h1>Make Payment</h1>
                </div>
                <div class="card-body">
                    <form class="form flex flex-col" action="{{route('save_payment')}}" method="POST">
                        {{ csrf_field() }}
                        <input class="form-control form-control-lg" type="text" name="purpose" id="purpose"
                            placeholder="Purpose"> <br>
                        <input class="form-control form-control-lg" type="number" name="amount" id="amount"
                            placeholder="Amount"> <br>
                        <input class="form-control form-control-lg" type="text" name="on_behalf" id="on_behalf"
                            placeholder="On Behalf"> <br>

                        <button class="btn btn-success" type="submit">Proceed</button>
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<x-footer motto="">

</x-footer>