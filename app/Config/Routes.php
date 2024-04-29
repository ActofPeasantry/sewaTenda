<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('download/(:any)', 'Home::downloadFile/$1');

$routes->get('/login', 'LoginController::index');
$routes->addRedirect('/', '/catalog');
$routes->post('login', 'LoginController::login');
$routes->get('logout', 'LoginController::logout');

$routes->group('', ['filter' => 'admRole'], function ($routes) {

    $routes->get('/dashboard', 'Home::index');

    $routes->get('/user', 'UserController::index');
    $routes->post('/add-edit-user-view', 'UserController::addEditUserView');
    $routes->post('/add-edit-user', 'UserController::addEditUser');
    $routes->get('/user/delete/(:num)', 'UserController::delete/$1');

    $routes->get('/penyewa', 'PenyewaController::index');
    $routes->post('/edit-penyewa-view', 'PenyewaController::editPenyewaView');
    $routes->post('/edit-penyewa', 'PenyewaController::editPenyewa');
    $routes->get('/penyewa/delete/(:num)', 'PenyewaController::delete/$1');

    $routes->get('/tenda', 'TendaController::index');
    $routes->post('/add-edit-tenda-view', 'TendaController::addEditTendaView');
    $routes->post('/add-edit-tenda', 'TendaController::addEditTenda');
    $routes->get('/tenda/delete/(:num)', 'TendaController::deleteTenda/$1');

    $routes->get('/kategori', 'TendaController::indexKategori');
    $routes->post('/add-edit-kategori-view', 'TendaController::addEditKategoriView');
    $routes->post('/add-edit-kategori-tenda', 'TendaController::addEditKategori');
    $routes->get('/kategori/delete/(:num)', 'TendaController::delete/$1');

    $routes->get('/transaksi-progress', 'TransaksiController::indexTransaksiProgress');
    $routes->get('/transaksi-approved', 'TransaksiController::indexTransaksiApproved');
    $routes->get('/transaksi-rejected', 'TransaksiController::indexTransaksiRejected');
    $routes->post('/confirm-transaksi-view', 'TransaksiController::confirmTransaksiView');
    $routes->get('/confirm-transaksi-view/detail/(:num)', 'TransaksiController::confirmTransaksiViewDetail/$1');
    $routes->post('/confirm-transaksi', 'TransaksiController::confirmTransaksi');
    $routes->get('/download-pdf-transaksi-all/(:num)', 'TransaksiController::generatePDFTransaksiAll/$1');
});


$routes->get('/catalog', 'PenyewaController::catalog');

$routes->get('/register-update-account', 'UserController::registerUpdateAccountView');
$routes->post('register-update-account', 'UserController::registerUpdateAccount');


$routes->group('', ['filter' => 'penyewaRole'], function ($routes) {
    $routes->get('/cart', 'PenyewaController::cart');
    $routes->get('/pesanan', 'PenyewaController::pesanan');
    $routes->get('/pesanan/detail/(:num)', 'PenyewaController::detailPesanan/$1');
    $routes->get('/prosespesanan', 'PenyewaController::historyPesanan');
    $routes->post('submit-pembayaran', 'PenyewaController::submitPembayaran');
    $routes->post('update-pembayaran-from-pesanan', 'PenyewaController::updatePembayaranFromPesanan');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
