  <!-- Main Header -->
  <header class="main-header">

      <!-- Logo -->
      <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>C</b>D</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Creditodigital</b>CRM</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->

                  <li class="dropdown notifications-menu">
                      <!-- Menu toggle button
            <a href="{{ route('calendar') }}" >
              <i class="fa fa-calendar-times-o"></i>
              <span class="label label-warning"></span>
            </a>--!>
            <ul class="dropdown-menu">
              <li>


                <ul class="menu">
                  <li><!-- start message -->
                      <a href="#">
                          <div class="pull-left">
                              <!-- User Image -->
                              @if (Auth::user()->image != null)
                                  <img src="{{ Auth::user()->getImage(Auth::user()->id) }}" class="img-circle"
                                      alt="User Image">
                              @else
                                  <img src="/storage/image/stock.png" class="img-circle" alt="User Image">
                              @endif

                          </div>
                          <!-- Message title and timestamp -->
                          <h4>
                              Support Team
                              <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <!-- The message -->
                          <p>Why not buy a new awesome theme?</p>
                      </a>
                  </li>
                  <!-- end message -->
              </ul>
              <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
              </li>
              <!-- /.messages-menu -->

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                  <!-- Menu toggle button -->
                  <a href="{{ route('profile') }}">
                      <i class="fa fa-user"></i>
                      <span class="label label-warning"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 10 notifications</li>
                      <li>
                          <a href="#" class="badge badge-primary">Primary</a>
                          <!-- Inner Menu: contains the notifications -->
                          <ul class="menu">
                              <li>
                                  <!-- start notification -->
                                  <a href="#">
                                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                  </a>
                              </li>
                              <!-- end notification -->
                          </ul>
                      </li>
                      <li class="footer"><a href="#">View all</a></li>
                  </ul>
              </li>
              <!-- Tasks Menu -->
              <li class="dropdown notifications-menu">
                  <!-- Menu toggle button -->
                  <a href="{{ route('home') }}">
                      <i class="fa fa-home"></i>
                      <span class="label label-warning"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <li>

                          <!-- Inner menu: contains the tasks -->
                          <ul class="menu">
                              <li>
                                  <!-- Task item -->
                                  <a href="#">
                                      <!-- Task title and progress text -->
                                      <h3>
                                          Design some buttons
                                          <small class="pull-right">20%</small>
                                      </h3>
                                      <!-- The progress bar -->
                                      <div class="progress xs">
                                          <!-- Change the css width attribute to simulate progress -->
                                          <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                              role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                              aria-valuemax="100">
                                              <span class="sr-only">20% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <!-- end task item -->
                          </ul>
                      </li>
                      <li class="footer">
                          <a href="#">View all tasks</a>
                      </li>
                  </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                  <!-- Menu Toggle Button -->
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      @if (Auth::user()->image != null)
                          <img class="user-image" src="{{ Auth::user()->getImage(Auth::user()->id) }}"
                              alt="User Image">
                      @else

                          <img src="/storage/image/stock.png" class="user-image" alt="User Image">
                      @endif
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs">{{ Auth::user()->name }}</span>
                  </a>
                  <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                          @if (Auth::user()->image != null)
                              <center> <img class="img-circle"
                                      src="{{ Auth::user()->getImage(Auth::user()->id) }}" width="100" height="100"
                                      algt="User Image"></center>
                          @else

                              <center><img src="/storage/image/stock.png" width="100" height="100"
                                      class="img-circle" algt="User Image"></center>
                          @endif

                          <p>
                              {{ Auth::user()->name }}
                          </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                          <div aria-labelledby="navbarDropdown" align="center">
                              <a class="btn btn-default btn-flat btn-sm" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
              </li>
              </ul>
          </div>
      </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
              <div class="pull-left image">
                  @if (Auth::user()->image != null)
                      <img class="img-circle" src="{{ Auth::user()->getImage(Auth::user()->id) }}" />
                  @else
                      <img src="/storage/image/stock.png" class="img-circle" alt="User Image">
                  @endif
              </div>
              <div class="pull-left info">
                  <p>{{ Auth::user()->name }}</p>
                  <!-- Status -->
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu" data-widget="tree">
              <li class="header">MENU</li>
              <!-- Optionally, you can add icons to the links -->
              <li><a href="{{ route('home') }}"><i class="fa fa-bars"></i> <span>La tua dashboard</span></a></li>
              <li><a href="{{ route('leads.index') }}"><i class="fa fa-clipboard"></i><span>Lead</span></a></li>
              <li><a href="{{ route('instances.index') }}"><i class="fa fa-pencil"></i><span>Richieste</span></a>
              </li>
              <li><a href="{{ route('practices.index') }}"><i class="fa fa-clipboard"></i> <span>Pratiche</span></a>
              </li>
              <li><a href="{{ route('spots.index') }}"><i class="fa fa-briefcase"></i> <span>MySpot</span></a>
              </li>
              <li><a href="{{ route('archived_leads') }}"><i class="fa fa-clipboard"></i> <span>Lead Archiviati</span></a>
              </li>
              <li><a href="{{ route('clients') }}"><i class="fa fa-clipboard"></i> <span>Clienti</span></a>
              </li>
              <li><a href="{{ route('dealers.index') }}"><i class="fa fa-clipboard"></i> <span>Dealer</span></a>
              </li>
              <li><a href="{{ route('commitments.index') }}"><i class="fa fa-clipboard"></i> <span>Affidamento dealer</span></a>
              </li>
              <li><a href="{{ route('companies.index') }}"><i class="fa fa-clipboard"></i> <span>Aziende</span></a>
              </li>
              <li><a href="{{ route('create_module') }}"><i class="fa fa-clipboard"></i> <span>Modulistica</span></a>
              </li>

              @if (Auth::user()->agent_code == '00000000')
                  <li><a href="{{ route('assignments.index') }}"><i class="fa fa-check"></i><span>Assegnazioni
                              lead</span></a></li>
                  <li><a href="{{ route('products.index') }}"><i class="fa fa-table"></i><span>Prodotti</span></a>
                  </li>
                  <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Utenti</span></a></li>
              @endif


              <li><a href="{{ route('calendar') }}"><i class="fa fa-calendar"></i> <span>Calendario</span></a></li>
              <!--<li><a href="{{ route('agencies') }}"><i class="fa fa-building"></i> <span>Agenzie immobiliari</span></a></li>-->
              <!-- <li class="active treeview menu-open">
                  <a href="#">
                      <i class="fa fa-industry"></i><span>Agenti</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="#"><i class="fa fa-institution"></i>Crea richiesta</a></li>
                      <li><a href="#"><i class="fa fa-group"></i>Elimina richiesta</a></li>
                  </ul>
              </li> -->

          </ul>
          <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      </section>
