<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TOEFL Junior Certificate</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body { 
      width:100%; 
      height:100%; 
      font-family:'Lato',sans-serif; 
    }

    body {
      display: flex; 
      align-items: center; 
      justify-content: center;
      padding: 20px; 
      background: #f0f0f0;
    }

    .certificate-container {
      width: 1200px;
      height: 800px;
      position: relative;
      background-image: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/toefljunior.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: top center;   
      padding: 30px;                    
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .content {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      display: flex;
      flex-direction: column;
      align-items: center;              
    }

    .header {
      width:100%; text-align:center;
      margin-top: 42px; 
      position: relative;
    }
    .logo {
      position: absolute;
      top: 60px;    
      left: 140px;  
      width: 63px;   height: auto;
    }
    .header-title {
      margin-top: 60px;
      font-size: 37px; 
      font-family: Helvetica, sans-serif;
      font-style: italic;
    }
    .header-title strong { font-weight: bold; }
    .header-number {
      margin-top: 10px;          
      font-size: 25px;          
      text-align: left;
      margin-left: 448px;        
      font-weight: 400;
    }

    .main-title {
      margin: 10px 0 21px; 
      font-size: 35px;     
      font-weight: 600;
    }
    .subtitle, .subtitle2 {
      font-size: 20px;     
      font-weight: bold;
      text-align: center;
    }
    .subtitle2 { margin-top: 10px;  }

    .name {
      margin: 14px 0 14px; 
      font-size: 45px;     
      font-weight: bold;
      text-align: center;
    }
    .test-name {
      margin: 7px 0 7px;  
      font-size: 32px;    
      font-style: italic;
      text-align: center;
    }

    .scores {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .score-item,
    .score-item2,
    .score-item3,
    .score-item4 {
      font-size: 18px;    
    }
    .score-item   { margin-left: -42px;   }
    .score-item2  { margin-left: -196px;  margin-top: 7px; }
    .score-item3  { margin-left: -35px;   }
    .score-item4  { margin-left: -77px;   margin-top: 4px; }

    .score-value { font-weight: bold; margin-left: 7px; }

    .footer {
      position: absolute;
      bottom: 105px;    
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 0 90px; 
    }
    .left-footer {
      font-size: 17px;   
      text-align: left;
      margin-left: 50px;
      margin-top: 17px;
    }
    .qrcode {
      margin: 7px 14px;  
    }
    .mid-footer {
      font-size: 18px;   
      text-align: center;
      margin-top: 60px;  
      line-height: 1.6;
    }
    .school {
      font-size: 20px;   
      font-weight: bold;
      margin-top: -20px;
      margin-bottom: 13px;
      margin-left: 84px; 
    }

    .info-line {
      display: flex; justify-content: center; gap: 6px; 
      font-style: italic;
      margin-left: -126px; 
    }
    .info-line .label2 {
      margin-left: -81px; 
    }
    .info-line .value { font-weight: 600; font-style: normal; }

    .right-footer {
      font-size: 17px;  
      text-align: right;
      margin-top: 120px;
      margin-right: 50px;
      
    }
    .signature-line {
      width: 220px;      
      border-top: 1px solid #000;
      margin-top: 32px; 
    }
    .signature-label {
      font-size: 17px;  
      margin-top: 4px; 
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="certificate-container">
    <div class="content">
      <div class="header">
        <img src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png"
             class="logo" alt="Logo">
        <div class="header-title">TOEFL <strong>Junior.</strong></div>
        <div class="header-number">No.</div>
      </div>

      <div class="main-title">CERTIFICATE OF ACHIEVEMENT</div>
      <div class="subtitle">This is to certify that</div>
      <div class="name">{{ $certificatetoefljunior->name }}</div>
      <div class="subtitle2">achieved the following scores on the</div>
      <div class="test-name">TOEFL Junior Prediction Test</div>

      <div class="scores">
        <div class="score-item">
          <span>Listening</span>
          <span class="score-value">{{ $certificatetoefljunior->listening_score }}</span>
        </div>
        <div class="score-item2">
          <span>Language Form and Meaning</span>
          <span class="score-value">{{ $certificatetoefljunior->language_form_score }}</span>
        </div>
        <div class="score-item3">
          <span>Reading</span>
          <span class="score-value">{{ $certificatetoefljunior->reading_score }}</span>
        </div>
        <div class="score-item4">
          <span>Overall Score</span>
          <span class="score-value">{{ $certificatetoefljunior->total_score }}</span>
        </div>
      </div>

      <div class="footer">
        <div class="left-footer">
          Scan here for validation
          <div class="qrcode">{!! $qrCode !!}</div>
          Valid until: DD/MM/YY
        </div>
        <div class="mid-footer">
          <div class="school">BPI English Lab</div>
          <div class="info-line">
            <span class="label">at:</span>
            <span class="value">Bandung, Indonesia</span>
          </div>
          <div class="info-line">
            <span class="label2">date:</span>
            <span class="value">{{ \Carbon\Carbon::parse($certificatetoefljunior->exam_date)->format('d-m-Y') }}</span>
          </div>
        </div>
        <div class="right-footer">
          <div class="signature-line"></div>
          <div class="signature-label">name</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
