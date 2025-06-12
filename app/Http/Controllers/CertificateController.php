<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ToeflScores;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $qrCode = QrCode::size(100)->generate(route('certificate.showibt', $id));

        return view('certificate.showibt', compact('certificate', 'qrCode'));
    }

    // Download PDF versi Browsershot


    public function downloadPdf($id) 
    {
        $certificate = ToeflScores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showibt', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showibt', compact('certificate', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeflibt'),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ])
            ->post('https://apdf.io/api/pdf/file/create', [
                'html'        => $html,
                'format'      => 'a4',           // optional :contentReference[oaicite:0]{index=0}
                'orientation' => 'landscape',    // optional :contentReference[oaicite:1]{index=1}
                // margin_top, margin_right, … sesuai kebutuhan
            ]);

        if (! $resp->ok()) {
            Log::error('aPDF.io create error: ' . $resp->status() . ' – ' . $resp->body());
            abort(500, 'Gagal generate PDF, cek log untuk detail.');
        }

        $data    = $resp->json();
        $fileUrl = $data['file'];          // URL PDF yang sudah jadi :contentReference[oaicite:2]{index=2}

        // 3. Ambil binary PDF dari URL
        $pdfResp = Http::get($fileUrl);
        if (! $pdfResp->ok()) {
            Log::error('aPDF.io download error: ' . $pdfResp->status());
            abort(500, 'Gagal mengambil file PDF.');
        }

        // 4. Stream PDF ke browser tanpa simpan di disk
        $filename = 'Sertifikat_TOEFLiBT_' . Str::slug($certificate->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    

    
}
