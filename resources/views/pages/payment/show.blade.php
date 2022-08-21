<x-header title="Payment Receipt">

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

            <div id="result_body" class="my-2 mx-5">
                <div class="text-center" id="logo">
                    <img src="/storage/{{$settings->where('key','school.logo')->first()['value']}}" height="100"
                        width="50" alt="">
                </div>
                <div id="school-info my-3">
                    <h4 class="text-center text-uppercase" id="school-name">
                        {{$settings->where('key','school.name')->first()['value']}}
                    </h4>
                    <h5 class="text-center text-uppercase" id="school-address">
                        {{$settings->where('key','school.address')->first()['value']}}</h5>
                    <h6 class="text-center text-muted text-uppercase" id="school-motto">
                        Motto:{{$settings->where('key','school.motto')->first()['value']}}</h6>

                    <h4 class="my-4">Payment Receipt</h4>
                </div>

                <div id="student-info my-3 ">
                    <div class="row mx-auto px-5">

                        <div class="col-sm-5 row ">
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-name">Name:
                                <span>{{$payment->user->name}}</span>
                            </div>
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-class">Ref no:
                                <span>{{$payment->reference}}</span>
                            </div>
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-gender">Amount:
                                <span>{{$payment->amount}}</span>
                            </div>
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-average">Purpose:
                                <span>{{$payment->purpose}}</span>
                            </div>
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-average">On Behalf of:
                                <span>{{$payment->on_behalf}}</span>
                            </div>
                            <div class="col-sm-12 mb-3 text-uppercase" id="student-average">Paid on:
                                <span>{{$payment->payment_date}}</span>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1"></div>

                    </div>
                </div>
            </div>

            <button type="button" onclick="printme()" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generate PDF
            </button>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<x-footer motto="">
    <script src="/js/main.js"></script>
</x-footer>