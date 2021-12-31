
    <x-header title="Students " >
         <!-- DataTables -->
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </x-header>
    
            
            <x-nav-header />
            <x-sidebar-nav  />
            <x-sidebar-control />
           

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Students</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/students">Students</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                <div> <a href="/students/create" class="btn btn-app bg-blue "><i class="fas fa-user-plus"></i> Admit Student</a></div>
                <br>
                    
               
                
                <livewire:section-students />
                    
                  
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <script src="/plugins/jszip/jszip.min.js"></script>
            <script src="/plugins/pdfmake/pdfmake.min.js"></script>
            <script src="/plugins/pdfmake/vfs_fonts.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
            </x-footer>
        </div>
   