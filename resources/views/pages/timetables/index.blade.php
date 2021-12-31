
    <x-header title="Timetables" >
 
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
                     <h1 class="m-0 lead">Timetables</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="/timetables">Timetables</a></li>
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
             <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
             <div id="school-timetable" v-cloak class="elevation-2 p-3 card" >
                <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                    style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i>
                </div>
             
                <div v-show="show_timetables" class="">
                    <div>
                        
                        <button @click="newTimetable" type="button" class="btn btn-primary btn-app " >
                            <i class="fa fa-calendar-plus"></i>
                            Add Timetable
                        </button>
                    
                        @can('admin-and-teacher-only')
                        <button @click="openTimeslots" class="btn btn-success btn-app "><i class="fa fa-clock"></i> Time Slots</button>
                        @endcan
                    </div>
                    <table class="table table-hover small table-responsive-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>For</th>
                                
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(timetable,index) in timetables.data" :key="index">
                                <td>@{{index+1}}</td>
                                <td>@{{timetable.name}}</td>
                                <td>
                                    <span v-if="timetable.scheduleable.classes!==undefined">
                                        @{{timetable.scheduleable.classes.name}}
                                    </span>
                                    @{{timetable.scheduleable.name}} 
                                </td>
                            
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                        <button class="dropdown-item"  @click="loadEntries(timetable)"><i class="fas fa-pen"></i> Manage Entries</button>
                                        <button class="dropdown-item"  @click="editTimetable(timetable.id)"><i class="fas fa-edit"></i> Edit</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger"  @click="deleteTimetable(timetable.id)"><i class="fas fa-trash"></i> Remove</button>
                                        
                                        
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="">
                                Showing @{{timetables.from+' - '+timetables.to+ ' of '+timetables.total}}
                        </p>
                    <div class="pagination d-inline-block">

                            <button class="btn btn-default" @click="getTimetables(1)">First</button>
                            <button class="btn btn-default" v-if="(timetables.current_page-2)>1" @click="">...</button>
                            
                            <button class="btn btn-default" v-if="timetables.current_page>2" @click="getTimetables(timetables.current_page-1)">@{{timetables.current_page-1}}</button>
                            <button class="btn btn-primary" @click="getTimetables(timetables.current_page)">@{{timetables.current_page}}</button>
                            <button class="btn btn-default" v-if="(timetables.current_page+1)<timetables.last_page" @click="getTimetables(timetables.current_page+1)">@{{timetables.current_page+1}}</button>
                            
                            
                            <button class="btn btn-default" v-if="(timetables.current_page+2)<timetables.last_page" @click="">...</button>
                            <button class="btn btn-default" @click="getTimetables(timetables.last_page)">Last</button>
                    </div>

                </div>
                <!--Timetables End -->
                <!-- Edit Timetable -->
                <div v-show="show_edit_timetable">
                    <div class="my-2">
                        <button class="float-right btn border rounded-circle" @click="closeEditTimetable">&times;</button>
                        <h4>Edit Timetable</h4>
                    </div>
                    <div class="my-2">
                        <div class="form-group">
                            <label for="">Timetable Name</label>
                            <input class="form-control" type="text"  v-model="selected_timetable.data.name">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Type</label>
                            <select class="form-control" v-model="selected_timetable.data.scheduleable_type">
                                <option value=""></option>
                                <option value="sections">Class Timetable</option>
                                <option value="exams">Exam Timetable</option>
                            </select>
                        </div>

                        <!-- Conditional rendering for types of timetables -->
                        <template class="form-group my-2" v-if="selected_timetable.data.scheduleable_type=='sections'">
                            <label for="">Timetable for</label>
                            <div class="row">
                            <select v-model="selected_class" class="form-control col-md-6">
                                <option selected value="">--Select Class--</option>
                                <option v-for="(each_class,index) in classes" :value="each_class.id">@{{each_class.name}}</option>
                            </select>
                            <select v-model="selected_timetable.data.scheduleable_id" class="form-control col-md-6">
                                <option selected value="">--Select Section--</option>
                                <option v-for="(section,index) in sections" :value="section.id">@{{section.name}}</option>
                            </select>
                            </div>
                            
                        </template>
                        
                        <template class="my-2" v-if="selected_timetable.data.scheduleable_type=='exams'">
                            <label for="">Timetable for</label>
        
                            <select v-model="selected_timetable.data.scheduleable_id" class="form-control">
                                <option selected value="">--Select Exam--</option>
                                <option v-for="(exam,index) in exams" :value="exam.id">@{{exam.name}}</option>
                            </select>
                        </template>
                        <template v-if="selected_timetable.data.scheduleable_type==''">
                            <input type="hidden" value="" v-model="selected_timetable.scheduleable_id">
                        </template>

                    
                        <div class="my-3">
                            <button class="btn btn-success" @click="updateTimetable">Update</button>
                            <button class="ml-3 btn btn-default" @click="closeEditTimetable">Cancel</button>
                        </div>
                        
                    </div>
                </div>
                <!-- End of Edit Timetable -->
                <!-- Add Timetable -->
                <div v-show="show_add_timetable">
                <div class="my-2">
                    <button class="float-right btn border rounded-circle" @click="closeAddTimetable">&times;</button>
                    <h4>Add Timetable</h4>
                </div>
                    <div class="">
                        <div class="form-group">
                            <label for="">Timetable Name</label>
                            <input class="form-control" type="text"  v-model="new_timetable.name">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Type</label>
                            <select class="form-control" v-model="new_timetable.scheduleable_type">
                                <option value=""></option>
                                <option value="sections">Class Timetable</option>
                                <option value="exams">Exam Timetable</option>
                            </select>
                        </div>

                        <!-- Conditional rendering for types of timetables -->
                        <template class="form-group my-2" v-if="new_timetable.scheduleable_type=='sections'">
                            <label for="">Timetable for</label>
                            <div class="row">
                            <select v-model="selected_class" class="form-control col-md-6">
                                <option selected value="">--Select Class--</option>
                                <option v-for="(each_class,index) in classes" :value="each_class.id">@{{each_class.name}}</option>
                            </select>
                            <select v-model="new_timetable.scheduleable_id" class="form-control col-md-6">
                                <option selected value="">--Select Section--</option>
                                <option v-for="(section,index) in sections" :value="section.id">@{{section.name}}</option>
                            </select>
                            </div>
                            
                        </template>
                        
                        <template class="my-2" v-if="new_timetable.scheduleable_type=='exams'">
                            <label for="">Timetable for</label>
        
                            <select v-model="new_timetable.scheduleable_id" class="form-control">
                                <option selected value="">--Select Exam--</option>
                                <option v-for="(exam,index) in exams" :value="exam.id">@{{exam.name}}</option>
                            </select>
                        </template>
                        <template v-if="new_timetable.scheduleable_type==''">
                            <input type="hidden" value="" v-model="new_timetable.scheduleable_id">
                        </template>

                    
                        <div class="my-3">
                            <button class="btn btn-success" @click="addTimetable">Add</button>
                            <button class="ml-3 btn btn-default" @click="closeAddTimetable">Cancel</button>
                        </div>
                        
                    </div>
                </div>
                <!-- End of Add Timetable -->

                <!-- Timetable Entries -->
                <div v-show="show_entries">
                    <div class="my-3">
                            <button class="float-right btn border rounded-circle" @click="closeEntries">&times;</button>
                            <h4>Timetable Entries <span v-if="entry_timetable.name!=null">for @{{entry_timetable.name}}</span> </h4>
                    </div>
                    <div>
                        
                        <button @click="newEntry" type="button" class="btn btn-primary  " >
                            New Entry
                        </button>
                       
                    </div>
                    <table class="table table-hover small table-responsive-md my-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Day</th>
                                <th>Entry</th>
                                <th>Time Slot</th>
                                
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(entry,index) in entries.data" :key="index">
                                <td>@{{index+1}}</td>
                                <td>@{{entry.day}}</td>
                                <td> @{{entry.entry}} </td>
                                <td>@{{entry.timetable_timeslot.name}}: @{{entry.timetable_timeslot.from}} - @{{entry.timetable_timeslot.to}} </td>
                            
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                       
                                        <button class="dropdown-item"  @click="editEntry(entry.id)"><i class="fas fa-edit"></i> Edit</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger"  @click="deleteEntry(entry.id)"><i class="fas fa-trash"></i> Remove</button>
                                        
                                        
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="">
                                Showing @{{entries.from+' - '+entries.to+ ' of '+entries.total}}
                        </p>
                    <div class="pagination d-inline-block">

                            <button class="btn btn-default" @click="getEntries(1)">First</button>
                            <button class="btn btn-default" v-if="(entries.current_page-2)>1" @click="">...</button>
                            
                            <button class="btn btn-default" v-if="entries.current_page>2" @click="getEntries(entries.current_page-1)">@{{entries.current_page-1}}</button>
                            <button class="btn btn-primary" @click="getEntries(entries.current_page)">@{{entries.current_page}}</button>
                            <button class="btn btn-default" v-if="(entries.current_page+1)<entries.last_page" @click="getEntries(entries.current_page+1)">@{{entries.current_page+1}}</button>
                            
                            
                            <button class="btn btn-default" v-if="(entries.current_page+2)<entries.last_page" @click="">...</button>
                            <button class="btn btn-default" @click="getEntries(entries.last_page)">Last</button>
                    </div>
                    
                </div>

                <!-- Add Timeslots -->
                <div v-show="show_add_entry">
                    <div class="my-2">
                        <button class="float-right btn border rounded-circle" @click="closeAddEntry">&times;</button>
                        <h4>Add Timetable Entry</h4>
                    </div>
                    
                    <div class="my-3">
                        <div class="form-group">
                            <label for="">Day/Date</label>
                            <template v-if="entry_timetable.scheduleable_type=='sections'">
                                <select class="form-control" v-model="new_entry.day">
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </template>
                            <template v-if="entry_timetable.scheduleable_type=='exams'">
                                <input class="form-control" type="date" v-model="new_entry.date">
                            </template>
                            

                        </div>
                        <div class="form-group">
                            <label for="">Entry</label>
                            <input v-model="new_entry.entry" type="text" class="form-control" placeholder="Maths">
                        </div>
                        <div class="form-group">
                            <label for="">Time Slot</label>
                            <select v-model="new_entry.timeslot_id" class="form-control">
                                <option value="">--Select Timeslot--</option>
                                <option v-for="(timeslot, index) in entry_timeslots" :key="index" :value="timeslot.id">
                                @{{timeslot.name}}: @{{timeslot.from}} - @{{timeslot.to}}
                                </option>
                            </select>
                        </div>
                        
                        

                        <div>
                            <button class="btn btn-success " @click="addEntry"> Update </button>
                            <button class="btn btn-default ml-2" @click="closeAddEntry"> Cancel </button>
                        </div>
                        

                        
                    </div>
                </div>
                <!-- End of Edit Timeslots -->
                <!-- Edit Timeslots -->
                <div v-show="show_edit_entry">
                    <div class="my-2">
                        <button class="float-right btn border rounded-circle" @click="closeEditEntry">&times;</button>
                        <h4>Edit Timetable Entry</h4>
                    </div>
                    
                    <div class="my-3">
                        <div class="form-group">
                            <label for="">Day</label>
                            <template v-if="entry_timetable.scheduleable_type=='sections'">
                                <select class="form-control" v-model="selected_entry.day">
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </template>
                            <template v-if="entry_timetable.scheduleable_type=='exams'">
                                <input class="form-control" type="date" v-model="selected_entry.date">
                            </template>
                            
                        </div>
                        <div class="form-group">
                            <label for="">Entry</label>
                            <input v-model="selected_entry.entry" type="text" class="form-control" placeholder="Maths">
                        </div>
                        <div class="form-group">
                            <label for="">Time Slot</label>
                            <select v-model="selected_entry.timetable_timeslot_id" class="form-control">
                                <option value="">--Select Timeslot--</option>
                                <option v-for="(timeslot, index) in entry_timeslots" :key="index" :value="timeslot.id">
                                @{{timeslot.name}}: @{{timeslot.from}} - @{{timeslot.to}}
                                </option>
                            </select>
                        </div>
                        
                        

                        <div>
                            <button class="btn btn-success " @click="updateEntry"> Update </button>
                            <button class="btn btn-default ml-2" @click="closeEditEntry"> Cancel </button>
                        </div>
                        

                        
                    </div>
                </div>
                <!-- End of Edit Timeslots -->

                <!-- End of Timetable Entries -->

                <!-- Timeslots -->
                <div v-show="show_timeslots">
                    <div class="my-2">
                        <button class="float-right btn border rounded-circle" @click="closeTimeslots">&times;</button>
                        <h4>Time Slots</h4>
                    </div>

                    <div class="">
                    <br>
                        <button  @click="newTimeslot" class="btn btn-primary ">New Timeslot</button>
                        
                    </div>
                    <table class="table table-hover small table-responsive-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>From</th>
                                <th>To</th>
                                
                                
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(timeslot,index) in timeslots.data" :key="index">
                                <td>@{{index+1}}</td>
                                <td>@{{timeslot.name}}</td>
                                <td>@{{timeslot.from}} </td>
                                <td>@{{timeslot.to}} </td>
                                
                            
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                        
                                        <button class="dropdown-item"  @click="editTimeslot(timeslot.id)"><i class="fas fa-edit"></i> Edit</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger"  @click="deleteTimeslot(timeslot.id)"><i class="fas fa-trash"></i> Remove</button>
                                        
                                        
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="">
                                Showing @{{timeslots.from+' - '+timeslots.to+ ' of '+timeslots.total}}
                        </p>
                    <div class="pagination d-inline-block">

                            <button class="btn btn-default" @click="getTimeslots(1)">First</button>
                            <button class="btn btn-default" v-if="(timeslots.current_page-2)>1" @click="">...</button>
                            
                            <button class="btn btn-default" v-if="timeslots.current_page>2" @click="getTimeslots(timeslots.current_page-1)">@{{timeslots.current_page-1}}</button>
                            <button class="btn btn-primary" @click="getTimeslots(timeslots.current_page)">@{{timeslots.current_page}}</button>
                            <button class="btn btn-default" v-if="(timeslots.current_page+1)<timeslots.last_page" @click="getTimeslots(timeslots.current_page+1)">@{{timeslots.current_page+1}}</button>
                            
                            
                            <button class="btn btn-default" v-if="(timeslots.current_page+2)<timeslots.last_page" @click="">...</button>
                            <button class="btn btn-default" @click="getTimeslots(timeslots.last_page)">Last</button>
                    </div>


                
                </div>

                <!-- Add Timeslots -->
                <div v-show="show_add_timeslot" class=" ">
                    <div class="">
                        
                        <button class="float-right btn border rounded-circle" @click="closeAddTimeslot">&times;</button>
                        <h6 class="lead">New Time Slot</h6>
                    </div>
                
                    <div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input v-model="new_timeslot.name" type="text" class="form-control" placeholder="Period 1">
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">From</label>
                                <input v-model="new_timeslot.from" type="time" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">To</label>
                                <input v-model="new_timeslot.to" type="time" class="form-control" >
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-success " @click="addTimeslot"> Add </button>
                            <button class="btn btn-default ml-2" @click="closeAddTimeslot"> Cancel </button>
                        </div>
                        

                        
                    </div>
                </div>
                <!-- End of Add Timeslots -->
                       
                

               <!-- Edit Timeslots -->
                <div v-show="show_edit_timeslot">
                    <div class="my-2">
                        <button class="float-right btn border rounded-circle" @click="closeEditTimeslot">&times;</button>
                        <h4>Edit Time Slot</h4>
                    </div>
                    
                    <div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input v-model="selected_timeslot.name" type="text" class="form-control" placeholder="Period 1">
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">From</label>
                                <input v-model="selected_timeslot.from" type="time" class="form-control" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">To</label>
                                <input v-model="selected_timeslot.to" type="time" class="form-control" >
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-success " @click="updateTimeslot"> Update </button>
                            <button class="btn btn-default ml-2" @click="closeEditTimeslot"> Cancel </button>
                        </div>
                        

                        
                    </div>
                </div>
                <!-- End of Edit Timeslots -->

             <!-- End of Timeslots -->
             </div>
             <!-- Vue App End -->
             
             
             
            
             
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content -->
         </div>
     
         <x-footer motto="" >
         <script src="/js/axios.min.js"></script>
       
         <script src="/js/vue.global.prod.js"></script>
         <script src="/js/timetable.js"></script>
         
        

         </x-footer>