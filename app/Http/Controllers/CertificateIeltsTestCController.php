<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\IeltsTestCScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class CertificateIeltsTestCController extends Controller
{
    /**
     * Menampilkan sertifikat berdasarkan id dan menyisipkan QR Code.
     */

    // Menampilkan daftar siswa
    public function index()
    {
        $students = IeltsTestCScores::all();
        return view('daftardataieltstestc', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificateieltstestc = IeltsTestCScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showieltstestc', $id));

        return view('certificate.showieltstestc', compact('certificateieltstestc', 'qrCode'));
    }


    public function downloadPdf($id)
    {
        $certificateieltstestc = IeltsTestCScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showieltstestc', $id));

        // Render HTML dari Blade
        $html = view('certificate.showieltstestc', compact('certificateieltstestc', 'qrCode'))->render();

        // Lokasi penyimpanan PDF sementara
        $filename = 'Sertifikat_IELTS_' . Str::slug($certificateieltstestc->name) . '.pdf';
        $pdfPath = storage_path('app/public/' . $filename);

        // Generate PDF pakai Browsershot dengan menunggu sampai jaringan idle
        Browsershot::html($html)
            ->waitUntilNetworkIdle() // Menunggu hingga semua sumber daya dimuat
            ->format('A4') // Format A4
            ->landscape() // Menentukan orientasi halaman
            ->noSandbox()
            ->enableRemoteAssets()  // ijinkan fetch gambar/logo dari internet
            ->showBackground()  // Mengatasi masalah di Linux jika perlu
            ->margins(0, 0, 0, 0) // Mengatur margin
            ->save($pdfPath); // Menyimpan PDF ke lokasi

        // Kirim file ke user
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    





}
