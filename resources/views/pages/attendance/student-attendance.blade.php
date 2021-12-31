

    <x-header title="Student Attendance " >
        <link rel="stylesheet" href="/plugins/fullcalendar/main.css">
    </x-header>
  
  
            
            <x-nav-header />
            <x-sidebar-nav   />
            <x-sidebar-control /> 
            

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 lead">My Attendance</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="#">Student Attendance</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                    
                    
                    <div id="student-attendance" class="my-5 bg-white rounded card card-outline card-primary shadow mx-md-5 ">
                        
                    </div>
                    <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
            <script src="/plugins/fullcalendar/main.js"></script>
            <script src="/plugins/moment/moment.min.js"></script>
            </x-footer>
        </div>
    </body>

</html>