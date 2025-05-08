<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ToeflScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        $students = ToeflScores::all();
        return view('daftardata', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificate = ToeflScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.show', $id));

        return view('certificate.show', compact('certificate', 'qrCode'));
    }

    // Download PDF versi Browsershot


    public function downloadPdf($id)
    {
        $certificate = ToeflScores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.show', $id));

        // Render HTML dari Blade
        $html = view('certificate.show', compact('certificate', 'qrCode'))->render();

        $filename = 'Sertifikat_TOEFLiBT_' . Str::slug($certificate->name) . '.pdf';
        $pdfPath  = storage_path('app/public/' . $filename);

        Browsershot::html($html)
            ->waitUntilNetworkIdle()
            ->delay(2000)
            ->format('A4')
            ->landscape()
            ->noSandbox()
            // **Tambahkan dua baris ini:**
            ->enableRemoteAssets()  // ijinkan fetch gambar/logo dari internet
            ->showBackground()      // sertakan semua background (CSS background-image)
            ->margins(0, 0, 0, 0)
            ->save($pdfPath);

        return response()->download($pdfPath)
                        ->deleteFileAfterSend(true);
    }

    

    
}
