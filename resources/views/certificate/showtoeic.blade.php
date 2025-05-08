<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>TOEIC Prediction Certificate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Lato:ital,wght@0,400;0,700;1,400&family=PT+Serif:ital,wght@0,400;0,700;1,400&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Lato', sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .certificate {
      width: 1100px;
      height: 850px;
      background-image: url('https://i.ibb.co.com/Tx6C4XHZ/toeic.png');
      background-size: cover;
      background-position: center;
      padding: 40px;
      position: relative;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .logo {
      position: absolute;
      top: 30px;
      left: 40px;
      width: 60px;
    }

    .title {
      text-align: center;
      font-family: 'Helvetica', Arial, sans-serif;
      font-style: italic;
      font-weight: bold;
      font-size: 37px;
      margin-top: 70px;
    }

    .subtitle {
      text-align: center;
      font-family: 'Source Serif Pro', serif;
      font-weight: bold;
      font-size: 28px;
      margin-top: 50px;
    }

    .certify-section {
      margin-left: -220px;
      margin-top: 60px;
      margin-bottom: 30px;
      text-align: center;
      padding: 0 60px;
    }

    .certify-text {
      font-family: 'Lato', sans-serif;
      font-style: italic;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .participant-name {
      font-family: 'DM Serif Display', serif;
      font-weight: bold;
      font-size: 28px;
      margin: 10px 0;
      text-transform: uppercase;
    }

    .score-text {
      font-family: 'PT Serif', serif;
      font-style: italic;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .test-title {
      font-family: 'PT Serif', serif;
      font-weight: bold;
      font-size: 24px;
      text-align: center;
      font-style: italic;
      margin-bottom: 10px;
    }

    .scores-section {
      display: flex;
      justify-content: center;
      margin: 10px 0 10px -105px;
      font-weight: bold;
    }
    
    .scores-labels {
      font-family: 'PT Serif', serif;
      text-align: left;
      padding-right: 40px;
      line-height: 1.6;
    }
    
    .scores-values {
      font-family: 'PT Serif', serif;
      text-align: left;
      padding-left: 40px;
      line-height: 1.6;
    }

    .info-table {
      width: 60%;
      margin: 20px auto;
      font-size: 14px;
    }
    
    .info-row {
      display: flex;
      margin-bottom: 5px;
    }
    
    .info-label {
      font-family: 'PT Serif', serif;
      text-align: right;
      padding-right: 10px;
      font-style: italic;
      width: 50%;
    }
    
    .info-value {
      font-family: 'PT Serif', serif;
      text-align: left;
      padding-left: 10px;
      font-weight: bold;
      width: 50%;
    }

    .toeic-scale-1 { 
      margin-top: 10px;
      text-align: left;
      padding-left: 10px;
      width: 50%;
      font-family: 'Lato', sans-serif;
      font-weight: bold;
    }

    .toeic-scale { 
      text-align: left;
      padding-left: 10px;
      width: 50%;
      font-family: 'Lato', sans-serif;
    }

   /* FOOTER */
   .footer {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: -70px;
      position: relative;
      z-index: 1;
    }
    .qrcode-section {
      text-align: center;
      font-size: 12px;
    }
    .qrcode {
      width: 100px;
      height: 100px;
      background: url('https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://bpi-english-lab.com/validate/12345') no-repeat center center;
      background-size: cover;
      margin: 10px auto;
    }
    .signature {
      text-align: center;
      font-size: 14px;
    }
    .signature-line {
      width: 200px;
      border-top: 1px solid #000;
      margin-bottom: 5px;
      margin-left: auto;
      margin-right: auto;
    }
    
    .profile-image {
      width: 90px;
      height: 100px;
      position: absolute;
      top: 290px;
      right: 300px;
    }
  </style>
</head>
<body>
  <div class="certificate">
    <img src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png" alt="Logo" class="logo" />

    <div class="title">TOEIC Prediction Test</div>
    <div class="subtitle">Certificate of Achievement</div>

    <div class="certify-section">
      <p class="certify-text">This is to certify that</p>
      <div class="participant-name">{{ $certificatetoeic->name }}</div>
      <p class="score-text">achieved the following scores on the</p>
    </div>
    <div class="test-title">Test of English for International Communication</div>
    
    <img src="https://bpi-english-lab.com/wp-content/uploads/2025/05/image_placeholder.png" alt="Profile" class="profile-image" />

    <div class="scores-section">
      <div class="scores-labels">
        <p>Listening:</p>
        <p>Reading:</p>
        <p>Total:</p>
      </div>
      <div class="scores-values">
        <p>{{ $certificatetoeic->listening_score }}</p>
        <p>{{ $certificatetoeic->reading_score }}</p>
        <p>{{ $certificatetoeic->total_score }}</p>
      </div>
    </div>

    <div class="info-table">
      <div class="info-row">
        <div class="info-label">as administered under the auspices of:</div>
        <div class="info-value">BPI English Lab</div>
      </div>
      <div class="info-row">
        <div class="info-label">at:</div>
        <div class="info-value">Indonesia</div>
      </div>
      <div class="info-row">
        <div class="info-label">test date:</div>
        <div class="info-value">{{ $certificatetoeic->exam_date }}</div>
      </div>
      <div class="info-row">
        <div class="info-label"></div>
        <div class="toeic-scale-1">TOEIC SCALE</div>
      </div>
      <div class="info-row">
        <div class="info-label"></div>
        <div class="toeic-scale">Listening: 5-495</div>
      </div>
      <div class="info-row">
        <div class="info-label"></div>
        <div class="toeic-scale">Reading: 5-495</div>
      </div>
      <div class="info-row">
        <div class="info-label"></div>
        <div class="toeic-scale">Total: 0-990</div>
      </div>
    </div>

        <!-- FOOTER -->
        <div class="footer">
          <div class="qrcode-section">
            Scan here for validation
            <div class="qrcode"></div>
            Valid until: 15/12/24
          </div>
          <div class="signature">
            <div class="signature-line"></div>
            <div>Name</div>
          </div>
        </div>
      </div>

  </div>
</body>
</html>