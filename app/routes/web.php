<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VotingController;
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;

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
Route::get('/',[VotingController::class,'index'])->name('voting.home');

Route::post('login-voting', [VotingController::class, 'login'])->name('voting.login');
Route::get('logout-voting', [VotingController::class, 'logout'])->name('voting.logout');
Route::get('info', [VotingController::class, 'infoLogin'])->name('voting.info')->middleware('cekToken');
Route::get('kandidat', [VotingController::class, 'listKandidat'])->name('voting.kandidat')->middleware('cekToken');
Route::get('kandidat/profil', [VotingController::class, 'kandidatProfile'])->name('voting.profil')->middleware('cekToken');
Route::get('kandidat/resume/{nomor}', [VotingController::class, 'resumeData'])->name('cv.kandidat')->middleware('cekToken');
Route::get('kandidat/visimisi/{nomor}', [VotingController::class, 'visimisiData'])->name('visimisi.kandidat')->middleware('cekToken');
Route::post('voting', [VotingController::class, 'pilih'])->name('voting.pilih')->middleware('cekToken');


Route::prefix('admin')->group(function (){
    // Auth

    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest');

    Route::post('login', [LoginController::class, 'login'])
        ->name('login.attempt')
        ->middleware('guest');

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');

// Dashboard

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard.home')
        ->middleware('auth');
    Route::get('/home', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('auth');

    Route::get('hasil', [DashboardController::class, 'hasil'])
        ->name('dashboard.hasil')
        ->middleware('auth');

// Users

    Route::get('users', [UsersController::class, 'index'])
        ->name('users')
        ->middleware('remember', 'auth');

    Route::get('users/create', [UsersController::class, 'create'])
        ->name('users.create')
        ->middleware('auth');

    Route::post('users', [UsersController::class, 'store'])
        ->name('users.store')
        ->middleware('auth');

    Route::get('users/{user}/edit', [UsersController::class, 'edit'])
        ->name('users.edit')
        ->middleware('auth');

    Route::put('users/{user}', [UsersController::class, 'update'])
        ->name('users.update')
        ->middleware('auth');

    Route::delete('users/{user}', [UsersController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('auth');

    Route::put('users/{user}/restore', [UsersController::class, 'restore'])
        ->name('users.restore')
        ->middleware('auth');

//Mahasiswa a.k.a Pemilih
    Route::get('mahasiswa', [MahasiswaController::class, 'index'])
        ->name('mahasiswa')
        ->middleware('remember', 'auth');

    Route::get('mahasiswa-reset', [MahasiswaController::class, 'resetAllPilihan'])
        ->name('mahasiswa.reset')
        ->middleware('remember', 'auth');

    Route::get('pemilih', [KelasController::class, 'index'])
        ->name('pemilih')
        ->middleware('remember', 'auth');

    Route::get('list-aktif', [KelasController::class, 'activeLists'])
        ->name('pemilih.list')
        ->middleware('remember', 'auth');

    Route::get('pemilih/aktif', [KelasController::class, 'activeStatus'])
        ->name('pemilih.aktif')
        ->middleware('remember', 'auth');

    Route::get('pemilih/aktif/prodi/{prodi}', [KelasController::class, 'activeStatus2'])
        ->name('pemilih.aktif2')->where('prodi', '[0-9]+')
        ->middleware('remember', 'auth');

    Route::get('pemilih/aktif/angkatan/{angkatan}', [KelasController::class, 'activeStatus2'])
        ->name('pemilih.aktif3')->where('angkatan', '[0-9]+')
        ->middleware('remember', 'auth');

    Route::get('pemilih/nonaktif', [KelasController::class, 'deactiveStatus'])
        ->name('pemilih.nonaktif')
        ->middleware('remember', 'auth');

    Route::get('pemilih/aktif/{id}', [KelasController::class, 'activeStatus'])
        ->name('pemilih.aktif.id')->where('id', '[0-9]+')
        ->middleware('auth');

    Route::get('pemilih/nonaktif/{id}', [KelasController::class, 'deactiveStatus'])
        ->name('pemilih.nonaktif.id')->where('id', '[0-9]+')
        ->middleware('auth');

    //Kandidat
    Route::delete('kandidat/{kandidat}', [KandidatController::class, 'delete'])
        ->name('kandidat.delete')
        ->middleware('remember', 'auth');

    Route::get('kandidat', [KandidatController::class, 'index'])
        ->name('kandidat')
        ->middleware('remember', 'auth');

    Route::get('kandidat/create', [KandidatController::class, 'create'])
        ->name('kandidat.create')
        ->middleware('remember', 'auth');

    Route::get('kandidat/{kandidat}/edit', [KandidatController::class, 'edit'])
        ->name('kandidat.edit')
        ->middleware('remember', 'auth');

    Route::post('kandidat', [KandidatController::class, 'store'])
        ->name('kandidat.store')
        ->middleware('auth');

    Route::put('kandidat/{kandidat}', [KandidatController::class, 'update'])
        ->name('kandidat.update')
        ->middleware('auth');


});
Route::get('import', [MahasiswaController::class, 'indexImport'])->name('mhs.index')->middleware('auth');;
Route::get('/mhs/export', [MahasiswaController::class, 'export'])->name('mhs.export')->middleware('auth');;
Route::get('/hasil/export', [DashboardController::class, 'export'])->name('hasil.export')->middleware('auth');;
Route::get('/hasil-angkatan', [DashboardController::class, 'hasilPerAngkatan'])->name('mhs.hasil.export')->middleware('auth');;
Route::post('/mhs/import', [MahasiswaController::class, 'import'])->name('mhs.import')->middleware('auth');;
Route::get('/mhs/delete', [MahasiswaController::class, 'deleteAll'])->name('mhs.delete')->middleware('auth');;

//Route::get('/mhs/{kelas}', [MahasiswaController::class, 'MahasiswaKelas'])->name('mhs.import');
// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');
// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

//    echo $fail = "test";
});

