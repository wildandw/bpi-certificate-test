<?php

namespace App\Http\Controllers;


use App\Models\ToeicScores;
use App\Models\ToeicScores_Umum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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
    public function indextoeic()
    {
        $students = ToeicScores_umum::all();
        return view('umum/daftardatatoeic_umum', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoeic = ToeicScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeic', $id));

        return view('certificate.showtoeic', compact('certificatetoeic', 'qrCode'));
    }
    public function showtoeic($id)
    {
        $certificatetoeic = ToeicScores_Umum::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoeicumum', $id));

        return view('certificate.umum.showtoeic_umum', compact('certificatetoeic', 'qrCode'));
    }

    
    public function downloadPdf($id) 
    {
        $certificatetoeic = ToeicScores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeic', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeic', compact('certificatetoeic', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeic'),
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
        $filename = 'Sertifikat_Toeic_' . Str::slug($certificatetoeic->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    public function downloadPdftoeic($id) 
    {
        $certificatetoeic = ToeicScores_Umum::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoeicumum', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoeicumum', compact('certificatetoeic', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toeicumum'),
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
        $filename = 'Sertifikat_Toeic_' . Str::slug($certificatetoeic->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }





}
