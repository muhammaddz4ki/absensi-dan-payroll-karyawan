<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// #1 RUTE UTAMA & LOGIN
$routes->get('/', 'LoginController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/process', 'LoginController::process');
$routes->get('/logout', 'LoginController::logout');

// #2 RUTE ADMIN (SEMUA DI DALAM GRUP INI DILINDUNGI FILTER AUTH)
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    
    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Jabatan
    $routes->get('jabatan/edit/(:num)', 'Admin\JabatanController::edit/$1');
    $routes->resource('jabatan', ['controller' => 'Admin\JabatanController']);

    // Karyawan
    $routes->get('karyawan/edit/(:num)', 'Admin\KaryawanController::edit/$1');
    $routes->post('karyawan/update-jatah-cuti/(:num)', 'Admin\KaryawanController::updateJatahCuti/$1');
    $routes->resource('karyawan', ['controller' => 'Admin\KaryawanController']);

    // Pengaturan
    $routes->get('pengaturan', 'Admin\PengaturanController::index');
    $routes->post('pengaturan/update', 'Admin\PengaturanController::update');

    // Riwayat Absensi
    $routes->get('riwayat', 'Admin\RiwayatController::index');

    // Manajemen Absensi
    $routes->get('manajemen-absensi', 'Admin\ManajemenAbsensiController::index');
    $routes->post('manajemen-absensi/save', 'Admin\ManajemenAbsensiController::save');

    // Payroll
    $routes->get('payroll', 'Admin\PayrollController::index');
    $routes->post('payroll/generate', 'Admin\PayrollController::generate');
    $routes->get('payroll/laporan', 'Admin\PayrollController::laporan');
    $routes->get('payroll/detail/(:num)', 'Admin\PayrollController::detail/$1');
    $routes->get('payroll/edit/(:num)', 'Admin\PayrollController::edit/$1');
    $routes->post('payroll/update/(:num)', 'Admin\PayrollController::update/$1');
    // PERBAIKAN DI SINI: UBAH DARI POST MENJADI DELETE
    $routes->delete('payroll/delete/(:num)', 'Admin\PayrollController::delete/$1');
    $routes->get('cuti', 'Admin\CutiController::index');
    $routes->post('cuti/process/(:num)', 'Admin\CutiController::process/$1');

    $routes->get('lembur', 'Admin\LemburController::index');
    $routes->post('lembur/process/(:num)', 'Admin\LemburController::process/$1');


});


// #3 RUTE KARYAWAN (DILINDUNGI FILTER AUTH)
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/absensi', 'AbsensiController::index', ['filter' => 'auth']);
$routes->post('/absensi/proses', 'AbsensiController::prosesAbsen', ['filter' => 'auth']);
$routes->get('/riwayat', 'RiwayatController::index', ['filter' => 'auth']);
$routes->get('/pengajuan', 'PengajuanController::index', ['filter' => 'auth']);
$routes->post('/pengajuan/save', 'PengajuanController::save', ['filter' => 'auth']);
$routes->get('/slip-gaji', 'SlipGajiController::index', ['filter' => 'auth']);
$routes->get('/slip-gaji/detail/(:num)', 'SlipGajiController::detail/$1', ['filter' => 'auth']);
$routes->get('cuti', 'CutiController::index', ['filter' => 'auth']);
$routes->get('cuti/ajukan', 'CutiController::ajukan', ['filter' => 'auth']);
$routes->post('cuti/save', 'CutiController::save', ['filter' => 'auth']);
$routes->get('profil', 'ProfilController::index');
$routes->post('profil/update-password', 'ProfilController::updatePassword');
$routes->get('lembur', 'LemburController::index', ['filter' => 'auth']);
$routes->get('lembur/ajukan', 'LemburController::ajukan', ['filter' => 'auth']);
$routes->post('lembur/save', 'LemburController::save', ['filter' => 'auth']);


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
