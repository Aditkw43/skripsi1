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

// Perizinan
$routes->get('/viewCuti/(:num)', 'c_perizinan::viewCuti/$1');
$routes->get('/viewIzin/(:num)', 'c_perizinan::viewIzin/$1');
$routes->get('/konfirmasi_pengganti/(:num)', 'c_perizinan::konfirmasi_pengganti/$1');
$routes->get('/viewAllCuti', 'c_perizinan::viewAllCuti');
$routes->get('/viewAllIzin', 'c_perizinan::viewAllIzin');

// Pendampingan
$routes->get('/generate', 'c_damping_ujian::generate', ['filter' => 'role:admin']);
$routes->get('/saveGenerate', 'c_damping_ujian::saveGenerate', ['filter' => 'role:admin']);
$routes->get('/c_user/updateProfile', 'c_user::updateProfile');
$routes->get('/viewDamping/(:num)', 'c_damping_ujian::viewDamping/$1');
$routes->get('/viewAllDamping', 'c_damping_ujian::viewAllDamping');
$routes->get('/viewTidakDamping/(:num)', 'c_damping_ujian::viewTidakDamping/$1');
$routes->get('/viewLaporan/(:num)', 'c_damping_ujian::viewLaporan/$1');
$routes->get('/changeStatus/(:any)', 'c_damping_ujian::changeStatus/$1');

// Laporan
$routes->get('/viewAllLaporan', 'c_damping_ujian::viewAllLaporan');
$routes->get('/saveLaporan/(:any)', 'c_damping_ujian::saveLaporan/$1');

// User Management
$routes->get('/viewUserAdmin', 'c_user::viewUserAdmin', ['filter' => 'role:admin']);
$routes->get('/viewUserMadif', 'c_user::viewUserMadif', ['filter' => 'role:admin']);
$routes->get('/viewUserPendamping', 'c_user::viewUserPendamping', ['filter' => 'role:admin']);

// Jadwal Ujian
$routes->get('/viewJadwal/(:num)', 'c_jadwal_ujian::viewJadwal/$1');
$routes->get('/viewAllJadwal/(:alpha)', 'c_jadwal_ujian::index/$1');
$routes->delete('/c_jadwal_ujian/delJadwal', 'c_jadwal_ujian::delJadwal');
$routes->get('/c_jadwal_ujian/editJadwal', 'c_jadwal_ujian::editJadwal');

// Profile
$routes->get('/viewProfile/(:num)', 'c_user::viewProfile/$1');
$routes->get('/c_user/updateProfile', 'c_user::updateProfile');

$routes->get('/viewSkill/(:num)', 'c_profile_pendamping::viewSkill/$1');
$routes->get('/viewAllSkill', 'c_user::viewAllSkill', ['filter' => 'role:admin']);
$routes->delete('/c_profile_pendamping/delSkill', 'c_profile_pendamping::delSkill');
$routes->get('/c_profile_pendamping/editSkill', 'c_profile_pendamping::editSkill');

$routes->get('/jenisMadif/(:num)', 'jenisMadif::jenisUserMadif/$1');
$routes->get('/viewAllJenisMadif', 'c_user::viewAllJenisMadif', ['filter' => 'role:admin']);
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
