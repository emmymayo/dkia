

    <x-header title="My E-Classes " >
       
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
                           <h1 class="m-0 lead">My E-Classes</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/students/me/e-classes">My E-Classes</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                    <div class="card p-3 mx-auto">
                        
                        <table class="table small table-responsive-md   ">
                            <tr>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Starts</th>
                                <th>Duration (mins)</th>
                                <th>...</th>

                            </tr>
                            @foreach ($eclasses as $eclass )
                            <tr >
                                <td>{{$loop->index+1}}</td>
                                <td>{{$eclass->topic}}</td>
                                <td>{{\Carbon\Carbon::parse($eclass->start_time)->format("D, jS M, Y. h:ia")}} <br>
                                {{\Carbon\Carbon::parse($eclass->start_time)->diffForHumans()}}
                                </td>
                                <td>{{$eclass->duration}}</td>
                                <td><a href="{{$eclass->join_url}}" target="_blank"><i class="fa fa-users"></i> Join Class</a></td>
                            </tr>
                            @endforeach
                            
                        </table>

                        <div>
                           {{$eclasses->links();}} 
                        </div>
                    </div>
                   
                  
                    
                           
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                   
               </x-footer>
           
     