<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'c_user::index');
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);

$routes->get('/generate', 'c_damping_ujian::generate', ['filter' => 'role:admin']);
$routes->get('/saveGenerate', 'c_damping_ujian::saveGenerate', ['filter' => 'role:admin']);
$routes->get('/c_user/updateProfile', 'c_user::updateProfile');

$routes->get('/viewProfile/(:num)', 'c_user::viewProfile/$1');
$routes->get('/c_user/updateProfile', 'c_user::updateProfile');

$routes->get('/viewJadwal/(:num)', 'c_jadwal_ujian::viewJadwal/$1');
$routes->get('/viewAllJadwal/(:alpha)', 'c_jadwal_ujian::index/$1');
$routes->delete('/c_jadwal_ujian/delJadwal', 'c_jadwal_ujian::delJadwal');
$routes->get('/c_jadwal_ujian/editJadwal', 'c_jadwal_ujian::editJadwal');

$routes->get('/viewSkill/(:num)', 'c_profile_pendamping::viewSkill/$1');
$routes->delete('/c_profile_pendamping/delSkill', 'c_profile_pendamping::delSkill');
$routes->get('/c_profile_pendamping/editSkill', 'c_profile_pendamping::editSkill');

$routes->get('/jenisMadif/(:num)', 'jenisMadif::jenisUserMadif/$1');
$routes->delete('/madif/(:alphanum)', 'madif::delSkill/$1');
$routes->get('/editJenisMadif/(:alphanum)', 'jenisMadif::editJenisMadif/$1');


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
