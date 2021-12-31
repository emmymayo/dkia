

    <x-header title="Notices " >
       
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
                           <h1 class="m-0">Notices</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/notices/list">Notices</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--Notices  -->

                   <div class="">
                    @if($notices->count()==0)
                        <p>No new notice has been published. </p>
                    @endif
                   @foreach ($notices as $notice)
                   <div class=" card my-2 p-3">
                        <a href="/notices/{{$notice->id}}">
                            <h3 class="lead text-info">
                            <i class="fas fa-bullhorn"></i> {{$notice->title}}
                            </h3>
                        </a>
                        <span> <i class="far fa-clock"></i> {{\Carbon\Carbon::parse($notice->updated_at)->diffForHumans()}}</span>
                   </div>
                       
                   @endforeach
                   
                   </div>
                   
                    
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                 
               </x-footer>
           
     