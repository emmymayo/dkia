

    <x-header title="E-Class System " >
       
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
                           <h1 class="m-0">E-Class System</h1>
                       </div><!-- /.col -->
                       <div class="col-sm-6">
                           <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                           <li class="breadcrumb-item active"><a href="/e-classes">E-Class System</a></li>
                           </ol>
                       </div><!-- /.col -->
                       </div><!-- /.row -->
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content-header -->
   
                   <!-- Main content -->
                   <div class="content">
                   <div class="container-fluid">
                   
                       
                  
                   
                   <!--E Class sytem App  -->
                   <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <div id="e-class-app" v-cloak>
                    
                       <div v-show="show_eclasses" class="card card-default card-tabs">
                       <x-vue-loader/>
                       <div class="card-header p-0 pt-1">
                           <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                           <li class="nav-item">
                               <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#e-classes_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                               E-Classes</a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_e-class" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                               <i class="fas fa-plus"></i> Create E-class</a>
                           </li>
                           
                           </ul>
                       </div>
                       <div class="card-body">
                           <div class="tab-content" id="custom-tabs-one-tabContent">
                           <div class="tab-pane fade active show" id="e-classes_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                   <div class = "row">
                                        <div class="form-group col-md-4">
                                           <label for="">Class* </label>
                                           <select v-model="selected_class" class="form-control">
                                            <option value="">--Select Class--</option>
                                            <option v-for="(each_class,index) in classes" :value="each_class.id" :key="index">@{{each_class.name}}</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="">Section* </label>
                                           <select v-model="selected_section" class="form-control">
                                            <option value="">--Select Section--</option>
                                            <option v-for="(section,index) in sections" :value="section.id" :key="index">@{{section.name}}</option>
                                           </select>
                                       </div>
                                       
                                   </div>
                                   <div class="">
                                            <button class="btn btn-primary" @click="LoadSectionEClasses">Load E-classes</button>
                                    </div>
                                   
                                   
                                   <table v-if="eclasses.data.length>0" class="table table-striped small table-responsive-md " id="">
                                       <thead>
                                           <tr>
                                               <th>#</th>
                                               <th>Topic</th>
                                               <th>Time</th>
                                               <th>Duration (mins)</th>
                                               <th>...</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                          
                                           <tr v-for="(eclass,index) in eclasses.data" :key="index">
                                               <td>@{{index+1}}</td>
                                               <td>@{{eclass.topic}}</td>
                                               <td>@{{formatDate(eclass.start_time)}}</td>
                                               <td>@{{eclass.duration}}</td>
                                               
                                               <td>
                                                   <div class="btn-group">
                                                   <!-- <button type="button" class="btn btn-default" > </button> -->
                                                   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                   <span class="sr-only">Toggle Dropdown</span> ...
                                                   </button>
                                                   <div class="dropdown-menu" role="menu" >
                                                   <button class="dropdown-item" @click="start(eclass.id)">Start Class</button>
                                                   <button class="dropdown-item" @click="join(eclass.join_url)">Join Class</button>
                                                   <button class="dropdown-item" @click="copyJoinLink(eclass.join_url)">Copy Join Link</button>
                                                   <button class="dropdown-item" @click="copyPassword(eclass.password)">Copy Password</button>
                                                   <button class="dropdown-item" @click="edit(eclass.id)">Edit</button>
                                                   <button class="dropdown-item text-danger" @click="deleteEClass(eclass.id)">Delete</button>
                                                   
                                                   
                                                   
                                                   </div>
                                                   </div>
                                               </td>
                                           
                                           </tr>
                                           
                                       </tbody>
                                   </table>
                                   <p v-if="eclasses.data.length==0" class="my-2">No record available.</p>
                                   <p v-if="eclasses.data.length>0" class="">
                                            Showing @{{eclasses.from+' - '+eclasses.to+ ' of '+eclasses.total}}
                                    </p>
                                    <div v-if="eclasses.data.length>0" class="pagination d-inline-block">

                                            <button class="btn btn-default" @click="getSectionEClasses(1)">First</button>
                                            <button class="btn btn-default" v-if="(eclasses.current_page-2)>1" @click="">...</button>
                                            
                                            <button class="btn btn-default" v-if="eclasses.current_page>2" @click="getSectionEClasses(eclasses.current_page-1)">@{{eclasses.current_page-1}}</button>
                                            <button class="btn btn-primary" @click="getSectionEClasses(eclasses.current_page)">@{{eclasses.current_page}}</button>
                                            <button class="btn btn-default" v-if="(eclasses.current_page+1)<eclasses.last_page" @click="getSectionEClasses(eclasses.current_page+1)">@{{eclasses.current_page+1}}</button>
                                            
                                            
                                            <button class="btn btn-default" v-if="(eclasses.current_page+2)<eclasses.last_page" @click="">...</button>
                                            <button class="btn btn-default" @click="getSectionEClasses(eclasses.last_page)">Last</button>
                                    </div>
                           </div>

                           <div class="tab-pane fade" id="add_e-class" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                           
                           <div class="card card-primary">
                                   <div class="card-header">
                                       <h3 class="card-title">New E-class</h3>
                                   </div>
                                   <!-- /.card-header -->
                                   <!-- form start -->
                                  
                                       <div class="card-body row">
                                       <div class="form-group col-md-6">
                                           <label for="title">Topic*</label>
                                           <input required type="text" class="form-control" v-model="new_eclass.topic" placeholder="Enter the topic for the class">
                                       </div>
   
                                       <div class="form-group col-md-3">
                                           <label for="">Class* </label>
                                           <select v-model="selected_new_class" class="form-control">
                                            <option value="">--Select Class--</option>
                                            <option v-for="(each_class,index) in classes" :value="each_class.id" :key="index">@{{each_class.name}}</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-3">
                                           <label for="">Section* </label>
                                           <select v-model="new_eclass.section_id" class="form-control">
                                            <option value="">--Select Section--</option>
                                            <option v-for="(section,index) in new_sections" :value="section.id" :key="index">@{{section.name}}</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="">Start Time* </label>
                                           <input  type="datetime-local" min="{{now()->format('Y-m-d').'T'.now()->format('h:i')}}"  class="form-control" v-model="new_eclass.start_time" >
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="">Password* </label>
                                           <input  type="password"  class="form-control" v-model="new_eclass.password" >
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="">Duration*</label>
                                           <select v-model="new_eclass.duration" class="form-control">
                                            <option value="">--Select Duration--</option>
                                            <option :value="30" >30 minutes</option>
                                            <option :value="40" >40 minutes</option>
                                            <!-- <option :value="60" >1 Hour</option>
                                            <option :value="90" >1 hour 30 minutes</option>
                                            <option :value="105" >1 hour 45 minutes</option>
                                            <option :value="120" >2 hours</option>
                                             <option :value="150" >2 hours 30 minutes</option>
                                            <option :value="165" >2 hours 45 minutes</option>  -->
                                           </select>
                                       </div>
                                       
                                       </div>
                                       <!-- /.card-body -->
   
                                       <div class="card-footer">
                                       <button @click="create" class="btn btn-primary text-uppercase"> Create <i v-show="app_loading" class="fa fa-spinner fa-spin"></i></button>
                                       </div>
                                   
                           </div>
   
                           </div>
                           
                           </div>
                       </div>
                       <!-- /.card -->
                       </div>
   
                       <div v-show="edit_eclass" class="card">
                           
                       <div class="card card-primary">
                               <div class="card-header">
                                       
                                   <button @click="closeEditEClass" class="btn btn-primary float-right ">
                                       &times;</button>
                           
                                   <h3 class="card-title">Edit E-Class</h3>
                               </div>
                                   <!-- /.card-header -->
                                   <!-- form start -->
                                  
                                   <div class="card-body row">
                                       <div class="form-group col-md-6">
                                           <label for="title">Topic</label>
                                           <input required type="text" class="form-control" v-model="selected_eclass.topic" placeholder="Enter the topic for the class">
                                       </div>
   
                                       <div class="form-group col-md-3">
                                           <label for="">Class </label>
                                           <select v-model="selected_edit_class" class="form-control">
                                            <option value="">--Select Class--</option>
                                            <option v-for="(each_class,index) in classes" :selected="each_class.id==selected_eclass.section.classes_id"  :value="each_class.id" :key="index">@{{each_class.name}}</option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-3">
                                           <label for="">Section </label>
                                           <select v-model="selected_eclass.section_id" class="form-control">
                                            <option value="">--Select Section--</option>
                                            <option v-for="(section,index) in edit_sections" :value="section.id" :key="index">@{{section.name}}</option>
                                           </select>
                                       </div>
                                       
                                       <div class="form-group col-md-6">
                                           <label for="">Start Time <span class="small">@{{formatDate(selected_eclass.start_time)}}</span> </label>
                                           <input  type="datetime-local"  min="{{now()->format('Y-m-d').'T'.now()->format('h:i')}}"  class="form-control" v-model="selected_eclass.start_time" >
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="">Password </label>
                                           <input  type="password"  class="form-control" v-model="selected_eclass.password" >
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="">Duration</label>
                                           <select v-model="selected_eclass.duration" class="form-control">
                                            <option value="">--Select Duration--</option>
                                            <option :value="30" >30 minutes</option>
                                            <option :value="40" >40 minutes</option>
                                            <!-- <option :value="60" >1 Hour</option>
                                            <option :value="90" >1 hour 30 minutes</option>
                                            <option :value="105" >1 hour 45 minutes</option>
                                            <option :value="120" >2 hours</option>
                                             <option :value="150" >2 hours 30 minutes</option>
                                            <option :value="165" >2 hours 45 minutes</option>  -->
                                           </select>
                                       </div>
                                       
                                       </div>
                                       <!-- /.card-body -->
   
                                       <div class="card-footer">
                                       <button @click="update" class="btn btn-primary text-uppercase">
                                               Update <i v-show="app_loading" class="fa fa-spinner fa-spin"></i>
                                       </button>
                                       </div>
                                   
                           </div>
   
                       
                       </div>
                        <!-- 
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
                        -->
                       </div>
                           
                      
                       
                   </div><!-- /.container-fluid -->
                   </div>
                   <!-- /.content -->
               </div>
           
               <x-footer motto="" >
                   <script src="/js/axios.min.js"></script>
          
                   <script src="/js/vue.global.prod.js"></script>
                   <script src="/js/e-class.js"></script>
               </x-footer>
           
     