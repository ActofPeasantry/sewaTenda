<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
  <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
  <meta name="author" content="ThemeSelect">
  <title>Dashboard - Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit</title>
  <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.jpg">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="theme-assets/vendors/css/charts/chartist.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN CHAMELEON  CSS-->
  <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
  <!-- END CHAMELEON  CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
  <link href="datatables/datatables.min.css" rel="stylesheet">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <!-- END Custom CSS-->
  <?= $this->renderSection('link') ?>
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="collapse navbar-collapse show" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
            <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
              <ul class="dropdown-menu">
                <li class="arrow_box">
                  <form>
                    <div class="input-group search-box">
                      <div class="position-relative has-icon-right full-width">
                        <input class="form-control" id="search" type="text" placeholder="Search here...">
                        <div class="form-control-position navbar-search-close"><i class="ft-x"> </i></div>
                      </div>
                    </div>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">
            <?php if (session()->get('user')) : ?>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online"><img src="user.png" alt="avatar"></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="user.png" alt="avatar"><span class="user-name text-bold-700 ml-1"><?= session()->get('user')['username'] ?></span></span></a>
                    <div class="dropdown-divider"></div>
                    <form action="/add-edit-user-view" method="post">
                      <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                      <input type="hidden" name="userId" value=<?= session()->get('user')['id'] ?>>
                      <input type="hidden" name="action" value="edit">
                      <button type="submit" class="dropdown-item" style="cursor: pointer;"><i class="ft-user"></i> Ubah Profile</button>
                    </form>
                    <div class="dropdown-divider"></div><a class="dropdown-item" onclick="return confirm('Yakin Mau Logout?')" href="logout"><i class="ft-power"></i> Logout</a>
                  </div>
                </div>
              </li>
            <?php else : ?>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"><span class="avatar avatar-online"><img src="favicon.jpg" alt="avatar"></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- ////////////////////////////////////////////////////////////////////////////-->


  <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">&nbsp;&nbsp;
        <li class="nav-item mr-auto"><a class="navbar-brand" href="/dashboard"><img class="brand-logo" alt="Chameleon admin logo" src="favicon.jpg" />
            <h3 class="brand-text">&nbsp;&nbsp;Rama Tenda </h3>
          </a></li>
        <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
      </ul>
    </div>
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="<?= $navDashboardActive ?? "" ?> nav-item"><a href="/dashboard"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
        </li>
        <li class="<?= $navTransaksiActive ?? "" ?> nav-item"><a href="/transaksi-progress"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Transaksi</span></a>
        </li>
        <li class="<?= $navTendaActive ?? "" ?> nav-item"><a href="/tenda"><i class="ft-home"></i><span class="menu-title" data-i18n="">Item</span></a>
        </li>
        <li class="<?= $navPenyewaActive ?? "" ?> nav-item"><a href="/penyewa"><i class="ft-droplet"></i><span class="menu-title" data-i18n="">Penyewa</span></a>
        </li>
        <li class="<?= $navUserActive ?? "" ?> nav-item"><a href="/user"><i class="ft-box"></i><span class="menu-title" data-i18n="">User</span></a>
        </li>
      </ul>
    </div>
    <div class="navigation-background"></div>
  </div>

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title"><?= $headerTitle; ?></h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><?= $breadcrumbLink ?? ""; ?>
                </li>
                <li class="breadcrumb-item active"><?= $headerTitle; ?>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->


  <footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">2018 &copy; Copyright <a class="text-bold-800 grey darken-2" href="https://themeselection.com" target="_blank">ThemeSelection</a></span>
    </div>
  </footer>

  <!-- BEGIN VENDOR JS-->
  <script src="theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="theme-assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN CHAMELEON  JS-->
  <script src="theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
  <script src="theme-assets/js/core/app-lite.js" type="text/javascript"></script>
  <!-- END CHAMELEON  JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="theme-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  <script src="datatables/datatables.min.js"></script>
  <?= $this->renderSection('js') ?>
</body>

</html>