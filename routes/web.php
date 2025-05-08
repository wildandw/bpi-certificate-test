<?php

use App\Http\Controllers\ScoreController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CertificateToeflJuniorController;
use App\Http\Controllers\CertificateIeltsTestCController;
use App\Http\Controllers\CertificateToeicController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Exports\ToeflExport;
use App\Exports\ToeflJuniorExport;
use App\Exports\IeltsTestCExport;
use App\Exports\ToeicExport;
use Maatwebsite\Excel\Facades\Excel;




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// upload data toefl
Route::get('/upload', [ScoreController::class, 'uploadForm'])->name('upload');
Route::post('/import', [ScoreController::class, 'importScores'])->name('scores.import');
// upload data toefl junior
Route::get('/toefljunior', [ScoreController::class, 'uploadFormJunior'])->name('uploadJunior');
Route::post('/importtoefljunior', [ScoreController::class, 'importScoresJunior'])->name('scores.importJunior');
// upload data ielts test Prediction C
Route::get('/ieltstestc', [ScoreController::class, 'uploadFormIeltsTestC'])->name('uploadIeltsTestC');
Route::post('/importieltstestc', [ScoreController::class, 'importScoresIeltsTestC'])->name('scores.importIeltsTestC');
// upload data ielts test Prediction C
Route::get('/toeic', [ScoreController::class, 'uploadFormToeic'])->name('uploadToeic');
Route::post('/importToeic', [ScoreController::class, 'importScoresToeic'])->name('scores.importToeic');

// manual
Route::get('/create', [ScoreController::class, 'create'])->name('create');
Route::post('/store', [ScoreController::class, 'store'])->name('scores.store');

// sertifikat Toefl iBT
Route::get('/toefl-scores', [CertificateController::class, 'index'])->name('data.toefl');
Route::get('/toefl-scores/{id}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/certificate/{id}/pdf', [CertificateController::class, 'downloadPdf'])->name('certificate.pdf');
// sertifikat Toefl Junior
Route::get('/toefljunior-scores', [CertificateToeflJuniorController::class, 'index'])->name('data.toefljunior');
Route::get('/toefljunior-scores/{id}', [CertificateToeflJuniorController::class, 'show'])->name('certificate.showtoefljunior');
Route::get('/certificatetoefljunior/{id}/pdf', [CertificateToeflJuniorController::class, 'downloadPdf'])->name('certificatetoefljunior.pdf');
// sertifikat IELTS Test Prediction C
Route::get('/ieltstestc-scores', [CertificateIeltsTestCController::class, 'index'])->name('data.ieltstestc');
Route::get('/ieltstestc-scores/{id}', [CertificateIeltsTestCController::class, 'show'])->name('certificate.showieltstestc');
Route::get('/certificate-ieltstestc/{id}/pdf', [CertificateIeltsTestCController::class, 'downloadPdf'])->name('certificateieltstestc.pdf');
// sertifikat TOEIC
Route::get('/toeic-scores', [CertificateToeicController::class, 'index'])->name('data.toeic');
Route::get('/toeic-scores/{id}', [CertificateToeicController::class, 'show'])->name('certificate.showtoeic');
Route::get('/certificate-toeic/{id}/pdf', [CertificateToeicController::class, 'downloadPdf'])->name('certificatetoeic.pdf');



// unduh data
// Toefl iBT
Route::get('/export-ToefliBT', function () {
    return Excel::download(new ToeflExport, 'daftar_siswa_toefl_ibt.xlsx');
})->name('toeflibt.export');
// Toefl Junior
Route::get('/export-ToeflJunior', function () {
    return Excel::download(new ToeflJuniorExport, 'daftar_siswa_toefl_junior.xlsx');
})->name('toefljunior.export');
// Ielts Test Prediction C
Route::get('/export-IeltsTestC', function () {
    return Excel::download(new IeltsTestCExport, 'daftar_siswa_ieltstestc.xlsx');
})->name('ieltstestc.export');
// Toeic
Route::get('/export-Toeic', function () {
    return Excel::download(new ToeicExport, 'daftar_siswa_toeic.xlsx');
})->name('toeic.export');





require __DIR__.'/auth.php';
