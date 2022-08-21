<x-header title="Dashboard ">
    <link rel="stylesheet" href="/plugins/fullcalendar/main.css">
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
                    <h1 class="m-0 lead">Dashboard </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><a href="/dashboard">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid ">

            <div class="card card-outline card-primary"></div>
            <div class="row  my-2 ">
                <div class="col-md-12 text-right mx-auto my-2   text-center">

                    <span id="dashTime" class="font-weight-light h3 "></span> <br>
                    <span id="dashDate" class="font-weight-light h3 "></span> <br>
                    @can('student-only')
                    @if(!empty($my_section))
                    <span class="my-2 font-weight-bold h3 ">{{$my_section->classes->name.' '. $my_section->name}}</span>
                    @endif
                    @endcan
                </div>
            </div>
            @can('admin-only')
            <x-info-box />
            @endcan
            @can('student-only')
            <div class="row my-5">
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-success shadow bg-white">
                    <a href="/attendances/student/view" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-chart-pie fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>My Attendance</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-danger shadow bg-white">
                    <a href="/exams/report/checker/student" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-file-invoice fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Check Result</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 rounded mb-2 mx-auto  col-sm-6 col-12 card-outline card-info shadow bg-white">
                    <a href="/students/subjects/register" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-book fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Register Subject</h3>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            @endcan
            @can('admin-only')
            <div class="row my-5">
                <div class="col-md-3 rounded mb-2  mx-auto col-sm-6 col-12 card-outline card-success shadow bg-white">
                    <a href="/admins" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-user-cog fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Admins</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-danger shadow bg-white">
                    <a href="/teachers" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-user-tie fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Teachers</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 rounded mb-2 mx-auto  col-sm-6 col-12 card-outline card-info shadow bg-white">
                    <a href="/students/create" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-user-graduate fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Admit Student</h3>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            @endcan
            @can('admin-and-teacher-only')
            <div class="row my-5">
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-primary shadow bg-white">
                    <a href="/attendances/roll/call" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-check fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Roll Call</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-success shadow bg-white">
                    <a href="/exams-registration" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-file-contract fa-3x"></i></span>

                            <div class=" text-muted">
                                <h3>Exam Registration</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2 rounded mx-auto  col-sm-6 col-12 card-outline card-danger shadow bg-white">
                    <a href="/promotions" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-forward fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Promotion</h3>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            @endcan

            @can('admin-only')
            <div class="row my-5">
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-success shadow bg-white">
                    <a href="/students" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-users fa-3x"></i></span>

                            <div class=" text-muted">
                                <h3>Student Management</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 rounded mb-2 mx-auto col-sm-6 col-12 card-outline card-warning shadow bg-white">
                    <a href="/pins/generate" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-key fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Generate Pin</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 rounded mb-2 mx-auto  col-sm-6 col-12 card-outline card-danger shadow bg-white">
                    <a href="/settings" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-cog fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Settings</h3>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
            @endcan

            <div class="row my-5">
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-success shadow bg-white">
                    <a href="/payment/create" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-money-bill fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Payment</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2 rounded  mx-auto col-sm-6 col-12 card-outline card-info shadow bg-white">
                    <a href="/profile" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fas fa-user-edit fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Profile</h3>
                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-3 rounded mb-2 mx-auto col-sm-6 col-12 card-outline card-danger shadow bg-white">
                    <a href="/logout" class="">
                        <div class="text-center justify-content-center  p-4">

                            <span class="text-center text-muted"><i class="fa fa-sign-out-alt fa-3x"></i></span>

                            <div class="text-muted">
                                <h3>Logout</h3>
                            </div>

                        </div>
                    </a>
                </div>

            </div>

            <hr>

            <div id="calendar" class="text-muted bg-white rounded card card-outline card-primary shadow  "></div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<x-footer motto="">
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/plugins/fullcalendar/main.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
</x-footer>
</div>
</body>

</html>