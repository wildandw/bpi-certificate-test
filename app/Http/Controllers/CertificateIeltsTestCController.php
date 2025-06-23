<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\IeltsTestCScores;
use App\Models\IeltsTestCScores_Umum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function indexieltstestc()
    {
        $students = IeltsTestCScores_Umum::all();
        return view('umum/daftardataieltstestc_umum', compact('students'));
    }

    // Menampilkan sertifikat detail
    public function show($id)
    {
        $certificateieltstestc = IeltsTestCScores::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showieltstestc', $id));

        return view('certificate.showieltstestc', compact('certificateieltstestc', 'qrCode'));
    }
    public function showieltstestc($id)
    {
        $certificateieltstestc = IeltsTestCScores_Umum::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(route('certificate.showieltstestcumum', $id));

        return view('certificate.umum.showieltstestc_umum', compact('certificateieltstestc', 'qrCode'));
    }


    public function downloadPdf($id) 
    {
        $certificateieltstestc = IeltsTestCScores::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showieltstestc', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showieltstestc', compact('certificateieltstestc', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_ielts'),
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
        $filename = 'Sertifikat_IELTS_' . Str::slug($certificateieltstestc->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadPdfieltstestc($id) 
    {
        $certificateieltstestc = IeltsTestCScores_Umum::findOrFail($id);
        $qrCode      = QrCode::size(100)->generate(route('certificate.showieltstestcumum', $id));

        // 1. Render HTML via Blade
        $html = view('certificate.showieltstestcumum', compact('certificateieltstestc', 'qrCode'))->render();

        // 2. Panggil aPDF.io Create API
        $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APDF_API_KEY_ieltsumum'),
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
        $filename = 'Sertifikat_IELTS_' . Str::slug($certificateieltstestc->name) . '.pdf';
        return new StreamedResponse(function () use ($pdfResp) {
            echo $pdfResp->body();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    





}
