 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{url('chat')}}" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
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
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link" style="text-align:center">
      <span class="brand-text font-weight-light">Colegio Vida</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
      <!-- Dashboard de Administradores -->
      @if(Auth::user()->user_type==1)
      <li class="nav-item">
        <a href="{{ asset('admin/dashboard') }}" class="nav-link @if(request()->segment(1)=='dashboard') active @endif">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Inicio
          </p>
        </a>
      </li>

      <!-- Gestión de Usuarios -->
      <li class="nav-item has-treeview @if(request()->segment(1)=='admin' || request()->segment(1)=='teacher' || request()->segment(1)=='student' || request()->segment(1)=='parent') menu-open @endif">
        <a href="#" class="nav-link @if(request()->segment(1)=='admin' || request()->segment(1)=='teacher' || request()->segment(1)=='student' || request()->segment(1)=='parent') active @endif">
          <i class="nav-icon fas fa-users-cog"></i>
          <p>
            Gestión de Usuarios
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ asset('admin/admin/list') }}" class="nav-link @if(request()->segment(1)=='admin') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>Administradores</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('admin/teacher/list') }}" class="nav-link @if(request()->segment(1)=='teacher') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>Maestros</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('admin/student/list') }}" class="nav-link @if(request()->segment(1)=='student') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>Estudiantes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('admin/parent/list') }}" class="nav-link @if(request()->segment(1)=='parent') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>Tutores</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Otros elementos de menú -->
      <li class="nav-item">
        <a href="{{ asset('admin/class/list') }}" class="nav-link @if(request()->segment(1)=='class') active @endif">
          <i class="nav-icon fas fa-users"></i>
          <p>Grupos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/subject/list') }}" class="nav-link @if(request()->segment(1)=='subject') active @endif">
          <i class="nav-icon fas fa-book"></i>
          <p>Materias</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/assign_subject/list') }}" class="nav-link @if(request()->segment(1)=='assign_subject') active @endif">
          <i class="nav-icon fas fa-book"></i>
          <p>Asignar Materias</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/documents/list') }}" class="nav-link @if(request()->segment(1)=='documents') active @endif">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>Documentos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/calendar/school_calendar') }}" class="nav-link @if(request()->segment(1)=='calendar') active @endif">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>Calendario Escolar</p>
        </a>
    </li>        
      <li class="nav-item">
        <a href="{{ asset('admin/backup/index') }}" class="nav-link @if(request()->segment(1)=='backup') active @endif">
          <i class="nav-icon fas fa-database"></i>
          <p>Base de datos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/change_password') }}" class="nav-link @if(request()->segment(1)=='change-password') active @endif">
          <i class="nav-icon fas fa-lock"></i>
          <p>Cambiar Contraseña</p>
        </a>
      </li>


        <!-- Dashboard de maestros -->
        @elseif(Auth::user()->user_type==2)
        <li class="nav-item">
          <a href="{{ asset('teacher/dashboard') }}" class="nav-link  @if(request()->segment(1)=='dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ asset('teacher/change_password') }}" class="nav-link @if(request()->segment(1)=='change-password') active @endif">
            <i class="nav-icon fas fa-lock"></i> <!-- Ícono de candado para cambiar contraseña -->
            <p>
              Cambiar Contraseña
            </p>
          </a>
        </li> 

        <!-- Dashboard de alumnos -->
        @elseif(Auth::user()->user_type==3)
        <li class="nav-item">
          <a href="{{ asset('alumno/dashboard') }}" class="nav-link  @if(request()->segment(1)=='dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ asset('student/change_password') }}" class="nav-link @if(request()->segment(1)=='change-password') active @endif">
            <i class="nav-icon fas fa-lock"></i> <!-- Ícono de candado para cambiar contraseña -->
            <p>
              Cambiar Contraseña
            </p>
          </a>
        </li> 

        <!-- Dashboard de tutores -->
        @elseif(Auth::user()->user_type==4)
        <li class="nav-item">
          <a href="{{ asset('tutor/dashboard') }}" class="nav-link @if(request()->segment(1)=='dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('parent.my_student') }}" class="nav-link @if(request()->segment(2)=='my_student') active @endif">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Mi Estudiante
            </p>
          </a>          
        </li>

        <li class="nav-item">
          <a href="{{ asset('parent/change_password') }}" class="nav-link @if(request()->segment(1)=='change-password') active @endif">
            <i class="nav-icon fas fa-lock"></i> 
            <p>
              Cambiar Contraseña
            </p>
          </a>
        </li> 


        @endif

        
        <!-- Dashboard que aplica a todos -->
        <li class="nav-item">
          <a href="{{ asset('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Cerrar Sesión
            </p>
          </a>
        </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>