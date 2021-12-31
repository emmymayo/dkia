<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">{{count($notices)==0?'':count($notices)}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right " style="max-width:auto;height:auto">
          
          
          @foreach ($notices as $notice)
            
          
            <!-- Message Start -->
            <div class="media  " >
            <a href="/notices/{{$notice->id}}" class="dropdown-item" style="word-wrap:break-word">
              <!-- <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle"> -->
              <div class="media-body ">
                <div class="h6 small font-weight-bold " >
                  {{$notice->title}}
                  <!-- <span class="float-right text-sm text-primary"><i class="fas fa-star"></i></span> -->
                </div>
                <p class="text-sm small ">{{substr($notice->message, 0,40).'...'}}</p>
                <!-- <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> </p> -->
              </div>
              </a>
            </div>
            <!-- Message End -->
           
            <div class="dropdown-divider"></div>
          @endforeach
         
          
          <div class="dropdown-divider"></div>
          @if(count($notices)>0)<a href="/notices/list" class="dropdown-item dropdown-footer">See all</a>@endif
        </div>
      </li>
   <!-- End of Message dropdown Menu -->
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      
     

      <!-- Account Dropdown Menu -->
      <li class="nav-item dropdown ">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-user-circle fa-2x"></i>
          
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right"
         style="left: inherit; right: 0px;">
          <a href="/dashboard" class="dropdown-item text-muted ">
          <i class="fa fa-tachometer-alt"></i>
            Dashboard
          </a>
          <div class="dropdown-divider"></div>
          <a href="/profile" class="dropdown-item text-muted">
          <i class="fa fa-user-edit"></i>
            My Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="/logout" class="dropdown-item text-muted">
          <i class="fa fa-sign-out-alt"></i>
            Sign Out
          </a>
         
          
        </div>
      </li>
    </ul>
  </nav>