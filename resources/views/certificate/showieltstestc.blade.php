<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IELTS Prediction Test Report Form</title>
  <style>
    /* Reset sederhana */
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      padding: 20px;
    }

    /* Watermark teks grid di atas background utama */
    .watermark-grid {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image:
        repeating-linear-gradient(
          0deg,
          rgba(0,0,0,0.03) 0,
          rgba(0,0,0,0.03) 1px,
          transparent 1px,
          transparent 30px
        ),
        repeating-linear-gradient(
          90deg,
          rgba(0,0,0,0.03) 0,
          rgba(0,0,0,0.03) 1px,
          transparent 1px,
          transparent 30px
        );
      z-index: 1;
      pointer-events: none;
    }

    .form-container {
      position: relative;
      max-width: 900px;
      margin: 0 auto;
      padding: 30px;
      border: 2px solid #000;
      overflow: hidden;

      /* Background image utama */
      background-image: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/ielts.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* Konten di atas semua background */
    .content {
      position: relative;
      z-index: 2;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .header .logo-left {
      height: 50px;
    }
    .header .title {
      font-size: 1.6rem;
      font-weight: bold;
      text-transform: uppercase;
    }
    .header .logo-right {
      height: 60px;
    }

    /* Baris Test Date */
    .row-test-date {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .row-test-date label {
      font-weight: bold;
    }
    .row-test-date input {
      width: 120px;
      padding: 4px 8px;
      border: 1px solid #000;
    }
    .row-test-date .code {
      font-size: 0.9rem;
    }

    /* Candidate Details */
    .candidate-details {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .candidate-details th,
    .candidate-details td {
      border: 1px solid #000;
      padding: 6px 8px;
      font-size: 0.9rem;
    }
    .candidate-details th {
      background: #f0f0f0;
      text-align: left;
      width: 200px;
    }
    .candidate-details td input {
      width: 100%;
      border: none;
      padding: 4px;
      font-size: 0.9rem;
    }
    .candidate-details .small-input {
      width: 40px;
    }

    /* Scores */
    .scores {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .score-item {
      text-align: center;
    }
    .score-box {
      width: 70px;
      height: 50px;
      border: 1px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.1rem;
      margin: 0 auto;
    }
    .scores .label {
      text-transform: uppercase;
      font-size: 0.8rem;
      margin-top: 4px;
    }

    /* CEFR Box */
    .cefr {
      width: 80px;
      height: 80px;
      border: 2px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      font-weight: bold;
      position: absolute;
      top: 45%;
      right: 30px;
    }

    /* Footer: QR + signature + valid until */
    .footer {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
    }
    .footer .qr {
      text-align: center;
      font-size: 0.9rem;
    }
    .footer .qr img {
      margin-top: 6px;
      width: 80px;
      height: 80px;
    }
    .footer .valid {
      margin-top: 6px;
    }
    .footer .sign {
      text-align: center;
      font-size: 0.9rem;
    }
    .footer .sign .line {
      border-top: 1px solid #000;
      width: 200px;
      margin: 0 auto 4px;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <div class="watermark-grid"></div>

    <div class="content">

      <!-- HEADER -->
      <div class="header">
        <img src="https://1000logos.net/wp-content/uploads/2021/03/IELTS-logo.png" alt="IELTS Logo" class="logo-left">
        <div class="title">Prediction Test Report Form</div>
        <img src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png" alt="BPI Seal" class="logo-right">
      </div>

      <!-- TEST DATE ROW -->
      <div class="row-test-date">
        <div>
          <label for="test-date">Test Date</label>
          <input type="text" id="test-date" value="{{ $certificateieltstestc->exam_date }}" readonly>
        </div>
        <div class="code">
          LEAD000/
        </div>
      </div>

      <!-- CANDIDATE DETAILS -->
      <table class="candidate-details">
        <tr>
          <th>Name</th>
          <td colspan="3"><input type="text" value="{{ $certificateieltstestc->name }}" readonly></td>
        </tr>
        <tr>
          <th>Date of Birth</th>
          <td><input type="text" value="{{ $certificateieltstestc->date_of_birth }}" readonly></td>
          <th>Sex (M/F)</th>
          <td><input class="small-input" type="text" value="{{ $certificateieltstestc->gender }}" readonly></td>
        </tr>
        <tr>
          <th>Country or Region of Origin</th>
          <td colspan="3"><input type="text" value="INDONESIA" readonly></td>
        </tr>
        <tr>
          <th>Country or Region of Nationality</th>
          <td colspan="3"><input type="text" value="INDONESIA" readonly></td>
        </tr>
        <tr>
          <th>First Language</th>
          <td colspan="3"><input type="text" value="BAHASA INDONESIA" readonly></td>
        </tr>
      </table>

      <!-- SCORES -->
      <div class="scores">
        <div class="score-item">
          <div class="score-box">{{ $certificateieltstestc->listening_score }}</div>
          <div class="label">Listening</div>
        </div>
        <div class="score-item">
          <div class="score-box">{{ $certificateieltstestc->reading_score }}</div>
          <div class="label">Reading</div>
        </div>
        <div class="score-item">
          <div class="score-box">{{ $certificateieltstestc->writing_score }}</div>
          <div class="label">Writing</div>
        </div>
        <div class="score-item">
          <div class="score-box">{{ $certificateieltstestc->speaking_score }}</div>
          <div class="label">Speaking</div>
        </div>
        <div class="score-item">
          <div class="score-box">{{ $certificateieltstestc->total_score }}</div>
          <div class="label">Overall</div>
        </div>
      </div>

      <!-- CEFR BOX -->
      <div class="cefr">{{ $certificateieltstestc->cefr_level }}</div>

      <!-- FOOTER -->
      <div class="footer">
        <div class="qr">
          <div>Scan here for validation</div>
          {!! $qrCode !!}
          <div class="valid">Valid until: </div>
        </div>
        <div class="sign">
          <div class="line"></div>
          <div>Administrator’s Signature</div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>
