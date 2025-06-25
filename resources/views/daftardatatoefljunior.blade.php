<x-app-layout>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOEFL Junior</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background: #f8f9fa;
      }
      .table-container {
        max-width: 1200px;
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
      /* Left-align the 'Nama Siswa' column */
      .table-container table th:nth-child(2),
      .table-container table td:nth-child(2) {
        text-align: left;
      }
      .action-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px; /* Jarak antar tombol */
      flex-wrap: nowrap;
      white-space: nowrap;
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
        <h1 class="text-center">Data Siswa - TOEFL Junior</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Search form di kiri --}}
        {{-- Input Search Real-time --}}
          <div>
            <input type="text" id="searchInput"
                  class="form-control border border-dark"
                  placeholder="Cari nama siswa..."
                  style="width: 300px;">
          </div>


        {{-- Tombol Download dan Hapus di kanan --}}
        <div>
          <a href="{{ route('toefljunior.export') }}" class="btn btn-success me-2">
            <i class="bi bi-file-earmark-spreadsheet"></i> Download Semua Data
          </a>

          <form id="form-delete-all"
                action="{{ route('toefljunior.destroyall') }}"
                method="POST"
                class="d-inline">
            @csrf
            @method('DELETE')
            <button type="button"
                    class="btn btn-danger btn-delete"
                    data-message="Yakin ingin menghapus SEMUA data siswa?"
                    data-form="#form-delete-all"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmModal">
              <i class="bi bi-trash"></i> Hapus Semua Data
            </button>
          </form>
        </div>
      </div>

        @if(session('success'))
          <div class="alert alert-success" role="alert">
            {{ session('success') }}
          </div>
        @endif
        <table id="toeflTable" class="table table-bordered table-striped">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama Siswa</th>
              <th>Tanggal Ujian</th>
              <th>Listening Skor</th>
              <th>Reading Skor</th>
              <th>Language Form Skor</th>
              <th>Total Skor</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->exam_date }}</td>
                <td>{{ $student->listening_score }}</td>
                <td>{{ $student->reading_score }}</td>
                <td>{{ $student->language_form_score }}</td>
                <td>{{ $student->total_score }}</td>
                <td>
                   <!-- Simpan URL preview dan download dalam atribut data -->
               <div class="action-buttons">
                  <button class="btn btn-primary btn-sm"
                      data-preview="{{ route('certificate.showtoefljunior', $student->id) }}"
                      data-download="{{ route('certificatetoefljunior.pdf', $student->id) }}"
                      onclick="showCertificate(this.getAttribute('data-preview'), this.getAttribute('data-download'))">
                      Lihat Sertifikat
                  </button>
                  {{-- Edit (trigger modal) --}}
                  <button class="btn btn-warning btn-sm ms-1"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal"
                          data-id="{{ $student->id }}"
                          data-name="{{ $student->name }}"
                          data-class="{{ $student->class }}"
                          data-email="{{ $student->email }}"
                          data-gender="{{ $student->gender }}"
                          data-country_region_nationality="{{ $student->country_region_nationality }}"
                          data-country_region_origin="{{ $student->country_region_origin }}"
                          data-native_language="{{ $student->native_language }}"
                          data-date_of_birth="{{ $student->date_of_birth }}"
                          data-school_name="{{ $student->school_name }}"
                          data-exam_date="{{ $student->exam_date }}"
                          data-listening_score="{{ $student->listening_score }}"
                          data-reading_score="{{ $student->reading_score }}"
                          data-language_form_score="{{ $student->language_form_score }}"
                          data-no_sertif="{{ $student->no_sertif }}"
                          data-valid_date="{{ $student->valid_date }}">
                    Edit
                  </button>
                  <!-- hapus -->
                    <form id="form-delete-{{ $student->id }}"
                        action="{{ route('toefljunior.destroy', $student->id) }}"
                        method="POST"
                        class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="btn btn-danger btn-sm ms-1 btn-delete"
                            data-message="Hapus data siswa {{ $student->name }}?"
                            data-form="#form-delete-{{ $student->id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmModal">
                      Hapus
                    </button>
                    </form>
                </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal for PDF Preview -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pdfModalLabel">Pratinjau Sertifikat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="pdf-container">
              <iframe id="pdfViewer"></iframe>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button id="downloadBtn" class="btn btn-success">Unduh PDF</button>
          </div>
        </div>
      </div>
    </div>

     <!-- Modal Edit Data Siswa -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data Siswa Toefl Junior</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body p-4">  
          <div class="row gx-4 gy-3"> 
              <input type="hidden" name="id" id="edit-id">
              <div class="col-md-6">
                <label class="form-label"><b>Nama Siswa</b></label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Class</b></label>
                <input type="text" name="class" id="edit-class" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Email</b></label>
                <input type="email" name="email" id="edit-email" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Gender</b></label>
                <select name="gender" id="edit-gender" class="form-select">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Country of Region of Nationality</b></label>
                <input type="text" name="country_region_nationality" id="edit-country_region_nationality" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Country of Region of Origin</b></label>
                <input type="text" name="country_region_origin" id="edit-country_region_origin" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Native Language</b></label>
                <input type="text" name="native_language" id="edit-native_language" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Date of Birth</b></label>
                <input type="date" name="date_of_birth" id="edit-date_of_birth" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>School Name</b></label>
                <input type="text" name="school_name" id="edit-school_name" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Exam Date</b></label>
                <input type="date" name="exam_date" id="edit-exam_date" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label"><b>Reading Score</b></label>
                <input type="number" name="reading_score" id="edit-reading_score" class="form-control" step="0.01" required>
              </div>
              <div class="col-md-3">
                <label class="form-label"><b>Listening Score</b></label>
                <input type="number" name="listening_score" id="edit-listening_score" class="form-control" step="0.01" required>
              </div>
              <div class="col-md-3">
                <label class="form-label"><b>Language Form Score</b></label>
                <input type="number" name="language_form_score" id="edit-language_form_score" class="form-control" step="0.01" required>
              </div>
              <div class="col-md-9">
                <label class="form-label"><b>*jumlah soal benar / skor sebelum di konversi</b></label>
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Certificate Number</b></label>
                <input type="text" name="no_sertif" id="edit-no_sertif" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label"><b>Valid Date</b></label>
                <input type="date" name="valid_date" id="edit-valid_date" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- model hapus data -->
  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4" id="confirmModalBody">
          <div class="row gx-4 gy-3">
          <!-- Pesan akan diisi via JS -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-danger" id="confirmYes">Ya</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Bootstrap 5 JS Bundle CDN (including Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function showCertificate(previewUrl, downloadUrl) {
        // Set the PDF URL in iframe for preview
        document.getElementById('pdfViewer').src = previewUrl;
        
        // Set up the download button functionality
        document.getElementById('downloadBtn').onclick = function () {
          const link = document.createElement("a");
          link.href = downloadUrl;
          link.download = "Sertifikat_TOEFLJunior.pdf";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        };

        // Show the Bootstrap modal
        var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        pdfModal.show();
      }
    </script>

     <!-- edit -->
  <script>
// Populate form ketika modal dibuka
var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
  var btn = event.relatedTarget;
  var id = btn.getAttribute('data-id');

  // Atur action URL
  var form = document.getElementById('editForm');
  form.action = '/toefljunior/' + id;

  // Map setiap field
  ['name','class','email','gender',
   'country_region_nationality','country_region_origin',
   'native_language','date_of_birth','school_name',
   'exam_date','reading_score','listening_score',
   'language_form_score','no_sertif','valid_date'
  ].forEach(function(field) {
    var el = document.getElementById('edit-' + field);
    el.value = btn.getAttribute('data-' + field);
  });
});
</script>

<!-- hapus -->
  <script>
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', event => {
      // Baca pesan dan target form
      const message = btn.getAttribute('data-message');
      const formSelector = btn.getAttribute('data-form');
      // Isi teks di modal
      document.getElementById('confirmModalBody').innerText = message;
      // Saat tekan 'Ya', submit form yang tepat
      const yesBtn = document.getElementById('confirmYes');
      yesBtn.onclick = () => {
        document.querySelector(formSelector).submit();
      };
    });
  });
</script>

<!-- hapus -->
<script>
  document.getElementById("searchInput").addEventListener("keyup", function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#toeflTable tbody tr");

    rows.forEach(function (row) {
      const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase(); // Nama Siswa
      row.style.display = name.includes(filter) ? "" : "none";
    });
  });
</script>
  </body>
  </html>
</x-app-layout>
