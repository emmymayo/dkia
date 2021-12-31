
    <x-header title="Manage Pins" >
 
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
                     <h1 class="m-0 lead">Manage Pins</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="/pins/manage">Manage Pins</a></li>
                     </ol>
                 </div><!-- /.col -->
                 </div><!-- /.row -->
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content-header -->

             <!-- Main content -->
             <div class="content">
             <div class="container-fluid">
             <!-- Vue App -->
             <div id="manage-pins" v-cloak class="elevation-2 p-3 card" >
             <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                 style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>
             <div class="row">
             
                    

                     <div class="form-group col-md-4">
                     <label for="exam" class="">Exam</label>
                         <select v-model="selected_exam" id="section" class="form-control" >
                         <option :value="exam.id" v-for="(exam, key) in exams" :key="key">@{{exam.name}}</option>
                         </select>
                         
                     </div> 
                    

                 </div>
                 <div class="form-group">
                     <button class="btn btn-primary" @click="loadPins()" > Load Pins</button>
                 </div>
                
                 
             <!-- Vue Table -->
             <div v-show="show_pins">   
             
             <table id="" class="table table-hover small table-responsive-md" >
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Token</th>
                             <th>Units Left</th>
                             <th>...</th>
                             
                             
                         </tr>
                     </thead>
                     <tbody>
                     
                     
                      
                         
                         <tr v-for="(pin, index) in pins" :key="index" >
                         <td >@{{index+1}}</td>
                        
                         <td>@{{pin.token}}</td>
                         <td>@{{pin.units_left}}</td>
                         <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu" >
                                
                                <button class="dropdown-item" @click="revokePin('{{csrf_token()}}',pin.id)"><i class="fas fa-ban"></i> Revoke</button>
                                <button class="dropdown-item"  @click="resetPin('{{csrf_token()}}',pin.id)"><i class="fas fa-sync"></i> Reset</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger"  @click="removePin('{{csrf_token()}}',pin.id)"><i class="fas fa-trash"></i> Remove</button>
                                
                                
                                </div>
                            </div>
                         </td>
                         
                        
                         
                         
                         </tr>   
                         
                         
                         
                           
                        
                     
                     </tbody>
             </table>
             <p class="">
                            Showing @{{t_pag_from+' - '+t_pag_to+ ' of '+t_pag_total}}
                    </p>
                <div class="pagination d-inline-block">

                        <button class="btn btn-default" @click="loadPins(1)">First</button>
                        <button class="btn btn-default" v-if="(t_pag_curr-2)>1" @click="">...</button>
                        
                        <button class="btn btn-default" v-if="t_pag_curr>2" @click="loadPins(t_pag_curr-1)">@{{t_pag_curr-1}}</button>
                        <button class="btn btn-primary" @click="loadPins(t_pag_curr)">@{{t_pag_curr}}</button>
                        <button class="btn btn-default" v-if="(t_pag_curr+1)<t_pag_last" @click="loadPins(t_pag_curr+1)">@{{t_pag_curr+1}}</button>
                        
                        
                        <button class="btn btn-default" v-if="(t_pag_curr+2)<t_pag_last" @click="">...</button>
                        <button class="btn btn-default" @click="loadPins(t_pag_last)">Last</button>
                </div>
            
             </div>
             <!-- VUe table end -->

            


             </div>
             <!-- Vue App End -->
             
             
             
            
             
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content -->
         </div>
     
         <x-footer motto="" >
         <script src="/js/axios.min.js"></script>
       
         <script src="/js/vue.global.prod.js"></script>
         <script src="/js/pins.js"></script>
         

         </x-footer>