<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="upload/avartar/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Nguyễn Nhã</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="upload/avartar/{{Auth::user()->img}}" class="img-circle elevation-2" alt="User Image" style="height: 50px;width: 50px;">
        </div>
        <div class="info">
        <a href="{{route('users.detail')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
          <a href="{{route('home')}}" class="nav-link {{ Request::path() == 'Dashbroad' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashbroad 
                  </p>
                </a>
          </li>
          @if(Laratrust::can('question_list'))
          <li class="nav-item has-treeview {{ Request::is('question*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is('question*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                Câu hỏi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{route('question.list')}}" class="nav-link {{ Request::path() == 'question-list.html' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách câu hỏi</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if(Laratrust::can('exam_test')||Laratrust::can('exam_list'))
          <li class="nav-item has-treeview {{ Request::is('exam*') ? 'menu-open' : ''}}">
            <a href="#"  class="nav-link {{ Request::is('exam*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-skull-crossbones"></i>
              <p>
                Bài thi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Laratrust::can('exam_test'))
              <li class="nav-item">
              <a href="{{route('exam.choose')}}" class="nav-link {{ Request::path() == 'exam-choose.html' ? 'active' : '' }}">
                  <i class="fas fa-diagnoses nav-icon "></i>
                  <p>Đề thi</p>
                </a>
              </li>
              @endif
              @if(Laratrust::can('exam_list'))
              <li class="nav-item">
                <a href="{{route('exam.list')}}" class="nav-link {{ Request::path() == 'exam.list.html' ? 'active' : '' }}">
                    <i class="fas fa-diagnoses nav-icon "></i>
                    <p>Kết quả thi</p>
                  </a>
              </li>
              @endif
            </ul>
          </li>  
          @endif
        </ul>


        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @if(Laratrust::can('system-add_user')||Laratrust::can('system_permission_user')) 
          <li class="nav-header">HỆ THỐNG</li>
          <li class="nav-item has-treeview {{ Request::is('user*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is('user*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-circle text-danger"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Laratrust::can('system-add_user'))
                <li class="nav-item">
                  <a href="{{route('users.add')}}" class="nav-link {{ Request::path() == 'user-add.html' ? 'active' : '' }}">
                      <i class="fas fa-diagnoses nav-icon "></i>
                      <p>Thêm</p>
                    </a>
                  </li>
                @endif 
              @if(Laratrust::can('system_user_list'))
                <li class="nav-item">
                  <a href={{route('users.list')}} class="nav-link {{ Request::is('user.list.html') ? 'active' : ''}}">
                    <i class="far fa-circle text-danger nav-icon"></i>
                    <p>Danh sách user</p>
                    <span class="badge badge-info right">2</span>
                  </a>
                </li>
              @endif
              <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Phân quyền user</p>
                </a>
              </li>

            </ul>

          </li>
          <li class="nav-item">
          <a href="{{route('home')}}" class="nav-link">
                  <i class="nav-icon fas fa-cogs text-warning"></i>
                  <p>
                    Cài đặt 
                  </p>
                </a>
          </li>
          @endif
          <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt text-info"></i>  
                  Log Out
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    
  </aside>