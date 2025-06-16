<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ToeflPrimaryStep1Scores;
use App\Models\ToeflPrimaryStep1Scores_Umum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CertificateToeflPrimaryStep1Controller extends Controller
{
    /**
     * Menampilkan sertifikat berdasarkan id dan menyisipkan QR Code.
     */

    // Menampilkan daftar siswa
    public function index()
    {
        $students = ToeflPrimaryStep1Scores::all();
        return view('daftardatatoeflprimarystep1', compact('students'));
    }
    public function indextoeflprimarystep1()
    {
        $students = ToeflPrimaryStep1Scores_Umum::all();
        return view('umum/daftardatatoeflprimarystep1_umum', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoeflprimarystep1 = ToeflPrimaryStep1Scores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep1', $id));

        return view('certificate.showtoeflprimarystep1', compact('certificatetoeflprimarystep1', 'qrCode'));
    }
    public function showtoeflprimarystep1($id)
    {
        $certificatetoeflprimarystep1 = ToeflPrimaryStep1Scores_Umum::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep1umum', $id));

        return view('certificate.showtoeflprimarystep1umum', compact('certificatetoeflprimarystep1', 'qrCode'));
    }


    public function downloadPdf($id) 
    {
        $certificatetoeflprimarystep1 = ToeflPrimaryStep1Scores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep1', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeflprimarystep1', compact('certificatetoeflprimarystep1', 'qrCode'))->render();
        

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeflprimarystep1'),
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
        $filename = 'Sertifikat_ToeflPrimaryStep1_' . Str::slug($certificatetoeflprimarystep1->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadPdftoeflprimarystep1($id) 
    {
        $certificatetoeflprimarystep1 = ToeflPrimaryStep1Scores_Umum::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep1umum', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeflprimarystep1umum', compact('certificatetoeflprimarystep1', 'qrCode'))->render();
        

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeflprimarystep1'),
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
        $filename = 'Sertifikat_ToeflPrimaryStep1_' . Str::slug($certificatetoeflprimarystep1->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    





}
