<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('auth', 'Auth::index');
$routes->get('auth/register', 'Auth::register');
$routes->get('auth/forgot-password', 'Auth::forgot_password');
$routes->get('auth/confirmation/(:any)', 'Auth::confirmation/$1');

$routes->post('auth/proses-login', 'Auth::proses_login');
$routes->post('auth/proses-register', 'Auth::proses_register');

$routes->get('admin', 'Admin::index');
$routes->get('admin/kelas', 'Admin::kelas');
$routes->get('admin/kelas/tambah', 'Admin::tambah_kelas');
$routes->get('admin/kelas/edit/(:any)', 'Admin::edit_kelas/$1');
$routes->get('admin/kelas/delete/(:any)', 'Admin::delete_kelas/$1');

$routes->post('admin/kelas/proses-tambah', 'Admin::proses_tambah_kelas');
$routes->post('admin/kelas/proses-edit/(:any)', 'Admin::proses_edit_kelas/$1');

$routes->get('admin/topik', 'Admin::topik');
$routes->get('admin/topik/tambah', 'Admin::tambah_topik');
$routes->get('admin/topik/edit/(:any)', 'Admin::edit_topik/$1');
$routes->get('admin/topik/delete/(:any)/(:any)', 'Admin::delete_topik/$1/$2');

$routes->post('admin/topik/proses-tambah', 'Admin::proses_tambah_topik');
$routes->post('admin/topik/proses-edit/(:any)/(:any)', 'Admin::proses_edit_topik/$1/$2');

$routes->get('admin/user', 'Admin::user');

$routes->get('admin/paket', 'Admin::paket');
$routes->get('admin/paket/tambah', 'Admin::tambah_paket');
$routes->get('admin/paket/edit/(:any)', 'Admin::edit_paket/$1');
$routes->get('admin/paket/delete/(:any)', 'Admin::delete_paket/$1');

$routes->post('admin/paket/proses-tambah', 'Admin::proses_tambah_paket');
$routes->post('admin/paket/proses-edit/(:any)', 'Admin::proses_edit_paket/$1');


$routes->get('admin/diskon', 'Admin::diskon');
$routes->get('admin/diskon/tambah', 'Admin::tambah_diskon');
$routes->get('admin/diskon/edit/(:any)', 'Admin::edit_diskon/$1');
$routes->get('admin/diskon/delete/(:any)', 'Admin::delete_diskon/$1');

$routes->post('admin/diskon/proses-tambah', 'Admin::proses_tambah_diskon');
$routes->post('admin/diskon/proses-edit/(:any)', 'Admin::proses_edit_diskon/$1');

$routes->get('admin/transaksi', 'Admin::transaksi');

// ----------- USER ------------- //

$routes->get('/' , 'Home::index');
$routes->get('user/login', 'Home::login');
$routes->post('user/proses-login', 'Auth::proses_login');
$routes->get('user/register', 'Home::register');
$routes->post('user/proses-register', 'Auth::proses_register');
$routes->get('user/forgot-password', 'Home::forgot');
$routes->post('user/proses-forgot-password', 'Home::proses_forgot');
$routes->get('user/new-password/(:any)', 'Home::new_password/$1');
$routes->post('user/proses-new-password/(:any)', 'Home::proses_new_password/$1');
$routes->get('user/dashboard', 'Home::dashboard');
$routes->get('user/invoice', 'Home::invoice');
$routes->get('user/konfirmasi-pembayaran', 'Home::konfirmasi_pembayaran');
$routes->post('user/proses-konfirmasi-pembayaran', 'Home::proses_konfirmasi_pembayaran');
$routes->get('user/lulus', 'Home::lulus');
$routes->post('user/lulus/generate/(:any)', 'Home::generateCertificate');
$routes->get('search', 'Home::search');
$routes->get('redeem', 'Home::redeem');
$routes->post('redeem-token', 'Home::redeem_token');
$routes->get('courses', 'Home::courses');
$routes->get('courses/package', 'Home::course_package');
$routes->get('courses/class', 'Home::course_class');
$routes->get('course/package/(:any)', 'Home::single_course_package/$1');
$routes->get('course/class/(:any)', 'Home::single_course_class/$1');
$routes->get('home/check_promo/', 'Home::check_promo');
$routes->get('cart/', 'Home::cart');
$routes->get('buy/', 'Home::buy');
$routes->get('my-package/(:any)', 'Home::my_package/$1');
$routes->get('topics/(:any)', 'Home::topics/$1');
$routes->get('learn/(:any)/(:any)', 'Home::learn/$1/$2/$3');
$routes->get('learn/(:any)/(:any)/(:any)', 'Home::learn/$1/$2/$3');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
