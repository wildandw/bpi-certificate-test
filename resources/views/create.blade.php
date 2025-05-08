<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Input Manual Skor TOEFL</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .form-container h1 {
      margin-bottom: 20px;
      font-size: 1.75rem;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h1>Input Manual Skor TOEFL</h1>
      @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif
      <form action="{{ route('scores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="student_name" class="form-label">Nama Siswa:</label>
          <input type="text" name="student_name" id="student_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="exam_date" class="form-label">Tanggal Ujian:</label>
          <input type="date" name="exam_date" id="exam_date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="reading_score" class="form-label">Reading (0-30):</label>
          <input type="number" name="reading_score" id="reading_score" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="listening_score" class="form-label">Listening (0-30):</label>
          <input type="number" name="listening_score" id="listening_score" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="speaking_score" class="form-label">Speaking (0-30):</label>
          <input type="number" name="speaking_score" id="speaking_score" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="writing_score" class="form-label">Writing (0-30):</label>
          <input type="number" name="writing_score" id="writing_score" class="form-control" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Simpan Skor</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Bootstrap 5 JS Bundle CDN (termasuk Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
