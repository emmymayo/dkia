

    <x-header title="View Timetable " >
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
                        <h1 class="m-0 lead">View Timetable</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><a href="/timetable-viewer">View Timetable</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                    
                    <div id="school-timetable-viewer" v-cloak class="card p-3">
                        <x-vue-loader/>
                        <div class="my-2">
                            <div class="form-group">
                                <label for="">Select Timetable</label>
                                <select v-model="timetable_value" required class="form-control">
                                    <option value="">--select timetable--</option>
                                    <option v-for="(timetable,index) in timetables" :key="index" :value="timetable.id+'|'+timetable.scheduleable_type">
                                        @{{timetable.name}}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary" @click="loadTimetable">Load Timetable</button>
                            </div>
                        </div>
                        <!-- print button -->
                        <div v-show="show_timetable">
                                <button class="btn btn-primary float-right" @click="printTimetable"><i class="fa fa-print"></i>Print</button>
                        </div>
                        <div v-show="show_timetable" class="my-2" id="printable">
                            
                            <template v-if="timetable_type=='sections'">
                            <table class="table table-hover  table-responsive-md">
                                <tr>
                                    <th></th>
                                    <th class="text-center" v-for="(timeslot_list,timeslot_list_index) in timetable_timeslots" :key="timeslot_list_index">
                                        @{{timeslot_list.name}} <br>
                                        @{{timeslot_list.from}} - @{{timeslot_list.to}}
                                    </th>
                                </tr>
                                <tr v-for="(day,day_index) in entries" :key="day_index">
                                    <td class="text-uppercase">@{{day[0]!=undefined?day[0].day:''}}</td>
                                    <td v-for="(timeslot,timeslot_index) in timetable_timeslots" :key="timeslot_index">
                                        <span v-for="entry in day">
                                            @{{entry.timetable_timeslot_id==timeslot.id?entry.entry:''}}
                                        </span>
                                    </td>

                                </tr>
                            
                            </table>
                            </template>

                            <template v-if="timetable_type=='exams'">
                            <table class="table table-hover table-bordered table-responsive-md">
                                <tr>
                                    <th></th>
                                    <th class="text-center" v-for="(timeslot_list,timeslot_list_index) in timetable_timeslots" :key="timeslot_list_index">
                                        @{{timeslot_list.name}} <br>
                                        @{{timeslot_list.from}} - @{{timeslot_list.to}}
                                    </th>
                                </tr>
                                <tr v-for="(date,date_index) in dates" :key="date_index">
                                    
                                    <td class="text-uppercase">@{{parseDate(date)}}</td>
                                    <td v-for="(timeslot,timeslot_index) in timetable_timeslots" :key="timeslot_index">
                                        <span v-for="(entry,entry_index) in entries" :key="entry_index">
                                            @{{(entry.timetable_timeslot_id==timeslot.id) && (entry.day==date)
                                                                            ?entry.entry+' '+' '+' '
                                                                            :''}}
                                            
                                        </span>
                                    </td>
                                    
                                    

                                </tr>
                            
                            </table>
                            </template>
                            
                        
                        </div>

                    </div>
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
                <script src="/js/axios.min.js"></script>
       
                <script src="/js/vue.global.prod.js"></script>
                <script src="/js/timetable.js"></script>
            </x-footer>
        </div>
  