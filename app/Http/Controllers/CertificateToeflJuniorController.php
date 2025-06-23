<?php

namespace App\Http\Controllers;

use App\Models\ToeflJuniorScores;
use App\Models\ToeflJuniorScores_Umum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function indextoefljunior()
    {
        $students = ToeflJuniorScores_Umum::all();
        return view('umum/daftardatatoefljunior_umum', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificatetoefljunior = ToeflJuniorScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoefljunior', $id));

        return view('certificate.showtoefljunior', compact('certificatetoefljunior', 'qrCode'));
    }
    public function showtoefljunior($id)
    {
        $certificatetoefljunior = ToeflJuniorScores_Umum::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showtoefljuniorumum', $id));

        return view('certificate.umum.showtoefljunior_umum', compact('certificatetoefljunior', 'qrCode'));
    }

    
public function downloadPdf($id) 
    {
        $certificatetoefljunior = ToeflJuniorScores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoefljunior', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoefljunior', compact('certificatetoefljunior', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toefljunior'),
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
        $filename = 'Sertifikat_IELTS_' . Str::slug($certificatetoefljunior->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadPdftoefljunior($id) 
    {
        $certificatetoefljunior = ToeflJuniorScores_Umum::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showtoefljuniorumum', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showtoefljuniorumum', compact('certificatetoefljunior', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_toefljuniorumum'),
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
        $filename = 'Sertifikat_IELTS_' . Str::slug($certificatetoefljunior->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    



}
