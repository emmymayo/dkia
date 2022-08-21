<aside class="main-sidebar sidebar-dark-primary bg-navy  elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="/storage/{{$settings->firstWhere('key','school.logo')['value']}}" alt="Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span
      class="brand-text text-wrap small wrap font-weight-lighter">{{$settings->firstWhere('key','school.name')['value']}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/storage/{{$user->avatar}}" class="img-circle elevation-2" alt="Avatar">

      </div>
      <div class="info">
        <a href="#" class="d-block align-left">
          {{explode(' ',$user->name)[0].' '.explode(' ',$user->name)[1]}}
        </a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/notices/list" class="nav-link">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>Notices</p>
          </a>
        </li>
        @can('student-only')
        <li class="nav-item">
          <a href="/exams/report/checker/student" class="nav-link">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Check Result</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/students/subjects/register" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Register Subjects</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/students/subjects/registered" class="nav-link">
            <i class="nav-icon fas fa-pen"></i>
            <p>My Registered Subjects</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/attendances/student/view" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>My Attendance</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/students/me/e-classes" class="nav-link">
            <i class="nav-icon fas fa-chalkboard"></i>
            <p>E-Classes</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/student-cbts" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>My CBTs</p>
          </a>
        </li>
        @endcan
        @can('admin-only')
        <li class="nav-item  ">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="">
            <li class="nav-item">
              <a href="/admins" class="nav-link ">
                <i class="fas fa-user-cog nav-icon"></i>
                <p>Admins</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Teachers</p>
                <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/teachers" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage Teachers</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/teachers/assign/index" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Assign teacher</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Students</p>
                <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/students/create" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Admit Student</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/students" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Students</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/sections" class="nav-link">
            <i class="nav-icon fas fa-university"></i>
            <p>Sections</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/classes" class="nav-link">
            <i class="nav-icon fas fa-school"></i>
            <p>Classes</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/subjects" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Subjects</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/gradesystems" class="nav-link">
            <i class="nav-icon fas fa-star"></i>
            <p>Grade System</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/notices" class="nav-link">
            <i class="nav-icon fas fa-info"></i>
            <p>Manage Notices</p>
          </a>
        </li>
        @endcan
        @can('admin-and-teacher-only')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>CBTs</p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/cbts" class="nav-link">
                <i class="nav-icon fas fa-circle"></i>
                <p>Manage CBTs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/cbt-results" class="nav-link">
                <i class="nav-icon fas fa-circle"></i>
                <p>CBT Results</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/e-classes" class="nav-link">
            <i class="nav-icon fas fa-chalkboard"></i>
            <p>Manage E-Classes</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog "></i>
            <p>Manage Exams</p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            @can('admin-only')
            <li class="nav-item">
              <a href="/exams" class="nav-link">

                <i class="nav-icon fas fa-pen"></i>
                <p>Exams</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="/exams-registration" class="nav-link">
                <i class="nav-icon fas fa-file-contract"></i>
                <p>Exam Registration</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/exams-entry" class="nav-link">
                <i class="nav-icon fas fa-book-reader"></i>
                <p>Exam Score Entry</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/exams-entry/view" class="nav-link">
                <i class="nav-icon fas fa-eye"></i>
                <p>View Exam Scores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/exams-record" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>Behavioural Analysis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/exams/students/broadsheet" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>View Broadsheet</p>
              </a>
            </li>
            @can('admin-only')
            <li class="nav-item">
              <a href="/exams/report/checker" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>Exam Report Checker</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Attendance</p>
            <i class="right fas fa-angle-left"></i>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/attendances/roll/call" class="nav-link">
                <i class="nav-icon fas fa-check"></i>
                <p>Roll Call</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/attendances/roll/view" class="nav-link">

                <i class="nav-icon fas fa-eye"></i>
                <p>Roll View</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="/promotions" class="nav-link">

            <i class="nav-icon fa fa-forward"></i>
            <p>Promotions</p>
          </a>
        </li>


        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Timetables</p>
            <i class="right fas fa-angle-left"></i>
          </a>

          <ul class="nav nav-treeview">
            @can('admin-and-teacher-only')
            <li class="nav-item">
              <a href="/timetables" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Manage Timetables</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="/timetable-viewer" class="nav-link">

                <i class="nav-icon fas fa-eye"></i>
                <p>View Timetable</p>
              </a>
            </li>
          </ul>
        </li>

        @endcan
        @can('admin-only')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-lock"></i>
            <p>Examination Pin</p>
            <i class="right fas fa-angle-left"></i>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/pins/generate" class="nav-link">
                <i class="nav-icon fas fa-key"></i>
                <p>Generate Pin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/pins/manage" class="nav-link">

                <i class="nav-icon fas fa-cog"></i>
                <p>Manage Pins</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/settings" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>School Settings</p>
          </a>
        </li>
        @endcan
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-money-bill"></i>
            <p>Payment</p>
            <i class="right fas fa-angle-left"></i>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/payment/create" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>Make Payment</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/payments-history" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>My Payments</p>
              </a>
            </li>
            @can('admin-only')
            <li class="nav-item">
              <a href="/check-payments" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>Check Payments</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        <li class="nav-item">
          <a href="/profile" class="nav-link">
            <i class="nav-icon fa fa-user-edit"></i>
            <p>My Profile</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>