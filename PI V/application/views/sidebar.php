<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/dist/img/avatar.png')?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['usuario']?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
		    <!-- <li class='lei'>
            <a href="<?php echo base_url('home/lei')?>">
                <i class="fa fa-th"></i> <span>Lei Diárias</span>
            </a>
        </li> -->

        <li class=" treeview dashboard">
            <a href="#">
                <i class="fa fa-book"></i> <span>Leis</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li class='lei'>
                <a href="<?php echo base_url('home/lei')?>">
                    <i class="	fa fa-book"></i> <span>Lei Diárias</span>
                </a>
              </li>

              <li class='lei'>
                <a href="<?php echo base_url('home/leiAdiantamento')?>">
                    <i class="	fa fa-book"></i> <span>Lei Adiantamento</span>
                </a>
              </li>
            </ul>
        </li>

        
		    <li class='simulador'>
            <a href="<?php echo base_url('simulador/simulador')?>">
                <i class="fa fa-balance-scale"></i> <span>Simular Valores</span>
            </a>
        </li>

        <li class=" treeview dashboard">
            <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Dashboard</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class=""><a href="<?php echo base_url('Dashboard/dashboardsDados/diarias')?>"><i class="fa fa-chart-pie"></i> Dashboard Diárias </a></li>
                <li class=""><a href="<?php echo base_url('Dashboard/dashboardsDados/ufms')?>"><i class="fa fa-chart-pie"></i> Dashboard Ufm </a></li>
            </ul>
        </li>

        <li class="treeview diarias">
            <a href="#">
                <i class="glyphicon glyphicon-calendar"></i> <span>Diária Comum</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="diarias-menu"><a href="<?php echo base_url('Diarias/diarias')?>"><i class="fa fa-chart-pie"></i> Diárias Cadastradas</a></li>
                <li class="cad_diarias-menu"><a href="<?php echo base_url('Diarias/cad_diarias')?>"><i class="fa fa-chart-pie"></i> Cadastrar</a></li>
            </ul>
        </li>

        <li class=" treeview ufms">
            <a href="#">
                <i class="glyphicon glyphicon-calendar"></i> <span>Diária Ufms</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="ufms-menu"><a href="<?php echo base_url('Ufms/ufms')?>"><i class="fa fa-chart-pie"></i> Ufms Cadastradas</a></li>
                <li class="cad_ufms-menu"><a href="<?php echo base_url('Ufms/cad_ufms')?>"><i class="fa fa-chart-pie"></i> Cadastrar</a></li>
            </ul>
        </li>
        
        <li class=" treeview ufms">
            <a href="#">
                <i class="glyphicon glyphicon-calendar"></i> <span> Adiantamento Valor</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="ufms-menu"><a href="<?php echo base_url('SuprimentoFundos/adiantamento')?>"><i class="fa fa-chart-pie"></i> Adiantamentos Cadastrados</a></li>
                <li class="cad_ufms-menu"><a href="<?php echo base_url('SuprimentoFundos/cadAdiantamento')?>"><i class="fa fa-chart-pie"></i> Cadastrar</a></li>
            </ul>
        </li>
		<li class='profile'>
            <a href="<?php echo base_url('home/profile')?>">
                <i class="fa fa-address-book"></i> <span>Perfil usuário</span>
            </a>
        </li>

        <script src="<?php echo base_url('assets/js/library/jquery.min.js')?>"></script>
        <script type="text/javascript">
			var $query = location.pathname,
			$partes = $query.split('/');

			switch ($partes[2]) {

			// MENUS DO CONTROLE DE USUARIOS
			case 'lei':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.lei').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				break;
			case 'simulador':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.simulador').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				break;
			case 'dashboard':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.dashboard').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				$('.'+ $partes[2] +' ul li').addClass('active');
				break;
			case 'diarias':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.diarias').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				$('.'+ $partes[2] +' .diarias-menu').addClass('active');
				break;
			case 'cad_diarias':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.diarias').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				$('.cad_diarias-menu').addClass('active');
				break;
			case 'ufms':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.ufms').addClass('active');
				$('.'+ $partes[2] +' a').addClass('active');
				$('.'+ $partes[2] +' ul .ufms-menu').addClass('active');
				break;
			case 'cad_ufms':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.ufms').addClass('active');
				$('.cad_ufms-menu').addClass('active');
				break;
			case 'profile':
				var $in = $('.'+ $partes[2] ).parent().addClass('in');
				$('.profile').addClass('active');
				$('.'+ $partes[2] +' ul .cad_ufms-menu').addClass('active');
				break;
			}
        </script>

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-chart-pie"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul> -->
    </section>
    <!-- /.sidebar -->
  </aside>