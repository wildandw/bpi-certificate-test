<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=1000">
  <link rel="icon" href="{{ asset('img/test.png') }}" type="image/png">
  <title>TOEFL iBT Prediction Test Certificate</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Lato', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      background-color: #f0f0f0;
    }
    .certificate {
      margin-top: 50px;
      width: 1000px;
      height: 700px;
      position: relative;
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .watermark {
      content: "";
      background: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/logo_bpi.png') center center no-repeat;
      background-size: 400px;
      opacity: 0.7;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 100%;
      z-index: 0;
      pointer-events: none; 
    }

    /* HEADER */
    .header {
      position: relative;
      z-index: 1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #189ab4;
      padding: 20px;
      color: #fff;
      margin: -30px -30px 20px -30px;
    }
    .header .judul {
      font-size: 24px;
      font-weight: 700;
      margin-left: 20px;
    }
    .header .subtitle {
      font-size: 16px;
    }

    /* BODY INFO */
    .info {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      gap: 20px;
      margin-bottom: 30px;
      margin-left: 10px;
      position: relative;
      z-index: 1;
    }


    .info .fields,
    .info .right-column {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .info .right-column {
      flex: 0 0 160px; 
      display: flex;
      flex-direction: column;
      align-items: center; 
      padding-right: 10px;
      gap: 10px;
    }

    /* .info .photo {
      width: 120px;
      height: 120px;
      background: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/image_placeholder.png');
      background-size: cover;
      background-position: center;
      border-radius: 4px;
    } */

    .qrcode-section {
      text-align: center;
      font-size: 10px;
      margin-top: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .qrcode {
      width: 100px;
      height: 100px;
      background: url('https://bpi-certificate.cloud/') no-repeat center center;
      background-size: contain;
      margin: 10px 0;
    }

    .info .fields span.label {
      font-weight: 600;
      display: inline-block;
      width: 140px;
    }

    .info .photo {
      width: 100px;
      height: 100px;
      background: url('https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
    }


    /* SCORES */
    .scores-container {
      position: relative;
      margin: 10px 0;
      border: 2px dashed #003366;
      border-radius: 10px;
      z-index: 1;
    }
    .test-date {
      position: absolute;
      top: -12px;
      left: 20px;
      background: #fff;
      padding: 0 10px;
      font-weight: 600;
      color: #003366;
    }
    .total-score {
      position: absolute;
      left: 30px;
      top: 50%;
      transform: translateY(-50%);
      text-align: center;
    }
    .total-score .label {
      font-size: 13px;
      font-weight: 600;
    }
    .total-score .value {
      font-size: 32px;
      font-weight: 700;
      color: #003366;
    }
    .scores {
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-left: 160px;
    }
    .score-item {
      text-align: center;
      padding: 10px;
      width: 120px;
    }
    .score-item img {
      width: 40px;
      height: 40px;
      margin-bottom: 5px;
      filter: grayscale(1) brightness(0);
    }
    .score-box {
      background-color: #d4f1f4;
      border-radius: 8px;
      padding: 8px;
      display: inline-block;
      margin-top: 5px;
    }

    .score-value {
      font-size: 20px;
      font-weight: 700;
      color: #000;
    }
    .score-label {
      font-size: 12px;
      color: #333;
      border-radius: 4px;
      padding: 2px 6px;
      display: inline-block;
      margin-top: 5px;
    }
    .score-name {
      font-weight: 600;
      margin-bottom: 5px;
      color: #000;
    }
    .score-icon-label {
      display: flex;
      align-items: center;
      gap: 6px; /* jarak antar gambar dan label */
    }

    .score-icon-label img {
      width: 24px;
      height: 24px;
    }
    .qrcode-section {
      text-align: center;
      font-size: 13px;
      margin-top: 10px;
    }

    .qrcode {
      width: 100px;
      height: 100px;
      margin: 7px auto;
    }

    .signatures {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      width: 100%;
      margin-top: 20px;
    }

    .signature {
      text-align: center;
      font-size: 12px;
      position: relative;
      flex: 1;
      z-index: 99;
    }

    .signature-line {
      position: relative;
      width: 80%;
      margin: 0 auto;
      border-top: 1px solid #000;
    }

    .cap {
      display: block;
      margin: 0 auto;
      width: 120px;
      height: auto;
      object-fit: contain;
      margin-top: -25px;
      margin-bottom: 140px;
      margin-left: 30px;
      z-index: -5;
      position: absolute;
    }

    .signature-sign {
      display: block;
      margin: 0 auto;
      width: 150px;
      height: 80px;
      object-fit: contain;
      margin-top: 10px;
      margin-bottom: 10px;
      z-index: 9;
    }
    .signature-line {
      top: -10px;      
      width: 80%;
      margin: 20px auto 0 auto;
      border-top: 1px solid #000;
    }

    .signature-title {
      font-weight: bold;
      margin-bottom: 5px;
  
    }

    .signature-name {
      margin-top: 0;
    }
    .LR {
      content: "";
      background: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/LR.png') center center no-repeat;
      position: absolute;
      transform: translate(-50%, -50%);
      width: 50%;
      height: 50%;
      z-index: 0;
      pointer-events: none; 
      background-color: #003366;
    }

  </style>
</head>
<body>
  @php
       use Carbon\Carbon;
       $formattedExamDate = Carbon::parse($certificate->exam_date)->format('d-m-Y');
       $formattedDateofBirth = Carbon::parse($certificate->date_of_birth)->format('d-m-Y');
  @endphp

  <div class="certificate">
    <!-- BPI Logo Watermark -->
    <div class="watermark" style="background-image: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/logo_bpi.png');"></div>
    
    <!-- HEADER -->
    <div class="header">
      <div class="judul">TOEFL iBT Prediction Test</div>
      <div class="subtitle">Test Taker Score Report</div>
    </div>

    <!-- PARTICIPANT INFO -->
    <div class="info">
      <div class="fields">
        <div><span class="label">Name:</span> {{ $certificate->name }}</div>
        <div><span class="label">Email:</span> {{ $certificate->email }}</div>
        <div><span class="label">Test Date:</span> {{ $formattedExamDate}}</div>
        <div><span class="label">Native Language:</span> {{ $certificate->native_language }}</div>
        <div><span class="label">Country/Region:</span> {{ $certificate->country_region_nationality }}</div>
        <div><span class="label">Gender:</span> {{ $certificate->gender }}</div>
        <div><span class="label">Date of Birth:</span> {{ $formattedDateofBirth }}</div>
        <div><span class="label">Country of Birth:</span> {{ $certificate->country_region_origin }}</div>
        <div><span class="label">No:</span>  012/UPK_Prodiksus/V/2025</div>
      </div>
      <div class="right-column">
        <div class="photo"></div>
        <div class="qrcode-section">
          <div>Scan here for validation</div>
            <div class="qrcode">
              {!! $qrCode !!}
            </div>
          <div>Valid until: May 2027</div>
        </div>
      </div>
    </div>


   <!-- SCORES -->
    <div class="scores-container">
      <div class="test-date">Test Date:{{ $certificate->exam_date }}</div>
      <div class="total-score">
        <div class="label">Total Score</div>
        <div class="value">{{ $certificate->total_score}}</div>
      </div>
      <div class="scores">
        <div class="score-item">
          <div class="score-icon-label">
            <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/reading.png" alt="Reading">
            <div class="score-name">Reading</div>
          </div>
            <div class="score-box">
              <div class="score-value">{{ $certificate->reading_score}}</div>
              <div class="score-label">Out of 30</div>
            </div>
        </div>
        <div class="score-item">
          <div class="score-icon-label">
            <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/listen.png" alt="Listening">
            <div class="score-name">Listening</div>
          </div>
          <div class="score-box">
            <div class="score-value">{{ $certificate->listening_score}}</div>
            <div class="score-label">Out of 30</div>
          </div>
        </div>
        <div class="score-item">
          <div class="score-icon-label">
            <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/speak.png" alt="Speaking">
            <div class="score-name">Speaking</div>
          </div>
          <div class="score-box">
            <div class="score-value">{{ $certificate->speaking_score}}</div>
            <div class="score-label">Out of 30</div>
          </div>
        </div>
        <div class="score-item">
          <div class="score-icon-label">
            <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/write.png" alt="Writing">
            <div class="score-name">Writing</div>
          </div>
          <div class="score-box">
            <div class="score-value">{{ $certificate->writing_score}}</div>
            <div class="score-label">Out of 30</div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- footer -->
    <div class="footer">
      <div class="signatures">
        <div class="signature">
          <div class="signature-title">Development Director<br>of BPI Foundation</div>
          <!-- <img src="{{ asset('img/LR.png') }}" alt="Tanda Tangan" class="signature-sign"> -->
          <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/LAR-2.png" alt="Tanda Tangan" class="signature-sign">
          <div class="signature-line"></div>
          <div class="signature-name">Lukman Arif Rachman, M.Pd.</div>
        </div>
        <div class="signature">
          <div class="signature-title">Principal of BPI 1<br>Senior High School</div>
          <!-- <img src="{{ asset('img/LR.png') }}" alt="Tanda Tangan" class="signature-sign"> -->
           <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/cap-sma-e1747674943239.png" alt="cap" class="cap">
          <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/T-2.png" alt="Tanda Tangan" class="signature-sign">
          <div class="signature-line"></div>
          <div class="signature-name">Tatang, M.Pd.</div>
        </div>
            <div class="signature">
                <div class="signature-title">
                    Bandung, May 30, 2025<br>
                    Head of UPK Prodiksus
                </div>
                <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/upk-e1747674338525.png" alt="cap" class="cap">
                <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/LR-2.png" alt="Tanda Tangan" class="signature-sign">
                <div class="signature-line"></div>
                <div class="signature-name">Lina Roufah, S.Pd.</div>
            </div>
      </div>
    </div>
  </div>
</body>
</html>