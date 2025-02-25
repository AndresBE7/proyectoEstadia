<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  async function getchat() {
    try {
      const response = await axios.get("/MensajeNoLeido");
      const chat = response.data;

      const messageCountBadge = document.getElementById('message-count');
      messageCountBadge.textContent = chat.length;

      const chatList = document.getElementById('chat-list');
      chatList.innerHTML = ''; 
      chat.forEach((user) => {
          const li = document.createElement('li');
          li.className = 'dropdown-item'; 

          li.innerHTML = `
              <!-- Message Start -->
              <div class="media">
                  <div class="media-body">
                      <h3 class="dropdown-item-title">
                          ${user.sender.name}
                      </h3>
                      <p class="text-sm">${user.message}</p>
                      
                  </div>
              </div>
              <!-- Message End -->
          `;

          chatList.appendChild(li);
      });
      console.log('Chat', chat);
    } catch (error) {
      console.error('Error al obtener el chat', error);
    }
  }

  document.addEventListener('DOMContentLoaded', async function() {
    await getchat();
  });

</script>
 
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
          <span id="message-count" class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div id="chat-list"></div>
          </a>
          
          <div class="dropdown-divider"></div>
          <a href="{{url('chat')}}" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
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
        <a href="{{ asset('admin/assign_teacher/list') }}" class="nav-link @if(request()->segment(1)=='assign_subject') active @endif">
          <i class="nav-icon fas fa-book"></i>
          <p>Asignar Maestro</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('admin/documents/list') }}" class="nav-link @if(request()->segment(1)=='documents') active @endif">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>Documentos</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ asset('admin/surveys/index') }}" class="nav-link @if(request()->segment(1)=='surveyss') active @endif">
            <i class="nav-icon fas fa-microphone"></i>
            <p>Entrevistas</p>
        </a>
    </li>

    <li class="nav-item">
      <a href="{{ asset('/admin/surveys/reports') }}" class="nav-link @if(request()->segment(1)=='surveyss') active @endif">
          <i class="nav-icon fas fa-microphone"></i>
          <p>Reportes de Encuesta</p>
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
        @elseif(Auth::user()->user_type == 3 && Auth::user()->nivel_academico == 'Secundaria')
        <li class="nav-item">
            <a href="{{ asset('alumno/dashboard') }}" class="nav-link @if(request()->segment(1) == 'dashboard') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Inicio
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ asset('student/surveys/show') }}" class="nav-link @if(request()->segment(1) == 'surveyss') active @endif">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Encuestas</p>
            </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('student.documents.show') }}" class="nav-link @if(request()->segment(2) == 'documents') active @endif">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Documentos</p>
          </a>
      </li>
        <li class="nav-item">
            <a href="{{ asset('student/change_password') }}" class="nav-link @if(request()->segment(1) == 'change-password') active @endif">
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
        <a href="{{ route('calendar.index') }}" class="nav-link @if(request()->routeIs('calendar.index')) active @endif">
          <i class="nav-icon fas fa-calendar-alt"></i>
          <p>Calendario Escolar</p>
        </a>

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