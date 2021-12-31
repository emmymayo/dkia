
    <x-header title="Add Student" >
        
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
                        <h1 class="m-0">Add Student</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/teachers/create">Add Student</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                    
            <livewire:admit-student />
                    
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>


        <x-footer motto="">
            <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
                <script>
                    $(function () {
                    bsCustomFileInput.init();
                    });
                </script>
        </x-footer>
  