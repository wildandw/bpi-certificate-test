<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Siswa TOEFL Primary Step 1</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .table-container {
      max-width: 1200px;
      width: 100%;
      margin: 50px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .table-container h1 {
      margin-bottom: 20px;
      font-size: 1.75rem;
      font-weight: 600;
    }
    /* Center align all cells by default */
    .table-container table th,
    .table-container table td {
      text-align: center;
      vertical-align: middle;
    }
    /* Left-align the 'Nama Siswa' column (2nd column) */
    .table-container table th:nth-child(2),
    .table-container table td:nth-child(2) {
      text-align: left;
    }
    #pdfViewer {
        width: 100%;
        height: 700px;
        border: none;
      }
      /* Modal custom styling */
      .modal-dialog {
        max-width: 80%; /* Sesuaikan lebar modal */
        margin: 30px auto; /* Posisi modal di tengah */
      }
      .modal-body {
        padding: 0;
      }
  </style>
</head>
<body>
  <div class="container">
    <div class="table-container">
      <h1 class="text-center">Data Siswa TOEFL Primary Step 1</h1>

      {{-- tombol download --}}
      <div class="mb-3 text-end">
        <a href="{{ route('toeflprimarystep1.export') }}" class="btn btn-success">
          <i class="bi bi-file-earmark-spreadsheet"></i> Download Semua Data
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif
      <table class="table table-bordered table-striped">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal Ujian</th>
            <th>Reading Skor</th>
            <th>Listening Skor</th>
            <th>Speaking Skor</th>
            <th>Writing Skor</th>
            <th>Total Skor</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($students as $student)
            <tr>
              <!-- <td>{{ $student->id }}</td> -->
              <td>{{ $loop->iteration }}</td>
              <td>{{ $student->name }}</td>
              <td>{{ $student->exam_date }}</td>
              <td>{{ $student->reading_score }}</td>
              <td>{{ $student->listening_score }}</td>
              <td>{{ $student->speaking_score }}</td>
              <td>{{ $student->writing_score }}</td>
              <td>{{ $student->total_score }}</td>
              <td>
                <!-- Simpan URL preview dan download dalam atribut data -->
                <button class="btn btn-primary btn-sm"
                    data-preview="{{ route('certificate.showtoeflprimarystep1', $student->id) }}"
                    data-download="{{ route('certificatetoeflprimarystep1.pdf', $student->id) }}"
                    onclick="showCertificate(this.getAttribute('data-preview'), this.getAttribute('data-download'))">
                    Lihat Sertifikat
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal untuk Pratinjau PDF -->
  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pdfModalLabel">Pratinjau Sertifikat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe id="pdfViewer"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button id="downloadBtn" class="btn btn-success">Unduh PDF</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle CDN (termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function showCertificate(previewUrl, downloadUrl) {
      // Setel URL PDF ke dalam iframe untuk pratinjau
      document.getElementById('pdfViewer').src = previewUrl;
      
      // Setel tombol unduh untuk mengunduh PDF dengan URL yang tepat
      document.getElementById('downloadBtn').onclick = function () {
          const link = document.createElement("a");
          link.href = downloadUrl;
          link.download = "Sertifikat_toeflprimarystep1.pdf";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
      };

      // Tampilkan modal Bootstrap
      var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
      pdfModal.show();
    }
  </script>
</body>
</html>
</x-app-layout>
