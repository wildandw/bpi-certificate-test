<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToeicScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class certificateToeicController extends Controller
{
    /**
     * Menampilkan sertifikat berdasarkan id dan menyisipkan QR Code.
     */

    // Menampilkan daftar siswa
    public function index()
    {
        $students = ToeicScores::all();
        return view('daftardatatoeic', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoeic = ToeicScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeic', $id));

        return view('certificate.showtoeic', compact('certificatetoeic', 'qrCode'));
    }

    
    public function downloadPdf($id)
    {
        $certificatetoeic = ToeicScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeic', $id));

        // Render HTML dari Blade
        $html = view('certificate.showtoeic', compact('certificatetoeic', 'qrCode'))->render();

        // Lokasi penyimpanan PDF sementara
        $filename = 'Sertifikat_TOEIC_' . Str::slug($certificatetoeic->name) . '.pdf';
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
