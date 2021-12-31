

    <x-header title="Notice " >
       
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
                           <h1 class="m-0">Notice</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/notices/list">Notices</a></li>
                           <li class="breadcrumb-item active"><a href="/notices/{{$notice->id}}">{{$notice->title}}</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--Notice  -->

                   <div class="card p-3">

                   <div class="">
                        
                            <h3 class="my-3">
                                {{$notice->title}}
                            </h3>

                        
                        <span class=""> <i class="far fa-clock"></i> {{\Carbon\Carbon::parse($notice->updated_at)->diffForHumans()}}</span>

                        <p class="my-5">
                            {{$notice->message}}
                        </p>
                   </div>
                  
                   
                   </div>
                   
                    
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                 
               </x-footer>
           
     