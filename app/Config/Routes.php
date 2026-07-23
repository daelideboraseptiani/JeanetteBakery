<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'LayoutController::index');
$routes->get('/dashboard', 'LayoutController::dashboard');

/** USER **/
$routes->get('/datauser', 'UserController::datauser');
$routes->get('/datauser/tambah', 'UserController::tambah');
$routes->post('/datauser/simpan', 'UserController::simpan');
$routes->get('/datauser/edit/(:segment)', 'UserController::edit/$1');
$routes->post('/datauser/update', 'UserController::update');
$routes->get('/datauser/hapus/(:segment)', 'UserController::hapus/$1');


/** Pelanggan **/
$routes->get('/datapelanggan', 'PelangganController::datapelanggan');
$routes->get('/datapelanggan/tambah', 'PelangganController::tambah');
$routes->post('/datapelanggan/simpan', 'PelangganController::simpan');
$routes->get('/datapelanggan/edit/(:segment)', 'PelangganController::edit/$1');
$routes->post('/datapelanggan/update', 'PelangganController::update');
$routes->get('/datapelanggan/hapus/(:segment)', 'PelangganController::hapus/$1');

/** Produk **/
$routes->get('/dataproduk', 'ProdukController::dataproduk');
$routes->get('/dataproduk/tambah', 'ProdukController::tambah');
$routes->post('/dataproduk/simpan', 'ProdukController::simpan');
$routes->get('/dataproduk/edit/(:segment)', 'ProdukController::edit/$1');
$routes->post('/dataproduk/update', 'ProdukController::update');
$routes->get('/dataproduk/hapus/(:segment)', 'ProdukController::hapus/$1');

/** Kemasan **/
$routes->get('/datakemasan', 'KemasanController::datakemasan');
$routes->get('/datakemasan/tambah', 'KemasanController::tambah');
$routes->post('/datakemasan/simpan', 'KemasanController::simpan');
$routes->get('/datakemasan/edit/(:segment)', 'KemasanController::edit/$1');
$routes->post('/datakemasan/update', 'KemasanController::update');
$routes->get('/datakemasan/hapus/(:segment)', 'KemasanController::hapus/$1');

/** Bahan Baku **/
$routes->get('/databahanbaku', 'BahanBakuController::databahanbaku');
$routes->get('/databahanbaku/tambah', 'BahanBakuController::tambah');
$routes->post('/databahanbaku/simpan', 'BahanBakuController::simpan');
$routes->get('/databahanbaku/edit/(:segment)', 'BahanBakuController::edit/$1');
$routes->post('/databahanbaku/update', 'BahanBakuController::update');
$routes->get('/databahanbaku/hapus/(:segment)', 'BahanBakuController::hapus/$1');

/** Produksi **/
$routes->get('/dataproduksi', 'ProduksiController::dataproduksi');
$routes->get('/dataproduksi/tambah', 'ProduksiController::tambah');
$routes->post('/dataproduksi/simpan', 'ProduksiController::simpan');
$routes->get('/dataproduksi/edit/(:segment)', 'ProduksiController::edit/$1');
$routes->post('/dataproduksi/update', 'ProduksiController::update');
$routes->get('/dataproduksi/hapus/(:segment)', 'ProduksiController::hapus/$1');
// Update stok kemasan dari produksi
$routes->get('/dataproduksi/updatestok/(:segment)', 'ProduksiController::formUpdateStok/$1');
$routes->post('/dataproduksi/simpanupdatestok', 'ProduksiController::simpanUpdateStok');

/** Pesanan **/
$routes->get('/datapesanan', 'PesananController::datapesanan');
$routes->get('/datapesanan/tambah', 'PesananController::tambah');
$routes->post('/datapesanan/simpan', 'PesananController::simpan');
$routes->get('/datapesanan/edit/(:segment)', 'PesananController::edit/$1');
$routes->post('/datapesanan/update', 'PesananController::update');
$routes->get('/datapesanan/hapus/(:segment)', 'PesananController::hapus/$1');

/** Pembayaran **/
$routes->get('/datapembayaran', 'PembayaranController::datapembayaran');
$routes->get('/datapembayaran/tambah', 'PembayaranController::tambah');
$routes->post('/datapembayaran/simpan', 'PembayaranController::simpan');
$routes->get('/datapembayaran/edit/(:segment)', 'PembayaranController::edit/$1');
$routes->post('/datapembayaran/update', 'PembayaranController::update');
$routes->get('/datapembayaran/hapus/(:segment)', 'PembayaranController::hapus/$1');

/** LAPORAN **/
$routes->get('/laporanuser', 'LaporanController::laporanuser');
$routes->get('/laporanuser/cetak', 'LaporanController::cetakuser');
$routes->get('/laporanpelanggan', 'LaporanController::laporanpelanggan');
$routes->get('/laporanpelanggan/cetak', 'LaporanController::cetakpelanggan');
$routes->get('/laporanproduk', 'LaporanController::laporanproduk');
$routes->get('/laporanproduk/cetak', 'LaporanController::cetakproduk');
$routes->get('/laporankemasan', 'LaporanController::laporankemasan');
$routes->get('/laporankemasan/cetak', 'LaporanController::cetakkemasan');
$routes->get('/laporanbahanbaku', 'LaporanController::laporanbahanbaku');
$routes->get('/laporanbahanbaku/cetak', 'LaporanController::cetakbahanbaku');
$routes->get('/laporanproduksi', 'LaporanController::laporanproduksi');
$routes->get('/laporanproduksi/cetak', 'LaporanController::cetakproduksi');
$routes->get('/laporanpesanan', 'LaporanController::laporanpesanan');
$routes->get('/laporanpesanan/cetak', 'LaporanController::cetakpesanan');
$routes->get('/laporanpenjualan', 'LaporanController::laporanpenjualan');
$routes->get('/laporanpenjualan/cetak', 'LaporanController::cetakpenjualan');
$routes->get('/pemakaianbahanbaku', 'LaporanController::pemakaianbahanbaku');
$routes->get('/pemakaianbahanbaku/cetak', 'LaporanController::cetakpemakaianbahanbaku');
/** FAKTUR **/
$routes->get('/fakturpembayaran', 'LaporanController::fakturpembayaran');
$routes->post('/fakturpembayaran/cetak', 'LaporanController::cetakfaktur');