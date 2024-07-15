<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
  <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
  <meta name="author" content="ThemeSelect">
  <title>Dashboard - Sewa Tenda</title>
  <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.jpg">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/css/vendors.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/vendors/css/charts/chartist.css') ?>">
  <!-- END VENDOR CSS-->

  <!-- BEGIN CHAMELEON CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/css/app-lite.css') ?>">
  <!-- END CHAMELEON CSS-->

  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/css/core/colors/palette-gradient.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('theme-assets/css/pages/dashboard-ecommerce.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('datatables/datatables.min.css') ?>">
  <!-- END Page Level CSS-->

  <!-- BEGIN Custom CSS-->
  <!-- END Custom CSS-->
  <?= $this->renderSection('link') ?>
</head>

<body class="vertical-layout 2-columns fixed-navbar" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
      <div class="navbar-container content">
        <div class="collapse navbar-collapse show" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="dropdown dropdown-user nav-item">
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">
            <?php if (session()->get('user')) : ?>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/catalog"><i class="la la-th-large"></i></a></li>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/cart"><i class="la la-shopping-cart"></i></a></li>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/pesanan"><i class="la la-credit-card"></i></a></li>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/prosespesanan"><i class="la la-clock-o"></i></a></li>
            <?php else : ?>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/login"><i class="la la-shopping-cart"></i></a></li>
              <li class="nav-item"><a class="nav-link nav-link-label" href="/login"><i class="la la-credit-card"></i></a></li>
            <?php endif; ?>

            <?php if (session()->get('user')) : ?>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online"><img src="user.png" alt="avatar"></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" style="pointer-events: none; cursor: not-allowed;"><span class="avatar-online"><span class="user-name text-bold-700"><?= session()->get('user')['username'] ?></span></span></a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/register-update-account"><i class="ft-user"></i> Ubah Profile</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" onclick="return confirm('Yakin Mau Logout?')" href="logout"><i class="ft-power"></i> Logout</a>
                  </div>
                </div>
              </li>
            <?php else : ?>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" style="pointer-events: none; cursor: not-allowed;"><span class="avatar avatar-online"><img src="<?= base_url('favicon.jpg') ?>" alt="avatar"></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- ////////////////////////////////////////////////////////////////////////////-->

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">

          <h3 class="content-header-title"><span class="avatar avatar-online"><img src="<?= base_url('favicon.jpg') ?>" alt="avatar"></span> <?= $headerTitle; ?></h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><?= $breadcrumbLink ?? "" ?>
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
  <script src="<?= base_url('theme-assets/vendors/js/vendors.min.js') ?>" type="text/javascript"></script>
  <!-- END VENDOR JS-->

  <!-- BEGIN PAGE VENDOR JS-->
  <script src="<?= base_url('theme-assets/vendors/js/charts/chartist.min.js') ?>" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->

  <!-- BEGIN CHAMELEON JS-->
  <script src="<?= base_url('theme-assets/js/core/app-menu-lite.js') ?>" type="text/javascript"></script>
  <script src="<?= base_url('theme-assets/js/core/app-lite.js') ?>" type="text/javascript"></script>
  <!-- END CHAMELEON JS-->

  <!-- BEGIN PAGE LEVEL JS-->
  <script src="<?= base_url('theme-assets/js/scripts/pages/dashboard-lite.js') ?>" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->

  <script src="<?= base_url('datatables/datatables.min.js') ?>"></script>
  <?= $this->renderSection('js') ?>
</body>

</html>