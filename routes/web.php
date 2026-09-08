<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'beranda'])->name('beranda');
Route::get('/profil', [PageController::class, 'profil'])->name('profil');
Route::get('/pendidikan', [PageController::class, 'pendidikan'])->name('pendidikan');
Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('kegiatan');
Route::get('/berita', [PageController::class, 'berita'])->name('berita');
Route::get('/berita/{post:slug}', [PageController::class, 'beritaShow'])->name('berita.show');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::get('/pendaftaran', [PageController::class, 'pendaftaran'])->name('pendaftaran');

Route::post('/kontak', [FormController::class, 'contact'])->name('kontak.submit');
Route::post('/newsletter', [FormController::class, 'newsletter'])->name('newsletter.submit');
Route::post('/pendaftaran', [FormController::class, 'register'])->name('pendaftaran.submit');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware(EnsureAdmin::class)->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('berita', [PostController::class, 'index'])->name('berita.index');
        Route::get('berita/buat', [PostController::class, 'create'])->name('berita.create');
        Route::post('berita', [PostController::class, 'store'])->name('berita.store');
        Route::post('berita/bulk', [PostController::class, 'bulk'])->name('berita.bulk');
        Route::get('berita/{post}/edit', [PostController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{post}', [PostController::class, 'update'])->name('berita.update');
        Route::delete('berita/{post}', [PostController::class, 'destroy'])->name('berita.destroy');

        Route::get('galeri', [GalleryController::class, 'index'])->name('galeri.index');
        Route::get('galeri/buat', [GalleryController::class, 'create'])->name('galeri.create');
        Route::post('galeri', [GalleryController::class, 'store'])->name('galeri.store');
        Route::post('galeri/bulk', [GalleryController::class, 'bulk'])->name('galeri.bulk');
        Route::get('galeri/{galeri}/edit', [GalleryController::class, 'edit'])->name('galeri.edit');
        Route::put('galeri/{galeri}', [GalleryController::class, 'update'])->name('galeri.update');
        Route::delete('galeri/{galeri}', [GalleryController::class, 'destroy'])->name('galeri.destroy');

        Route::get('profil', [ProfileController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [ProfileController::class, 'update'])->name('profil.update');

        Route::get('konten', [PageContentController::class, 'edit'])->name('konten.edit');
        Route::put('konten', [PageContentController::class, 'update'])->name('konten.update');

        Route::get('program', [ProgramController::class, 'index'])->name('program.index');
        Route::get('program/buat', [ProgramController::class, 'create'])->name('program.create');
        Route::post('program', [ProgramController::class, 'store'])->name('program.store');
        Route::post('program/bulk', [ProgramController::class, 'bulk'])->name('program.bulk');
        Route::get('program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
        Route::put('program/{program}', [ProgramController::class, 'update'])->name('program.update');
        Route::delete('program/{program}', [ProgramController::class, 'destroy'])->name('program.destroy');

        Route::get('fasilitas', [FacilityController::class, 'index'])->name('fasilitas.index');
        Route::get('fasilitas/buat', [FacilityController::class, 'create'])->name('fasilitas.create');
        Route::post('fasilitas', [FacilityController::class, 'store'])->name('fasilitas.store');
        Route::post('fasilitas/bulk', [FacilityController::class, 'bulk'])->name('fasilitas.bulk');
        Route::get('fasilitas/{fasilitas}/edit', [FacilityController::class, 'edit'])->name('fasilitas.edit');
        Route::put('fasilitas/{fasilitas}', [FacilityController::class, 'update'])->name('fasilitas.update');
        Route::delete('fasilitas/{fasilitas}', [FacilityController::class, 'destroy'])->name('fasilitas.destroy');

        Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
        Route::get('faq/buat', [FaqController::class, 'create'])->name('faq.create');
        Route::post('faq', [FaqController::class, 'store'])->name('faq.store');
        Route::post('faq/bulk', [FaqController::class, 'bulk'])->name('faq.bulk');
        Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faq.edit');
        Route::put('faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');

        Route::get('timeline', [TimelineController::class, 'index'])->name('timeline.index');
        Route::get('timeline/buat', [TimelineController::class, 'create'])->name('timeline.create');
        Route::post('timeline', [TimelineController::class, 'store'])->name('timeline.store');
        Route::post('timeline/bulk', [TimelineController::class, 'bulk'])->name('timeline.bulk');
        Route::get('timeline/{timeline}/edit', [TimelineController::class, 'edit'])->name('timeline.edit');
        Route::put('timeline/{timeline}', [TimelineController::class, 'update'])->name('timeline.update');
        Route::delete('timeline/{timeline}', [TimelineController::class, 'destroy'])->name('timeline.destroy');

        Route::get('jadwal', [ScheduleController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/buat', [ScheduleController::class, 'create'])->name('jadwal.create');
        Route::post('jadwal', [ScheduleController::class, 'store'])->name('jadwal.store');
        Route::post('jadwal/bulk', [ScheduleController::class, 'bulk'])->name('jadwal.bulk');
        Route::get('jadwal/{jadwal}/edit', [ScheduleController::class, 'edit'])->name('jadwal.edit');
        Route::put('jadwal/{jadwal}', [ScheduleController::class, 'update'])->name('jadwal.update');
        Route::delete('jadwal/{jadwal}', [ScheduleController::class, 'destroy'])->name('jadwal.destroy');

        Route::get('pendaftaran', [RegistrationController::class, 'index'])->name('pendaftaran.index');
        Route::post('pendaftaran/bulk', [RegistrationController::class, 'bulk'])->name('pendaftaran.bulk');
        Route::get('pendaftaran/{pendaftaran}', [RegistrationController::class, 'show'])->name('pendaftaran.show');
        Route::put('pendaftaran/{pendaftaran}', [RegistrationController::class, 'update'])->name('pendaftaran.update');
        Route::delete('pendaftaran/{pendaftaran}', [RegistrationController::class, 'destroy'])->name('pendaftaran.destroy');

        Route::get('pesan', [ContactMessageController::class, 'index'])->name('pesan.index');
        Route::post('pesan/bulk', [ContactMessageController::class, 'bulk'])->name('pesan.bulk');
        Route::get('pesan/{pesan}', [ContactMessageController::class, 'show'])->name('pesan.show');
        Route::delete('pesan/{pesan}', [ContactMessageController::class, 'destroy'])->name('pesan.destroy');
    });
});
