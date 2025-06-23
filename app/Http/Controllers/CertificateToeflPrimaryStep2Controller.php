<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ToeflPrimaryStep2Scores;
use App\Models\ToeflPrimaryStep2Scores_Umum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function indextoeflprimarystep2()
    {
        $students = ToeflPrimaryStep2Scores_Umum::all();
        return view('umum/daftardatatoeflprimarystep2_umum', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2', $id));

        return view('certificate.showtoeflprimarystep2', compact('certificatetoeflprimarystep2', 'qrCode'));
    }
    public function showtoeflprimarystep2($id)
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores_Umum::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2umum', $id));

        return view('certificate.umum.showtoeflprimarystep2_umum', compact('certificatetoeflprimarystep2', 'qrCode'));
    }


    public function downloadPdf($id) 
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeflprimarystep2', compact('certificatetoeflprimarystep2', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeflprimarystep2'),
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
        $filename = 'Sertifikat_ToeflPrimaryStep2_' . Str::slug($certificatetoeflprimarystep2->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadPdftoeflprimarystep2($id) 
    {
        $certificatetoeflprimarystep2 = ToeflPrimaryStep2Scores_Umum::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeflprimarystep2umum', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeflprimarystep2umum', compact('certificatetoeflprimarystep2', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeflprimarystep2umum'),
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
        $filename = 'Sertifikat_ToeflPrimaryStep2_' . Str::slug($certificatetoeflprimarystep2->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    





}
