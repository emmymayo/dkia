
    <x-header title="Generate Pin" >
 
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
                     <h1 class="m-0 lead">Examination Pin - Generate</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="/pins/generate">Generate Pin</a></li>
                     </ol>
                 </div><!-- /.col -->
                 </div><!-- /.row -->
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content-header -->

             <!-- Main content -->
             <div class="content">
             <div class="container-fluid">
            
                <form action="/pins/generate" method="post" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="">Exam</label>
                        <select name="exam_id" value="{{$active_exam_id}}" class="form-control">
                            @foreach ($exams as $exam)
                                <option value="{{$exam->id}}">{{$exam->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input class="form-control" type="number" name="quantity" value="1" required />
                    </div>
                    <button class="btn btn-success" type="submit">Generate</button>
                </form>
            
             
                 
             </div><!-- /.container-fluid -->
             </div>
             <!-- /.content -->
         </div>
     
         <x-footer motto="" >
         <script src="/js/axios.min.js"></script>
       
         <script src="/js/vue.global.prod.js"></script>
         
         

         </x-footer>