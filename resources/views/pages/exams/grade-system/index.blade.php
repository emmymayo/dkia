

    <x-header title="Grade System " >
       
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
                        <h1 class="m-0">Grade System</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/gradesystems">Grade System</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                
                    
               
                
                <!--Grade sysytem App  -->
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                 <div id="grade-system" v-cloak>
                 
                    <div v-show="show_gradesystems" class="card card-default card-tabs">
                    <x-vue-loader/>
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#grades_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Grade Keys</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_grade" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                            <i class="fas fa-plus"></i> Add Grade</a>
                        </li>
                        
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="grades_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <table class="table  table-responsive-md small " id="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Grade</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Remark</th>
                                            <th>...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        <tr v-for="(grade_system,index) in grade_systems" :key="index">
                                            <td>@{{index+1}}</td>
                                            <td>@{{grade_system.grade}}</td>
                                            <td>@{{grade_system.from}}</td>
                                            <td>@{{grade_system.to}}</td>
                                            <td>@{{grade_system.remark}}</td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" >
                                                <button class="dropdown-item" @click="editGradeSystem(grade_system.id)">Edit</button>
                                                <button class="dropdown-item text-danger" @click="deleteGradeSystem(grade_system.id)">Delete</button>
                                                
                                                
                                                
                                                </div>
                                                </div>
                                            </td>
                                        
                                        </tr>
                                        
                                    </tbody>
                                </table>
                        </div>
                        <div class="tab-pane fade" id="add_grade" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        
                        <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">New Grade System</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                               
                                    <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label for="grade">Grade</label>
                                        <input required type="text" class="form-control" v-model="new_gradesystem.grade" placeholder="A">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="from">From </label>
                                        <input  type="number" step="0.1" class="form-control" v-model="new_gradesystem.from"  placeholder="40">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="from">To <span class="small text-mute">Should be greater than "From"</span></label>
                                        <input  type="number" step="0.1" class="form-control" v-model="new_gradesystem.to"  placeholder="50 ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="remark">Remark</label>
                                        <input required type="text" class="form-control" v-model="new_gradesystem.remark" placeholder="Excellent">
                                    </div>
                                    
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                    <button @click="addGradeSystem" class="btn btn-primary"> Add <i v-show="app_loading" class="fa fa-spinner fa-spin"></i></button>
                                    </div>
                                
                        </div>

                        </div>
                        
                        </div>
                    </div>
                    <!-- /.card -->
                    </div>

                    <div v-show="edit_gradesystem" class="card">
                        
                    <div class="card card-primary">
                            <div class="card-header">
                                    
                                <button @click="closeEditGradeSystem" class="btn btn-primary float-right ">
                                    &times;</button>
                        
                                <h3 class="card-title">Edit Grade System</h3>
                            </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                               
                                    <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label for="grade">Grade</label>
                                        <input required type="text" class="form-control" v-model="selected_gradesystem.grade" placeholder="A">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="from">From </label>
                                        <input  type="number" step="0.1" class="form-control" v-model="selected_gradesystem.from"  placeholder="40">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="from">To </label>
                                        <input  type="number" step="0.1" class="form-control" v-model="selected_gradesystem.to"  placeholder="40">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="remark">Remark</label>
                                        <input required type="text" class="form-control" v-model="selected_gradesystem.remark" placeholder="Excellent">
                                    </div>
                                    
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                    <button @click="updateGradeSystem" class="btn btn-primary">
                                            Update <i v-show="app_loading" class="fa fa-spinner fa-spin"></i>
                                    </button>
                                    </div>
                                
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
                <script src="/js/broadsheet-grade.js"></script>
            </x-footer>
        
  