
    <x-header title='User Login'>
        <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    </x-header> 

    
    <div class="login-page bg-blue " style="min-height: 466px;">
            <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header ">
            <a href="http://destinykiddiesinternational.com" class="lead"><i class="fas fa-home left"> </i></a>
            </div>
            <div class="card-body">
            <p class="login-box-msg text-dark">Sign in to start your session</p>
                @if (!empty(session('errors')))
                    <p class="text-danger">{{session('errors')->first('error')}}</p>
                @endif
            <form action="/login" method="post">
            @csrf
                <div class="input-group my-4">
                <input type="text" class="form-control" name="username" placeholder="Email or Admission No">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
                </div>
                <div class="input-group my-4">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                </div>
                
                <div class="row">
                @if(false)
                <div class="col-8">
                    <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="text-dark">
                        Remember Me
                    </label>
                    </div>
                </div>
                @endif
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            </form>

            

            <p class="mb-1">
                Forgot password? Contact School Admin.
            </p>
            
            </div>
            <!-- /.card-body -->
          
        </div>
        <!-- /.card -->
        
        </div> 
        </div>
        <x-footer    />
    
 

