<?php


use App\Http\Controllers\ToeflController;
use App\Http\Controllers\IeltsTestCController;
use App\Http\Controllers\ToeflJuniorController;
use App\Http\Controllers\ToeflPrimaryStep1Controller;
use App\Http\Controllers\ToeflPrimaryStep2Controller;
use App\Http\Controllers\ToeicController;
use App\Http\Controllers\ScoreController;

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CertificateToeflJuniorController;
use App\Http\Controllers\CertificateIeltsTestCController;
use App\Http\Controllers\CertificateToeicController;
use App\Http\Controllers\CertificateToeflPrimaryStep1Controller;
use App\Http\Controllers\CertificateToeflPrimaryStep2Controller;

use App\Http\Controllers\PanduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Exports\ToeflExport;
use App\Exports\ToeflJuniorExport;
use App\Exports\IeltsTestCExport;
use App\Exports\ToeicExport;
use App\Exports\ToeflPrimaryStep1Export;
use App\Exports\ToeflPrimaryStep2Export;
use Maatwebsite\Excel\Facades\Excel;




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan');

// upload data toefl
Route::get('/upload', [ToeflController::class, 'uploadForm'])->name('upload');
Route::post('/import', [ToeflController::class, 'importScores'])->name('scores.import');
// upload data toefl junior
Route::get('/toefljunior-upload', [ToeflJuniorController::class, 'uploadFormJunior'])->name('uploadJunior');
Route::post('/importtoefljunior', [ToeflJuniorController::class, 'importScoresJunior'])->name('scores.importJunior');
// upload data ielts test Prediction C
Route::get('/ieltstestc-upload', [IeltsTestCController::class, 'uploadFormIeltsTestC'])->name('uploadIeltsTestC');
Route::post('/importieltstestc', [IeltsTestCController::class, 'importScoresIeltsTestC'])->name('scores.importIeltsTestC');
// upload data toeic
Route::get('/toeic-upload', [ToeicController::class, 'uploadFormToeic'])->name('uploadToeic');
Route::post('/importToeic', [ToeicController::class, 'importScoresToeic'])->name('scores.importToeic');
// upload data toefl primary step 1
Route::get('/toeflprimarystep1-upload', [ToeflPrimaryStep1Controller::class, 'uploadFormToeflPrimaryStep1'])->name('uploadToeflPrimaryStep1');
Route::post('/importToeflPrimaryStep1', [ToeflPrimaryStep1Controller::class, 'importScoresToeflPrimaryStep1'])->name('scores.importToeflPrimaryStep1');
// upload data toefl primary step 2
Route::get('/toeflprimarystep2-upload', [ToeflPrimaryStep2Controller::class, 'uploadFormToeflPrimaryStep2'])->name('uploadToeflPrimaryStep2');
Route::post('/importToeflPrimaryStep2', [ToeflPrimaryStep2Controller::class, 'importScoresToeflPrimaryStep2'])->name('scores.importToeflPrimaryStep2');
// manual
Route::get('/create', [ScoreController::class, 'create'])->name('create');
Route::post('/store', [ScoreController::class, 'store'])->name('scores.store');

// umum
// upload data toefl
Route::get('/upload-umum', [ToeflController::class, 'uploadFormumum'])->name('uploadumum');
Route::post('/import-umum', [ToeflController::class, 'importScoresumum'])->name('scores.importumum');
// upload data toefl junior
Route::get('/toefljuniorupload-umum', [ToeflJuniorController::class, 'uploadFormJuniorumum'])->name('uploadJuniorumum');
Route::post('/importtoefljunior-umum', [ToeflJuniorController::class, 'importScoresJuniorumum'])->name('scores.importJuniorumum');
// upload data ielts test Prediction C
Route::get('/ieltstestcupload-umum', [IeltsTestCController::class, 'uploadFormIeltsTestCumum'])->name('uploadIeltsTestCumum');
Route::post('/importieltstestc-umum', [IeltsTestCController::class, 'importScoresIeltsTestCumum'])->name('scores.importIeltsTestCumum');
// upload data toeic
Route::get('/toeicupload-umum', [ToeicController::class, 'uploadFormToeicumum'])->name('uploadToeicumum');
Route::post('/importToeic-umum', [ToeicController::class, 'importScoresToeicumum'])->name('scores.importToeicumum');
// upload data toefl primary step 1
Route::get('/toeflprimarystep1upload-umum', [ToeflPrimaryStep1Controller::class, 'uploadFormToeflPrimaryStep1umum'])->name('uploadToeflPrimaryStep1umum');
Route::post('/importToeflPrimaryStep1-umum', [ToeflPrimaryStep1Controller::class, 'importScoresToeflPrimaryStep1umum'])->name('scores.importToeflPrimaryStep1umum');
// upload data toefl primary step 2
Route::get('/toeflprimarystep2upload-umum', [ToeflPrimaryStep2Controller::class, 'uploadFormToeflPrimaryStep2umum'])->name('uploadToeflPrimaryStep2umum');
Route::post('/importToeflPrimaryStep2-umum', [ToeflPrimaryStep2Controller::class, 'importScoresToeflPrimaryStep2umum'])->name('scores.importToeflPrimaryStep2umum');





// edit,hapus dan search data
// toefl ibt
Route::put('/toefl/{id}', [ToeflController::class, 'updatetoefl'])
     ->name('toefl.update');
// Hapus satu siswa
Route::delete('/toefl/{id}', [ToeflController::class, 'destroytoefl'])
     ->name('toefl.destroy');
// Hapus semua siswa
Route::delete('/toefl', [ToeflController::class, 'destroyalltoefl'])
     ->name('toefl.destroyall');
// search siswa
Route::get('/toefl', [ToeflController::class, 'index'])
     ->name('toefl.index');

// toefl junior
Route::put('/toefljunior/{id}', [ToeflJuniorController::class, 'updatetoefljunior'])
     ->name('toefljunior.update');
// Hapus satu siswa
Route::delete('/toefljunior/{id}', [ToeflJuniorController::class, 'destroytoefljunior'])
     ->name('toefljunior.destroy');
// Hapus semua siswa
Route::delete('/toefljunior', [ToeflJuniorController::class, 'destroyalltoefljunior'])
     ->name('toefljunior.destroyall');
// search siswa
Route::get('/toefljunior', [ToeflJuniorController::class, 'index'])
     ->name('toefljunior.index');

// ielts
Route::put('/ielts/{id}', [IeltsTestCController::class, 'updateielts'])
     ->name('ielts.update');
// Hapus satu siswa
Route::delete('/ielts/{id}', [IeltsTestCController::class, 'destroyielts'])
     ->name('ielts.destroy');
// Hapus semua siswa
Route::delete('/ielts', [IeltsTestCController::class, 'destroyallielts'])
     ->name('ielts.destroyall');
// search siswa
Route::get('/ielts', [IeltsTestCController::class, 'index'])
     ->name('ielts.index');

// primary step 1
Route::put('/toeflprimarystep1/{id}', [ToeflPrimaryStep1Controller::class, 'updatetoeflprimarystep1'])
     ->name('toeflprimarystep1.update');
// Hapus satu siswa
Route::delete('/toeflprimarystep1/{id}', [ToeflPrimaryStep1Controller::class, 'destroytoeflprimarystep1'])
     ->name('toeflprimarystep1.destroy');
// Hapus semua siswa
Route::delete('/toeflprimarystep1', [ToeflPrimaryStep1Controller::class, 'destroyalltoeflprimarystep1'])
     ->name('toeflprimarystep1.destroyall');
// search siswa
Route::get('/toeflprimarystep1', [ToeflPrimaryStep1Controller::class, 'index'])
     ->name('toeflprimarystep1.index');

// primary step 2
Route::put('/toeflprimarystep2/{id}', [ToeflPrimaryStep2Controller::class, 'updatetoeflprimarystep2'])
     ->name('toeflprimarystep2.update');
// Hapus satu siswa
Route::delete('/toeflprimarystep2/{id}', [ToeflPrimaryStep2Controller::class, 'destroytoeflprimarystep2'])
     ->name('toeflprimarystep2.destroy');
// Hapus semua siswa
Route::delete('/toeflprimarystep2', [ToeflPrimaryStep2Controller::class, 'destroyalltoeflprimarystep2'])
     ->name('toeflprimarystep2.destroyall');
// search siswa
Route::get('/toeflprimarystep2', [ToeflPrimaryStep2Controller::class, 'index'])
     ->name('toeflprimarystep2.index');

// toeic
Route::put('/toeic/{id}', [ToeicController::class, 'updatetoeic'])
     ->name('toeic.update');
// Hapus satu siswa
Route::delete('/toeic/{id}', [ToeicController::class, 'destroytoeic'])
     ->name('toeic.destroy');
// Hapus semua siswa
Route::delete('/toeic', [ToeicController::class, 'destroyalltoeic'])
     ->name('toeic.destroyall');
// search siswa
Route::get('/toeic', [ToeicController::class, 'index'])
     ->name('toeic.index');

// umum
// toefl ibt
Route::put('/toefl-umum/{id}', [ToeflController::class, 'updatetoeflumum'])
     ->name('toefl.updateumum');
// Hapus satu siswa
Route::delete('/toefl-umum/{id}', [ToeflController::class, 'destroytoeflumum'])
     ->name('toefl.destroyumum');
// Hapus semua siswa
Route::delete('/toefl-umum', [ToeflController::class, 'destroyalltoeflumum'])
     ->name('toefl.destroyallumum');
// search siswa
Route::get('/toefl-umum', [ToeflController::class, 'indexumum'])
     ->name('toefl.indexumum');

// toefl junior
Route::put('/toefljunior-umum/{id}', [ToeflJuniorController::class, 'updatetoefljuniorumum'])
     ->name('toefljunior.updateumum');
// Hapus satu siswa
Route::delete('/toefljunior-umum/{id}', [ToeflJuniorController::class, 'destroytoefljunior-umum'])
     ->name('toefljunior.destroy-umum');
// Hapus semua siswa
Route::delete('/toefljunior-umum', [ToeflJuniorController::class, 'destroyalltoefljuniorumum'])
     ->name('toefljunior.destroyallumum');
// search siswa
Route::get('/toefljunior-umum', [ToeflJuniorController::class, 'indexumum'])
     ->name('toefljunior.indexumum');

// ielts
Route::put('/ielts-umum/{id}', [IeltsTestCController::class, 'updateieltsumum'])
     ->name('ielts.updateumum');
// Hapus satu siswa
Route::delete('/ielts-umum/{id}', [IeltsTestCController::class, 'destroyieltsumum'])
     ->name('ielts.destroyumum');
// Hapus semua siswa
Route::delete('/ielts-umum', [IeltsTestCController::class, 'destroyallieltsumum'])
     ->name('ielts.destroyallumum');
// search siswa
Route::get('/ielts-umum', [IeltsTestCController::class, 'indexumum'])
     ->name('ielts.indexumum');

// primary step 1
Route::put('/toeflprimarystep1-umum/{id}', [ToeflPrimaryStep1Controller::class, 'updatetoeflprimarystep1umum'])
     ->name('toeflprimarystep1.updateumum');
// Hapus satu siswa
Route::delete('/toeflprimarystep1-umum/{id}', [ToeflPrimaryStep1Controller::class, 'destroytoeflprimarystep1umum'])
     ->name('toeflprimarystep1.destroyumum');
// Hapus semua siswa
Route::delete('/toeflprimarystep1-umum', [ToeflPrimaryStep1Controller::class, 'destroyalltoeflprimarystep1umum'])
     ->name('toeflprimarystep1.destroyallumum');
// search siswa
Route::get('/toeflprimarystep1-umum', [ToeflPrimaryStep1Controller::class, 'indexumum'])
     ->name('toeflprimarystep1.indexumum');

// primary step 2
Route::put('/toeflprimarystep2-umum/{id}', [ToeflPrimaryStep2Controller::class, 'updatetoeflprimarystep2umum'])
     ->name('toeflprimarystep2.updateumum');
// Hapus satu siswa
Route::delete('/toeflprimarystep2-umum/{id}', [ToeflPrimaryStep2Controller::class, 'destroytoeflprimarystep2umum'])
     ->name('toeflprimarystep2.destroyumum');
// Hapus semua siswa
Route::delete('/toeflprimarystep2-umum', [ToeflPrimaryStep2Controller::class, 'destroyalltoeflprimarystep2umum'])
     ->name('toeflprimarystep2.destroyallumum');
// search siswa
Route::get('/toeflprimarystep2-umum', [ToeflPrimaryStep2Controller::class, 'indexumum'])
     ->name('toeflprimarystep2.indexumum');

// toeic
Route::put('/toeic-umum/{id}', [ToeicController::class, 'updatetoeicumum'])
     ->name('toeic.updateumum');
// Hapus satu siswa
Route::delete('/toeic-umum/{id}', [ToeicController::class, 'destroytoeicumum'])
     ->name('toeic.destroyumum');
// Hapus semua siswa
Route::delete('/toeic-umum', [ToeicController::class, 'destroyalltoeicumum'])
     ->name('toeic.destroyallumum');
// search siswa
Route::get('/toeic-umum', [ToeicController::class, 'indexumum'])
     ->name('toeic.indexumum');





// sertifikat Toefl iBT
Route::get('/toefl-scores', [CertificateController::class, 'index'])->name('data.toefl');
Route::get('/toefl-scores/{id}', [CertificateController::class, 'show'])->name('certificate.showibt');
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
// sertifikat TOEFL Primary Step 1
Route::get('/toeflprimarystep1-scores', [CertificateToeflPrimaryStep1Controller::class, 'index'])->name('data.toeflprimarystep1');
Route::get('/toeflprimarystep1-scores/{id}', [CertificateToeflPrimaryStep1Controller::class, 'show'])->name('certificate.showtoeflprimarystep1');
Route::get('/certificate-toeflprimarystep1/{id}/pdf', [CertificateToeflPrimaryStep1Controller::class, 'downloadPdf'])->name('certificatetoeflprimarystep1.pdf');
// sertifikat TOEFL Primary Step 2
Route::get('/toeflprimarystep2-scores', [CertificateToeflPrimaryStep2Controller::class, 'index'])->name('data.toeflprimarystep2');
Route::get('/toeflprimarystep2-scores/{id}', [CertificateToeflPrimaryStep2Controller::class, 'show'])->name('certificate.showtoeflprimarystep2');
Route::get('/certificate-toeflprimarystep2/{id}/pdf', [CertificateToeflPrimaryStep2Controller::class, 'downloadPdf'])->name('certificatetoeflprimarystep2.pdf');

// Sertifikat Umum
// sertifikat Toefl iBT
Route::get('/toefl-scores-umum', [CertificateController::class, 'indextoeflibt'])->name('data.toeflumum');
Route::get('/toefl-scores-umum/{id}', [CertificateController::class, 'showtoeflibt'])->name('certificate.showibtumum');
Route::get('/certificate-umum/{id}/pdf', [CertificateController::class, 'downloadPdftoeflibt'])->name('certificate.pdfumum');
// sertifikat Toefl Junior
Route::get('/toefljunior-scores-umum', [CertificateToeflJuniorController::class, 'indextoefljunior'])->name('data.toefljuniorumum');
Route::get('/toefljunior-scores-umum/{id}', [CertificateToeflJuniorController::class, 'showtoefljunior'])->name('certificate.showtoefljuniorumum');
Route::get('/certificatetoefljunior-umum/{id}/pdf', [CertificateToeflJuniorController::class, 'downloadPdftoefljunior'])->name('certificatetoefljunior.pdfumum');
// sertifikat IELTS Test Prediction C
Route::get('/ieltstestc-scores-umum', [CertificateIeltsTestCController::class, 'indexieltstestc'])->name('data.ieltstestcumum');
Route::get('/ieltstestc-scores-umum/{id}', [CertificateIeltsTestCController::class, 'showieltstestc'])->name('certificate.showieltstestcumum');
Route::get('/certificate-ieltstestc-umum/{id}/pdf', [CertificateIeltsTestCController::class, 'downloadPdfieltstestc'])->name('certificateieltstestc.pdfumum');
// sertifikat TOEIC
Route::get('/toeic-scores-umum', [CertificateToeicController::class, 'indextoeic'])->name('data.toeicumum');
Route::get('/toeic-scores-umum/{id}', [CertificateToeicController::class, 'showtoeic'])->name('certificate.showtoeicumum');
Route::get('/certificate-toeic-umum/{id}/pdf', [CertificateToeicController::class, 'downloadPdftoeic'])->name('certificatetoeic.pdfumum');
// sertifikat TOEFL Primary Step 1
Route::get('/toeflprimarystep1-scores-umum', [CertificateToeflPrimaryStep1Controller::class, 'indextoeflprimarystep1'])->name('data.toeflprimarystep1umum');
Route::get('/toeflprimarystep1-scores-umum/{id}', [CertificateToeflPrimaryStep1Controller::class, 'showtoeflprimarystep1'])->name('certificate.showtoeflprimarystepumum');
Route::get('/certificate-toeflprimarystep1-umum/{id}/pdf', [CertificateToeflPrimaryStep1Controller::class, 'downloadPdftoeflprimarystep1'])->name('certificatetoeflprimarystep1.pdfumum');
// sertifikat TOEFL Primary Step 2
Route::get('/toeflprimarystep2-scores-umum', [CertificateToeflPrimaryStep2Controller::class, 'indextoeflprimarystep2'])->name('data.toeflprimarystep2umum');
Route::get('/toeflprimarystep2-scores-umum/{id}', [CertificateToeflPrimaryStep2Controller::class, 'showtoeflprimarystep2'])->name('certificate.showtoeflprimarystep2umum');
Route::get('/certificate-toeflprimarystep2-umum/{id}/pdf', [CertificateToeflPrimaryStep2Controller::class, 'downloadPdftoeflprimarystep2'])->name('certificatetoeflprimarystep2.pdfumum');




// unduh data semua
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
// Toefl Primary Step 1
Route::get('/export-ToeflPrimaryStep1', function () {
    return Excel::download(new ToeflPrimaryStep1Export, 'daftar_siswa_toeflprimarystep1.xlsx');
})->name('toeflprimarystep1.export');
// Toefl Primary Step 2
Route::get('/export-ToeflPrimaryStep2', function () {
    return Excel::download(new ToeflPrimaryStep2Export, 'daftar_siswa_toeflprimarystep1.xlsx');
})->name('toeflprimarystep2.export');

// umum
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
// Toefl Primary Step 1
Route::get('/export-ToeflPrimaryStep1', function () {
    return Excel::download(new ToeflPrimaryStep1Export, 'daftar_siswa_toeflprimarystep1.xlsx');
})->name('toeflprimarystep1.export');
// Toefl Primary Step 2
Route::get('/export-ToeflPrimaryStep2', function () {
    return Excel::download(new ToeflPrimaryStep2Export, 'daftar_siswa_toeflprimarystep1.xlsx');
})->name('toeflprimarystep2.export');





// Reset Conversion Rate
// iBT
Route::delete('/scoreconversions/reset', [ToeflController::class, 'resetscoreconversions'])->name('scoreconversions.reset');
// toefl junior
Route::delete('/scoreconversiontoefljunior/reset', [ToeflJuniorController::class, 'resetscoreconversiontoefljunior'])->name('scoreconversiontoefljunior.reset');
// ielts
Route::delete('/scoreconversionielts/reset', [IeltsTestCController::class, 'resetscoreconversionieltstestc'])->name('scoreconversionieltstestc.reset');
// toeic
Route::delete('/scoreconversiontoeic/reset', [ToeicController::class, 'resetscoreconversiontoeic'])->name('scoreconversiontoeic.reset');
// toefl primary step 1
Route::delete('/scoreconversiontoeflprimarystep1/reset', [ToeflPrimaryStep1Controller::class, 'resetscoreconversiontoeflprimarystep1'])->name('scoreconversiontoeflprimarystep1.reset');
// toefl primary step 2
Route::delete('/scoreconversiontoeflprimarystep2/reset', [ToeflPrimaryStep2Controller::class, 'resetscoreconversiontoeflprimarystep2'])->name('scoreconversiontoeflprimarystep2.reset');






// hapus (destroy) data 
// Route::delete('/toeflibt/delete-all', [ToeflIbtController::class, 'destroyAll'])->name('toeflibt.destroyAll');






// edit data
// Route::get('/toefl/{student}/edit', [StudentController::class, 'edit'])
//      ->name('toefl.edit');

// // Proses update
// Route::put('/toefl/{student}', [StudentController::class, 'update'])
//      ->name('toefl.update');




require __DIR__.'/auth.php';
