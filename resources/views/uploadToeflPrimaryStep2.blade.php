<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Data - TOEFL Primary Step 2</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .upload-container {
      max-width: 600px;
      margin: 50px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .upload-container h1 {
      margin-bottom: 20px;
      font-size: 1.75rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="upload-container">
      <h1 class="text-center">TOEFL Primary Step 2 Raw Score Conversion</h1>

      @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi error:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form action="{{ route('scores.importToeflPrimaryStep2') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- tampilkan jika belum ada conversion rate --}}
        @unless ($hasConversion)
          <div class="mb-3">
            <label for="conversion_file" class="form-label">Score Conversion Table</label>
            <input type="file" name="conversion_file" id="conversion_file" class="form-control" required>
          </div>
        @else
          <div class="alert alert-info">
            Conversion rate sudah di‐upload. Cukup upload file skor saja.
          </div>
        @endunless

        <div class="mb-3">
            <label for="score_file" class="form-label">TOEFL Primary Step 2 Scores</label>
            <input type="file" name="score_file" id="score_file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
          {{ $hasConversion ? 'Upload Skor Saja' : 'Upload Semua' }}
        </button>
      </form>

      {{-- Form Reset DITARUH DI LUAR, tapi hanya muncul kalau sudah ada conversion --}}
      @if($hasConversion)
        <form action="{{ route('scoreconversiontoeflprimarystep2.reset') }}" method="POST" class="mt-3" onsubmit="return confirm('Yakin ingin me-reset score conversion toefl primary step2 ? Data akan dihapus seluruhnya.')">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Reset Conversion Rate</button>
        </form>
      @endif

      <!-- <hr class="my-4"> -->

      <!-- <div class="text-center">
        <a href="{{ route('create') }}" class="btn btn-outline-secondary">Input Manual Data Skor</a>
      </div> -->
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</x-app-layout>
