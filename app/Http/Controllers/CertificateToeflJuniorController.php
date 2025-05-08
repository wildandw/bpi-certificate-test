<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeflJuniorScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class CertificateToeflJuniorController extends Controller
{
    /**
     * Menampilkan sertifikat berdasarkan id dan menyisipkan QR Code.
     */

    // Menampilkan daftar siswa
    public function index()
    {
        $students = ToeflJuniorScores::all();
        return view('daftardatatoefljunior', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoefljunior = ToeflJuniorScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoefljunior', $id));

        return view('certificate.showtoefljunior', compact('certificatetoefljunior', 'qrCode'));
    }

    public function downloadPdf($id)
    {
        $certificatetoefljunior = ToeflJuniorScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoefljunior', $id));

        // Render HTML dari Blade
        $html = view('certificate.showtoefljunior', compact('certificatetoefljunior', 'qrCode'))->render();

        // Lokasi penyimpanan PDF sementara
        $filename = 'Sertifikat_TOEFLiBT_' . Str::slug($certificatetoefljunior->name) . '.pdf';
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
