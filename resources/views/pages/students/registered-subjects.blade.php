
    <x-header title="Registered Subjects " >
        
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
                        <li class="breadcrumb-item active"><a href="#">Registered Subjects</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                <div class="my-2 p-1">

                    <table class="table table-hover small table-responsive-md  p-md-5">
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Short Name</th>
                            
                        </tr>
                        @foreach ($subjects as $subject )
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$subject->name}}</td>
                            <td>{{$subject->short_name}}</td>
                        </tr>
                        @endforeach
                        
                    </table>

                    <div>
                        Total Subjects Registered: {{$subjects->count()}}
                    </div>
                </div>
                

                
                    
               
             
                    
                  
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            
            </x-footer>
        </div>
   