

    <x-header title="Notice System " >
       
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
                           <h1 class="m-0">Notice System</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/notices">Notice</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--Notice sysytem App  -->
                   <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <div id="notice-app" v-cloak>
                    
                       <div v-show="show_notices" class="card card-default card-tabs">
                       <x-vue-loader/>
                       <div class="card-header p-0 pt-1">
                           <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                           <li class="nav-item">
                               <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#notices_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Notice</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_notice" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                               <i class="fas fa-plus"></i> Create Notice</a>
                           </li>
                           
                           </ul>
                       </div>
                       <div class="card-body">
                           <div class="tab-content" id="custom-tabs-one-tabContent">
                           <div class="tab-pane fade active show" id="notices_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                   <table class="table table-hover small table-responsive-md " id="">
                                       <thead>
                                           <tr>
                                               <th>#</th>
                                               <th>Title</th>
                                               <th>Group</th>
                                               <th>Expires</th>
                                               <th>...</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                          
                                           <tr v-for="(notice,index) in notices" :key="index">
                                               <td>@{{index+1}}</td>
                                               <td>@{{notice.title}}</td>
                                               <td>@{{notice.role.name}}s</td>
                                               <td>@{{formatDate(notice.expires_at)}}</td>
                                               
                                               <td>
                                                   <div class="btn-group">
                                                   <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                                   <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                   <span class="sr-only">Toggle Dropdown</span>
                                                   </button>
                                                   <div class="dropdown-menu" role="menu" >
                                                   <button class="dropdown-item" @click="viewNotice(notice)">View</button>
                                                   <button class="dropdown-item" @click="editNotice(notice.id)">Edit</button>
                                                   <button class="dropdown-item text-danger" @click="deleteNotice(notice.id)">Delete</button>
                                                   
                                                   
                                                   
                                                   </div>
                                                   </div>
                                               </td>
                                           
                                           </tr>
                                           
                                       </tbody>
                                   </table>
                           </div>
                           <div class="tab-pane fade" id="add_notice" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                           
                           <div class="card card-primary">
                                   <div class="card-header">
                                       <h3 class="card-title">New Notice</h3>
                                   </div>
                                   <!-- /.card-header -->
                                   <!-- form start -->
                                  
                                       <div class="card-body row">
                                       <div class="form-group col-md-6">
                                           <label for="title">Title*</label>
                                           <input required type="text" class="form-control" v-model="new_notice.title" placeholder="Enter the title of the notice">
                                       </div>
   
                                       <div class="form-group col-md-3">
                                           <label for="message">Group* </label>
                                           <select v-model="new_notice.role_id" class="form-control">
                                            <option value="">--Select Group--</option>
                                            <option v-for="(role,index) in roles" :value="role.id" :key="index">@{{role.name}}s</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-3">
                                           <label for="expires">Expires </label>
                                           <input  type="date"  class="form-control" v-model="new_notice.expires_at" >
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="message">Message*</label>
                                           <textarea v-model="new_notice.message" class="form-control" col="30"  rows="15"></textarea>
                                       </div>
                                       
                                       </div>
                                       <!-- /.card-body -->
   
                                       <div class="card-footer">
                                       <button @click="addNotice" class="btn btn-primary text-uppercase"> Create <i v-show="app_loading" class="fa fa-spinner fa-spin"></i></button>
                                       </div>
                                   
                           </div>
   
                           </div>
                           
                           </div>
                       </div>
                       <!-- /.card -->
                       </div>
   
                       <div v-show="edit_notice" class="card">
                           
                       <div class="card card-primary">
                               <div class="card-header">
                                       
                                   <button @click="closeEditNotice" class="btn btn-primary float-right ">
                                       &times;</button>
                           
                                   <h3 class="card-title">Edit Notice</h3>
                               </div>
                                   <!-- /.card-header -->
                                   <!-- form start -->
                                  
                                   <div class="card-body row">
                                       <div class="form-group col-md-6">
                                           <label for="title">Title*</label>
                                           <input required type="text" class="form-control" v-model="selected_notice.title" placeholder="Enter the title of the notice">
                                       </div>
   
                                       <div class="form-group col-md-3">
                                           <label for="message">Group* </label>
                                           <select v-model="selected_notice.role_id" class="form-control">
                                            <option value="">--Select Group--</option>
                                            <option v-for="(role,index) in roles" :value="role.id" :key="index">@{{role.name}}s</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-3">
                                           <label for="expires">Expires </label>
                                           <input  type="date"  class="form-control" v-model="selected_notice.expires_at" >
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="message">Message*</label>
                                           <textarea class="form-control" cols="100" rows="10" v-model="selected_notice.message"></textarea>
                                       </div>
                                       
                                       </div>
                                       <!-- /.card-body -->
   
                                       <div class="card-footer">
                                       <button @click="updateNotice" class="btn btn-primary">
                                               Update <i v-show="app_loading" class="fa fa-spinner fa-spin"></i>
                                       </button>
                                       </div>
                                   
                           </div>
   
                       
                       </div>

                       <div v-show="view_notice" class="card p-2">
                            <div>
                                <button @click="closeViewNotice" class="btn tbn-default float-right ">
                                       &times;</button>
                            </div>
                            <div class="">
                                <h2 class="my-3">@{{view_selected_notice.title}}</h2>
                                
                                <p class="mt-5"> @{{view_selected_notice.message}}</p>
                                <p class="text-muted"> Expires on: @{{view_selected_notice.expires_at}}</p>
                            </div>
                       
                       
                       </div>
                       </div>
                           
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                   <script src="/js/axios.min.js"></script>
          
                   <script src="/js/vue.global.prod.js"></script>
                   <script src="/js/notice.js"></script>
               </x-footer>
           
     