<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ToeflPrimaryStep2Scores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class CertificateToeflPrimaryStep2Controller extends Controller
{
    /**
     * Menampilkan sertifikat berdasarkan id dan menyisipkan QR Code.
     */

    // Menampilkan daftar siswa
    public function index()
    {
        $students = ToeflPrimaryStep2Scores::all();
        return view('daftardatatoeflprimarystep2', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2', $id));

        return view('certificate.showtoeflprimarystep2', compact('certificatetoeflprimarystep2', 'qrCode'));
    }


    public function downloadPdf($id)
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2', $id));

        // Render HTML dari Blade
        $html = view('certificate.showtoeflprimarystep2', compact('certificatetoeflprimarystep2', 'qrCode'))->render();

        // Lokasi penyimpanan PDF sementara
        $filename = 'Sertifikat_TOEFLPrimarystep2_' . Str::slug($certificatetoeflprimarystep2->name) . '.pdf';
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
