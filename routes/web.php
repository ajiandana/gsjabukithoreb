<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WartaController;
use App\Http\Controllers\BaptisController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PastoralController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriDoaController;
use App\Http\Controllers\JadwalIbadahController;
use App\Http\Controllers\PermohonanDoaController;
use App\Http\Controllers\PenyerahanAnakController;
use App\Http\Controllers\StatusPastoralController;
use App\Http\Controllers\PemberkatanNikahController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('warta', WartaController::class);
    Route::resource('jadwal-ibadah', JadwalIbadahController::class)->except(['edit', 'update']);
    Route::get('jadwal-ibadah/{id}/download', [JadwalIbadahController::class, 'download'])
         ->name('jadwal-ibadah.download');
    Route::get('status-pastoral/create', [StatusPastoralController::class, 'create'])->name('status-pastoral.create');
    Route::get('status-pastoral/{id}/edit', [StatusPastoralController::class, 'edit'])->name('status-pastoral.edit');
    Route::resource('status-pastoral', StatusPastoralController::class)->except(['create', 'edit']);
    Route::resource('pastoral', PastoralController::class);
    Route::get('pastoral/{pastoral}/preview', [PastoralController::class, 'preview'])
         ->name('pastoral.preview');
    Route::get('daerah/create', [DaerahController::class, 'create'])->name('daerah.create');
    Route::get('daerah/{id}/edit', [DaerahController::class, 'edit'])->name('daerah.edit');
    Route::resource('daerah', DaerahController::class)->except(['create', 'edit']);
    Route::resource('jemaat', JemaatController::class);
    Route::get('jemaat/{jemaat}/preview', [JemaatController::class, 'preview'])->name('jemaat.preview');
    Route::resource('event', EventController::class);
    Route::resource('departemen', DepartemenController::class)->parameters(['departemen' => 'departemen']);
    Route::post('/departemen/{departemen}/delete-slider-image', [DepartemenController::class, 'deleteSliderImage'])->name('departemen.delete-slider-image');
    Route::resource('kegiatan', KegiatanController::class);
    Route::delete('galeri/{gambar}', [KegiatanController::class, 'destroyImage'])->name('galeri.destroy');
    Route::resource('kategori-doa', KategoriDoaController::class)->except(['show']);
    Route::get('permohonan-doa', [PermohonanDoaController::class, 'index'])->name('permohonan-doa.index');
    Route::post('permohonan-doa/{permohonan}/status', [PermohonanDoaController::class, 'updateStatus'])
         ->name('permohonan-doa.update-status');
    Route::resource('permohonan-doa', PermohonanDoaController::class)->only(['index', 'destroy']);
    Route::resource('baptis', BaptisController::class);
    Route::resource('penyerahan-anak', PenyerahanAnakController::class);
    Route::resource('pemberkatan-nikah', PemberkatanNikahController::class);
});