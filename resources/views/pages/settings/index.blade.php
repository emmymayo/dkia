
    <x-header title="School Settings" >
 
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
                     <h1 class="m-0 lead">Settings</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="#">School Settings</a></li>
                     </ol>
                 </div><!-- /.col -->
                 </div><!-- /.row -->
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content-header -->

             <!-- Main content -->
             <div class="content">
             <div class="container-fluid">
             
             <div id="upload_picture" class=" mx-md-5 px-md-5">

                <div class="justify-content-center text-center">
                    <img src="/storage/{{$logo}}" height="150" width="150" alt="School Logo">
                </div>
                <form action="/settings/school/logo" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="form-group mx-md-5 px-md-5">
                    <label for="avatar">Upload School Logo (1MB max, JPEG or PNG.)</label>
                    <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" accept="image/*"
                            id="photo" name="photo" required capture="environment"
                            onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0])">
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <button class="input-group-text" type="submit" >Upload</button>
                    </div>
                    </div>
                    <div class=" text-center">
                        
                        <img id="img_preview" alt="" height="100" width="100">
                    </div>
                </div>
                </form>
            </div>
             <!-- Vue App -->
             <div id="school-settings" class="elevation-2 p-3 card" >
             <div class="overlay w-100 h-100 text-center" v-show="app_loading" 
                 style="position:absolute;"><i class="fas fa-2x fa-spinner fa-spin "></i></div>

             <div class="row">

                <div v-for="(setting,index) in settings" class="form-group col-md-6">
                    
                    <template v-if="settings[index].key=== 'school.logo' ">
                        <!-- ignore School Logo -->
                    </template>
                    <template v-else-if="settings[index].key=== 'current.session' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <select v-model="settings[index].value"  class="form-control" >
                            <option :value="session.id" v-for="(session, key) in sessions" :key="key">
                                @{{session.start+'/'+session.end}}
                            </option> 
                         </select>
                    </template>
                    <template v-else-if="settings[index].key=== 'active.exam' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <select v-model="settings[index].value"  class="form-control" >
                            <option :value="exam.id" v-for="(exam, key) in exams" :key="key">
                                @{{exam.name}}
                            </option> 
                         </select>
                    </template>
                    <template v-else-if="settings[index].key=== 'exam.registration.open' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <select v-model="settings[index].value"  class="form-control" >
                            <option value="1">Yes</option> 
                            <option value="0">No</option> 
                         </select>
                    </template>
                    <template v-else-if="settings[index].key=== 'exam.locked' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <select v-model="settings[index].value"  class="form-control" >
                            <option value="1">Yes</option> 
                            <option value="0">No</option> 
                         </select>
                    </template>
                    <template v-else-if="settings[index].key=== 'use.attendance.system' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <select v-model="settings[index].value"  class="form-control" >
                            <option value="1">Yes</option> 
                            <option value="0">No</option> 
                         </select>
                    </template>
                    <template v-else-if="settings[index].key=== 'short.notice' ">
                    <label class="">@{{settings[index].display_name}}</label>
                        <textarea row="4" v-model="settings[index].value"  class="form-control" ></textarea>
                    </template>
                    <template v-else>
                        <!--Regular Settings -->
                        <label class="">@{{settings[index].display_name}}</label>
                    <input type="text" v-model="settings[index].value" class="form-control">
                    </template>
                    
                
                </div>
             

                 </div>
                 <div class="form-group">
                     <button class="btn btn-primary" @click="updateSettings('{{csrf_token()}}')" > 
                     <i class="fa fa-cog"></i> Update</button>
                 </div>
                
                 
            

            


             </div>
             <!-- Vue App End -->
             
             
             
            
             
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content -->
         </div>
     
         <x-footer motto="" >
         <script src="/js/axios.min.js"></script>
       
         <script src="/js/vue.global.prod.js"></script>
         <script src="/js/settings.js"></script>
         
         <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
                <script>
                    $(function () {
                    bsCustomFileInput.init();
                    });
                </script>

         </x-footer>