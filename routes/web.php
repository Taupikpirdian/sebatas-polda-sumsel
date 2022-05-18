<?php

use App\Perkara;
use App\TrafficAccident;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);
// Maintenance Web
// Route::get('/', ['as' => 'maintenance', 'uses' => 'HomeController@index']);

// Group Authenticated First
Route::group(['middleware' => ['auth']], function() {
	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'admin\AdminController@index']); // dashboard kasus
	Route::get('/lihat-data', ['as' => 'lihat-data', 'uses' => 'admin\AdminController@filter']);
	Route::get('/get-divisi/{id}', 'admin\AdminController@getDivisi');

	//change Password
	Route::get('/ubah-password','HomeController@showChangePasswordForm');
	Route::post('/changePassword','HomeController@changePassword')->name('changePassword');
	
	//User
	Route::get('/user/index', ['as' => 'index', 'uses' => 'admin\UserController@index']);
	Route::get('/user/create', ['as' => 'create', 'uses' => 'admin\UserController@create']);
	Route::post('/user/create', ['as' => 'store', 'uses' => 'admin\UserController@store']);
	Route::get('/user/edit/{id}', ['as' => 'edit', 'uses' => 'admin\UserController@edit']);
	Route::put('/user/edit/{id}', ['as' => 'edit', 'uses' => 'admin\UserController@update']);
	Route::get('/user/show/{id}', ['as' => 'show', 'uses' => 'admin\UserController@show']);
	Route::delete('/user/destroy/{id}', 'admin\UserController@destroy')->name('user.destroy');
	// Route::delete('/user/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\UserController@destroy']);
	Route::get('/searchuser', ['as' => 'searchjabatan', 'uses' => 'admin\UserController@search']);
	Route::get('/user/create/example', ['as' => 'create', 'uses' => 'admin\UserController@example']);

	// Role
	Route::resource('roles', 'admin\RoleController');
	Route::get('search-roles','admin\RoleController@search');
	Route::resource('user-groups', 'admin\UserGroupController');
	Route::delete('user-groups/destroy/{id}', 'admin\UserGroupController@destroy')->name('user-groups.destroy');
	Route::get('search-user-groups','admin\UserGroupController@search');
	Route::resource('groups', 'admin\GroupController');
	Route::get('search-groups','admin\GroupController@search');
	Route::resource('group-roles', 'admin\GroupRoleController');
	Route::get('search-group-roles','admin\GroupRoleController@search');

	// Kategori Bagian
	Route::get('/kategori-bagian/index', ['as' => 'kategori-bagian', 'uses' => 'admin\KategoriBagianController@index']);
	Route::get('/kategori-bagian/create', ['as' => 'create', 'uses' => 'admin\KategoriBagianController@create']);
	Route::post('/kategori-bagian/create', ['as' => 'store', 'uses' => 'admin\KategoriBagianController@store']);
	Route::get('/kategori-bagian/edit/{id}', ['as' => 'edit', 'uses' => 'admin\KategoriBagianController@edit']);
	Route::put('/kategori-bagian/edit/{id}', ['as' => 'edit', 'uses' => 'admin\KategoriBagianController@update']);
	Route::get('/kategori-bagian/show/{id}', ['as' => 'show', 'uses' => 'admin\KategoriBagianController@show']);
	Route::delete('/kategori-bagian/destroy/{id}', 'admin\KategoriBagianController@destroy')->name('kategoribagian.destroy');
	// Route::delete('/kategori-bagian/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\KategoriBagianController@destroy']);
	Route::get('/searchkategori-bagian', ['as' => 'searchkategori-bagian', 'uses' => 'admin\KategoriBagianController@search']);

	// Kategori
	Route::get('/kategori/index', ['as' => 'kategori', 'uses' => 'admin\KategoriController@index']);
	Route::get('/kategori/create', ['as' => 'create', 'uses' => 'admin\KategoriController@create']);
	Route::post('/kategori/create', ['as' => 'store', 'uses' => 'admin\KategoriController@store']);
	Route::get('/kategori/edit/{id}', ['as' => 'edit', 'uses' => 'admin\KategoriController@edit']);
	Route::put('/kategori/edit/{id}', ['as' => 'edit', 'uses' => 'admin\KategoriController@update']);
	Route::get('/kategori/show/{id}', ['as' => 'show', 'uses' => 'admin\KategoriController@show']);
	Route::delete('/kategori/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\KategoriController@destroy']);
	Route::get('/searchkategori', ['as' => 'searchkategori', 'uses' => 'admin\KategoriController@search']);

	// Perkara
	Route::get('/perkara/index', ['as' => 'perkara', 'uses' => 'admin\PerkaraController@index']);
	Route::get('/perkara/create', ['as' => 'create', 'uses' => 'admin\PerkaraController@create']);
	Route::post('/perkara/create', ['as' => 'store', 'uses' => 'admin\PerkaraController@store']);
	Route::get('/perkara/edit/{id}', ['as' => 'edit', 'uses' => 'admin\PerkaraController@edit']);
	Route::put('/perkara/edit/{id}', ['as' => 'edit', 'uses' => 'admin\PerkaraController@update']);
	Route::get('/perkara/show/{id}', ['as' => 'show', 'uses' => 'admin\PerkaraController@show']);
	Route::delete('/perkara/destroy/{id}', 'admin\PerkaraController@destroy')->name('perkara.destroy');
	Route::get('/perkara/update-anggaran/{id}', ['as' => 'update-anggaran', 'uses' => 'admin\PerkaraController@updateAnggaran']);
	Route::put('/perkara/update-anggaran/{id}', ['as' => 'update-anggaran', 'uses' => 'admin\PerkaraController@storeUpdateAnggaran']);
	// Route::delete('/perkara/destroy/{id}', 'admin\PerkaraController@destroy')->name('perkara.destroy');
	Route::get('/filter-date-this', ['as' => 'searchperkara', 'uses' => 'admin\PerkaraController@dateRangeThis']);
	Route::get('/filter-date-last', ['as' => 'searchperkara', 'uses' => 'admin\PerkaraController@dateRangeLast']);
	Route::get('/perkara/last-year', ['as' => 'perkara', 'uses' => 'admin\PerkaraController@lastYear']);
	Route::get('/perkara/this-year', ['as' => 'perkara', 'uses' => 'admin\PerkaraController@thisYear']);
	Route::get('/perkara/update/{id}', ['as' => 'update', 'uses' => 'admin\PerkaraController@updateData']);
	Route::put('/perkara/update/{id}', ['as' => 'edit', 'uses' => 'admin\PerkaraController@updated']);
	Route::get('/filter-date-this', ['as' => 'searchperkara', 'uses' => 'admin\PerkaraController@dateRangeThis']);
	Route::get('/filter-last', ['as' => 'filterlastperkara', 'uses' => 'admin\PerkaraController@lastYear']);
	Route::get('/filter-this', ['as' => 'filterlastperkara', 'uses' => 'admin\PerkaraController@thisYear']);
	Route::put('/upload/pdf/{id}', ['as' => 'upload.pdf', 'uses' => 'admin\PerkaraController@uploadPdf']);
	// lipah perkara
	Route::get('/perkara/limpah-perkara/{id}', ['as' => 'limpah-perkara', 'uses' => 'admin\PerkaraController@limpahPerkara']);
	Route::get('dropdown-list/limpah-perkara/{id}','admin\PerkaraController@getStates');
	Route::put('/perkara/limpah-perkara-post/{id}', ['as' => 'limpah-perkara-post', 'uses' => 'admin\PerkaraController@limpahPerkaraPost']);

	// Status
	Route::get('/status/index', ['as' => 'status', 'uses' => 'admin\StatusController@index']);
	Route::get('/status/create', ['as' => 'create', 'uses' => 'admin\StatusController@create']);
	Route::post('/status/create', ['as' => 'store', 'uses' => 'admin\StatusController@store']);
	Route::get('/status/edit/{id}', ['as' => 'edit', 'uses' => 'admin\StatusController@edit']);
	Route::put('/status/edit/{id}', ['as' => 'edit', 'uses' => 'admin\StatusController@update']);
	Route::get('/status/show/{id}', ['as' => 'show', 'uses' => 'admin\StatusController@show']);
	Route::delete('/status/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\StatusController@destroy']);
	Route::get('/searchstatus', ['as' => 'searchstatus', 'uses' => 'admin\StatusController@search']);

	// Jenis Pidana
	Route::get('/jenis-pidana/index', ['as' => 'jenis-pidana', 'uses' => 'admin\JenisPidanaController@index']);
	Route::get('/jenis-pidana/create', ['as' => 'create', 'uses' => 'admin\JenisPidanaController@create']);
	Route::post('/jenis-pidana/create', ['as' => 'store', 'uses' => 'admin\JenisPidanaController@store']);
	Route::get('/jenis-pidana/edit/{id}', ['as' => 'edit', 'uses' => 'admin\JenisPidanaController@edit']);
	Route::put('/jenis-pidana/edit/{id}', ['as' => 'edit', 'uses' => 'admin\JenisPidanaController@update']);
	Route::get('/jenis-pidana/show/{id}', ['as' => 'show', 'uses' => 'admin\JenisPidanaController@show']);
	Route::delete('/jenis-pidana/destroy/{id}', 'admin\JenisPidanaController@destroy')->name('jenispidana.destroy');
	// Route::delete('/jenis-pidana/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\JenisPidanaController@destroy']);
	Route::get('/searchjenis-pidana', ['as' => 'searchjenis-pidana', 'uses' => 'admin\JenisPidanaController@search']);

	// Akses
	Route::get('/akses/index', ['as' => 'akses', 'uses' => 'admin\AksesController@index']);
	Route::get('/akses/create', ['as' => 'create', 'uses' => 'admin\AksesController@create']);
	Route::post('/akses/create', ['as' => 'store', 'uses' => 'admin\AksesController@store']);
	Route::get('/akses/edit/{id}', ['as' => 'edit', 'uses' => 'admin\AksesController@edit']);
	Route::put('/akses/edit/{id}', ['as' => 'edit', 'uses' => 'admin\AksesController@update']);
	Route::get('/akses/show/{id}', ['as' => 'show', 'uses' => 'admin\AksesController@show']);
	Route::delete('/akses/destroy/{id}', 'admin\AksesController@destroy')->name('akses.destroy');
	// Route::delete('/akses/destroy/{id}', ['as' => 'destroy', 'uses' => 'admin\AksesController@destroy']);
	Route::get('/searchakses', ['as' => 'searchakses', 'uses' => 'admin\AksesController@search']);

	// Export Excell
	Route::get('/grouping/export_excel', 'admin\AdminController@export_excel');
	Route::get('/bukti/export-excel', 'admin\BuktiLainController@exportExcel');

	// Laporan
	Route::get('/rekapitulasi', 'admin\LaporanController@index');
	Route::get('/rekapitulasi-polda', 'admin\LaporanController@rekapPolda');
	Route::get('/rekapitulasi-polres', 'admin\LaporanController@listRekapPolres');
	Route::get('/data-polres/{id}/sumbar', 'admin\LaporanController@rekapPolres');
	Route::get('/satker-bawah-polres/{id}/sumbar', 'admin\LaporanController@satkerPolres');
	// sepertinya gk kepake ini
	Route::get('/data-polres/sumbar/search', 'admin\LaporanController@rekapPolresSearch');
	Route::get('/data-polsek/sumbar/filter', 'admin\LaporanController@rekapPolsekFilter');
	Route::get('/data-polda/sumbar/filter', 'admin\LaporanController@rekapPoldaFilter');
	// filter fitur laporan
	Route::get('/search-rekapitulasi', 'admin\LaporanController@rekapSearch');
	Route::get('/filter-polda', ['as' => 'filterpolda', 'uses' => 'admin\LaporanController@rekapPolda']);
	Route::get('/search-rekapitulasi-polres', 'admin\LaporanController@searchlistRekapPolres');
	Route::get('/search-rekapitulasi-polsek', 'admin\LaporanController@searchlistRekapPolsek');
	Route::get('/filter-polsek/{id}',['as' => 'filterposek', 'uses' => 'admin\LaporanController@rekapPolsek']);
	Route::get('/lihat-polres', ['as' => 'lihat-polres', 'uses' => 'admin\LaporanController@rekapPolres']);
	Route::get('/filter-satker-bawah-polres/{id}/sumbar', 'admin\LaporanController@satkerPolres');
	Route::get('/rekapitulasi-polsek', 'admin\LaporanController@listRekapPolsek');
	Route::get('/data-polsek/{id}/sumbar', 'admin\LaporanController@rekapPolsek');

	// profile
	Route::get('/profil', 'admin\AdminController@profil');

	// Bukti Lain
	Route::get('/bukti-lain/index', ['as' => 'jenis-pidana', 'uses' => 'admin\BuktiLainController@index']);
	Route::get('/bukti-lain/create', ['as' => 'create', 'uses' => 'admin\BuktiLainController@create']);
	Route::post('/bukti-lain/create', ['as' => 'store', 'uses' => 'admin\BuktiLainController@store']);
	Route::get('/bukti-lain/show/{id}', ['as' => 'show', 'uses' => 'admin\BuktiLainController@show']);
	Route::delete('/bukti-lain/destroy/{id}', 'admin\BuktiLainController@destroy')->name('bukti.destroy');
	Route::get('/bukti-lain-search', ['as' => 'bukti-lain-search', 'uses' => 'admin\BuktiLainController@ViewLaporan']);
	Route::get('/view-bukti-lain', ['as' => 'view-bukti-lain', 'uses' => 'admin\BuktiLainController@ViewLaporan']);
	Route::get('/bukti-lain-search-user', ['as' => 'bukti-lain-search-user', 'uses' => 'admin\BuktiLainController@index']);

	// Cek API
	Route::get('/bukti-lain/check', ['as' => 'check-api', 'uses' => 'admin\BuktiLainController@checkApi']);

	// Route For AJAX
	Route::get('perkara/ajax-perkara', 'AjaxController@index')->name('perkara.ajax');
	// tiketing
	Route::post('/perkara/tiket/{id}', 'admin\PerkaraController@tiket')->name('perkara.tiket');

	// anggaran
	Route::resource('anggaran','admin\AnggaranController');
	Route::get('/rekap-anggaran', ['as' => 'show', 'uses' => 'admin\AnggaranController@rekapAnggaran']);

	// log
	Route::resource('logs', 'admin\LogController');
	// show pdf
	Route::get('/show-pdf/{id}', function($id) { 
		$file = Perkara::find($id); 
		return response()->file(storage_path('app/public/file/'.$file->document)); 
	})->name('show-pdf');

	// Jenis Narkoba
	Route::get('/jenis-narkoba/index', ['as' => 'jenis-narkoba', 'uses' => 'admin\JenisNarkobaController@index']);
	Route::get('/jenis-narkoba/create', ['as' => 'create', 'uses' => 'admin\JenisNarkobaController@create']);
	Route::post('/jenis-narkoba/create', ['as' => 'store', 'uses' => 'admin\JenisNarkobaController@store']);
	Route::get('/jenis-narkoba/edit/{id}', ['as' => 'edit', 'uses' => 'admin\JenisNarkobaController@edit']);
	Route::put('/jenis-narkoba/edit/{id}', ['as' => 'edit', 'uses' => 'admin\JenisNarkobaController@update']);
	Route::delete('/jenis-narkoba/destroy/{id}', 'admin\JenisNarkobaController@destroy')->name('jenisnarkoba.destroy');
	// ===========================================admin==================================================================

	/**
	 * Polres Section
	 */

	// report
	Route::get('/polsek/list-satker', ['as' => 'polsek-list-satker', 'uses' => 'LaporanController@index']);
	Route::get('/polsek/list-perkara/{id}', ['as' => 'polsek-list-perkara', 'uses' => 'LaporanController@indexPerkara']);

	// view data from dashboard
	Route::get('/list-data', ['as' => 'list-data', 'uses' => 'admin\AdminController@listData']);

});

// tes engine email
Route::get('mail/testing', 'MailController@index');