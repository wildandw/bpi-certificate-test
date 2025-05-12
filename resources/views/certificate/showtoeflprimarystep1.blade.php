<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=1150">
  <title>Sertifikat TOEFL Primary Step 1</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:ital,wght@1,300&display=swap" rel="stylesheet"/>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Lato', sans-serif;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .certificate {
      width: 100%;
      max-width: 1100px;
      background-color: white;
      border: 25px solid #0d87c0;
      position: relative;
      padding: 40px;
      margin: 0 auto;
      color: #000;
    }

    .certificate-inner {
      position: relative;
      width: 100%;
      height: 100%;
      z-index: 10;
      text-align: center;
    }

    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 1;
      width: 100%;
      height: auto;
      z-index: 1;
    }

    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 80px;
    }

    .qr-code {
      position: absolute;
      top: 25px;
      right: 20px;
      width: 100px;
      height: 100px;
    }

    .qr-validation {
      position: absolute;
      top: 0px;
      right: 10px;
      font-size: 12px;
    }

    .toefl-header {
      margin-top: 30px;
      font-size: 26px;
      font-family: 'Montserrat', sans-serif;
      font-style: italic;
    }

    .step {
      font-size: 22px;
      margin-top: 10px;
      font-weight: bold;
    }

    .title {
      font-size: 32px;
      font-weight: bold;
      margin-top: 20px;
    }

    .subtitle {
      font-size: 18px;
      margin-top: 30px;
    }

    .participant {
      font-size: 36px;
      font-weight: bold;
      margin: 25px 0;
    }

    .test-description {
      font-size: 18px;
      font-style: italic;
      margin-bottom: 30px;
    }

    .scores-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px 20px;
        margin-left: 25%;
        width: 70%;
    }

    .score-column {
        width: 40%;
        text-align: left;
    }

    .score-label {
        font-size: 18px;
        font-weight: bold;
    }

    .score-value {
        margin-top: 5px;
    }

    .stars img {
        height: auto;
        width: 24px;
     }


    .score-item {
        display: flex;
        align-items: center;
        gap: 8px; /* jarak antara label dan bintang */
        white-space: nowrap;
    }

    .score-value {
        display: flex;
        align-items: center;
    }



    .footer {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .date {
      font-size: 14px;
      text-align: left;
      margin-top: 15px;
    }

    .valid-until {
      font-size: 14px;
      position: absolute;
      top: 135px;
      right: 10px;
    }

    .signatures {
      display: flex;
      justify-content: space-between;
      margin-top: 60px;
    }

    .signature {
      text-align: center;
      width: 30%;
    }

    .signatory-title {
      font-size: 12px;
      margin-bottom: 40px;
      line-height: 1.3;
    }

    .signature-space {
      height: 60px;
    }

    .signature-line {
      width: 80%;
      margin: 0 auto;
      border-top: 1px solid #000;
      margin-bottom: 5px;
    }

    .signatory-name {
      font-size: 14px;
      font-weight: bold;
    }
  </style>
</head>
<body>

     <!-- bintang untuk listening dan reading -->
    @php
    function toeflPrimaryStars($score) {
        if ($score >= 107 && $score <=109) $level = 4;
        elseif ($score >= 104 && $score <=106) $level = 3;
        elseif ($score >= 101 && $score <=103) $level = 2;
        else return '-';

        $output = '<div class="stars">';
        for ($i = 0; $i < $level; $i++) {
            $output .= '<img src="' . asset('img/star.png') . '" alt="star">';
        }
        $output .= '</div>';
        return $output;
    }
    @endphp

    <!-- bintang untuk speaking -->
     @php
    function toeflPrimaryStars2($score) {
        if ($score >= 23 && $score <=27) $level = 5;
        elseif ($score >= 18 && $score <=22) $level = 4;
        elseif ($score >= 13 && $score <=17) $level = 3;
        elseif ($score >= 7 && $score <=12) $level = 2;
        elseif ($score >= 1 && $score <=6) $level = 1;
        else return '-';

        $output = '<div class="stars">';
        for ($i = 0; $i < $level; $i++) {
            $output .= '<img src="' . asset('img/badge.png') . '" alt="badge">';
        }
        $output .= '</div>';
        return $output;
    }
    @endphp

    <!-- bintang untuk writing -->
     @php
    function toeflPrimaryStars3($score) {
        if ($score >= 16 && $score <=17) $level = 4;
        elseif ($score >= 11 && $score <=15) $level = 3;
        elseif ($score >= 6 && $score <=10) $level = 2;
        elseif ($score >= 0 && $score <=5) $level = 1;
        else return '-';

        $output = '<div class="stars">';
        for ($i = 0; $i < $level; $i++) {
            $output .= '<img src="' . asset('img/badge.png') . '" alt="badge">';
        }
        $output .= '</div>';
        return $output;
    }
    @endphp


  <div class="certificate">
    <img class="watermark" src="https://bpi-english-lab.com/wp-content/uploads/2025/05/toefl-primary-e1747036028969.png" alt="BPI Watermark"/>

    <div class="certificate-inner">
      <img class="logo" src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png" alt="BPI Logo"/>

      <div class="certificate-number">No: TOEFL-P1-2025/0568</div>
      <div class="qr-validation">Scan here for validation</div>
      <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://bpi-english-lab.com/validate/12345" alt="QR Code"/>
      <div class="valid-until">Valid until: 12/05/26</div>

      <div class="toefl-header">TOEFL PRIMARY</div>
      <div class="step">Step 1</div>
      <div class="title">Certificate of Achievement</div>
      <div class="subtitle">This is to certify that</div>
      <div class="participant">{{ $certificatetoeflprimarystep1->name }}</div>

      <div class="test-description">Has earned the following levels on the TOEFL Primary Prediction Test</div>

        <div class="scores-container">
        <div class="score-column">
            <div class="score-item">
                <span class="score-label">Reading:</span>
                <span class="score-value">{!! toeflPrimaryStars($certificatetoeflprimarystep1->reading_score ?? 0) !!}</span>
            </div>
        </div>
        <div class="score-column">
            <div class="score-item">
                <span class="score-label">Speaking:</span>
                <span class="score-value">{!! toeflPrimaryStars2($certificatetoeflprimarystep1->speaking_score ?? 0) !!}</span>
            </div>
        </div>
        <div class="score-column">
            <div class="score-item">
                <span class="score-label">Listening:</span>
                <span class="score-value">{!! toeflPrimaryStars($certificatetoeflprimarystep1->listening_score ?? 0) !!}</span>
            </div>
        </div>
        <div class="score-column">
            <div class="score-item">
                <span class="score-label">Writing:</span>
                <span class="score-value">{!! toeflPrimaryStars3($certificatetoeflprimarystep1->writing_score ?? 0) !!}</span>
            </div>
        </div>
        </div>


      <div class="footer">
        <div class="date">Test Date: {{ $certificatetoeflprimarystep1->exam_date}}</div>
      </div>

      <div class="signatures">
        <div class="signature">
          <div class="signatory-title">Development Director<br>of BPI Foundation</div>
          <div class="signature-space"></div>
          <div class="signature-line"></div>
          <div class="signatory-name">Lukman Arif Rahman, M.Pd.</div>
        </div>
        <div class="signature">
          <div class="signatory-title">Head of UPK Prodiksus<br>‎ </div>
          <div class="signature-space"></div>
          <div class="signature-line"></div>
          <div class="signatory-name">Lina Roufah, S.Pd.</div>
        </div>
        <div class="signature">
          <div class="signatory-title">Principal of BPI<br>Elementary School</div>
          <div class="signature-space"></div>
          <div class="signature-line"></div>
          <div class="signatory-name">Rini Trisnawulan, S.S.</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
