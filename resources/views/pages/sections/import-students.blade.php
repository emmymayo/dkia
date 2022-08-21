

    <x-header title="Sections | Import Sections" >
       
    </x-header>
    
            
            <x-nav-header />
            <x-sidebar-nav   />
            <x-sidebar-control />
           

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Import Students into {{$section->classes->name}} {{$section->name}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/sections">Sections</a></li>
                        <li class="breadcrumb-item active"><a href="/sections/{{$section->id}}/edit">Import Students</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                

                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              
              <form action="/sections/{{$section->id}}/import-students" method="POST" enctype="multipart/form-data" >
                @csrf

                <!-- <input type="hidden" class="form-control" id="section_id" name="section_id" placeholder="" value="{{$section->id}}" required> -->
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Upload Students <small>format: csv, columns: name, email, gender</small></label>
                    <input type="file" class="form-control" name="students_csv" id="students_csv">
                  </div>
                  @error('students_csv')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a href="{{$template_url}}" download class="btn btn-primary">Download Template</a>
                  <button type="submit" class="btn btn-primary">Import</button>
                </div>
              </form>
              
              <div class="p-2 my-2">
                @if (!empty(session('skipped')))
                <h6 class='alert-danger p-3'>Skipped Uploads</h6>
                <table class="table table-striped">
                  @foreach (session('skipped') as $student )
                    <tr>
                      <td>{{$loop->index + 1}}</td>
                      <td>{{$student['name']}}</td>
                      <td>{{$student['email']}}</td>
                      <td>{{$student['gender']}}</td>
                    </tr>
                  @endforeach
                </table>
                @endif
  
                @if (!empty(session('successful')))
                <div class='alert-success p-3'>Successful Uploads</div>
                <table class="table">
                  @foreach (session('successful') as $student )
                  <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$student['name']}}</td>
                    <td>{{$student['email']}}</td>
                    <td>{{$student['gender']}}</td>
                  </tr>
                  @endforeach
                </table>
                @endif
              </div>
            </div>

              

                
                
                   
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            
            </x-footer>
        </div>
   