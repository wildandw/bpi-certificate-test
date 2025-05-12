<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1100">
    <title>TOEFL Junior Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color:  #f5f5f5;
        }
        .certificate-container {
            position: relative;
            width: 1000px;
            height: 700px;
            padding: 20px;
            border: 20px solid #ffee00;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: #fff;
        }
        .background-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 1;
            z-index: -1;
            background-image: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/toefl-junior-e1747042658628.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            position: relative;
            margin-top: 20px;
            margin-left: 20px;
        }

        .logo {
            position: absolute;
            left: 0;
            width: 90px;
            height: auto;
            margin-top: 40px;
        }

        .title {
            font-size: 34px;
            font-weight: 400;
            text-align: center;
            font-style: italic;
        }

        .certificate-title {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .certify-text {
            font-size: 20px;
            font-style: italic;
            text-align: center;
            margin: 20px 0;
        }
        .student-name {
            font-size: 40px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .achievement-text {
            font-size: 20px;
            font-style: italic;
            text-align: center;
            margin: 10px 0;
        }
        .test-type {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .scores {
            display: flex;
            justify-content: space-between;
            text-align: left;
            margin: 20px 0 35px 200px;
            font-style: italic;
            
        }
        
        .scores-left {
            width: 100%;
            text-align: right;
            margin-left: 50px;
        }
        .scores-right {
            width: 30%;
            margin-left: 200px;
            text-align: right;
        }

        .scores-right-2 {
            width: 60%;
            margin-right: 50px;
        }

        .score-item {
            margin: 5px 0;
            font-size: 16px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .signature {
            text-align: center;
            width: 32%;
        }
        .signature-line {
            width: 100%;
            border-top: 1px solid #000;
            margin: 10px 0;
            margin-top: 130px;
        }
        .signature-title {
            font-weight: bold;
            font-size: 13px;
            text-align: center;
        }
        .signature-name {
            font-weight: bold;
            font-size: 14px;
        }
        .certificate-number {
            text-align: center;
            margin: 5px 0 20px 0;
        }
        .validation-section {
            position: absolute;
            top: 40px;
            right: 40px;
            text-align: center;
        }
        .validation-text {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .qrcode {
          width: 100px;
          height: 100px;
          margin: 7px auto;
        }
        .valid-until {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="background-img"></div>
        
        <div class="validation-section">
            <div class="validation-text">Scan here for validation</div>
              <div class="qrcode">
              {!! $qrCode !!}
            </div>
            <div class="valid-until">Valid until: May 2027</div>
        </div>

        <div class="header">
            <img src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png" alt="BPI Logo" class="logo">
            <div class="title">TOEFL <strong>Junior.</strong></div>
        </div>

        <div class="certificate-number">No. 2025/05/123456</div>
        
        <div class="certificate-title">CERTIFICATE OF ACHIEVEMENT</div>
        
        <div class="certify-text">This is to certify that</div>
        
        <div class="student-name">{{ $certificatetoefljunior->name }}</div>
        
        <div class="achievement-text">achieved the following scores on the</div>
        <div class="test-type">TOEFL Junior Prediction Test</div>
        
        
        <div class="scores">
            <div class="scores-left">
                <div class="score-item">Listening: <strong>{{ $certificatetoefljunior->listening_score }}</strong></div>
                <div class="score-item">Language Form and Meaning: <strong>{{ $certificatetoefljunior->language_form_score }}</strong></div>
                <div class="score-item">Reading: <strong>{{ $certificatetoefljunior->reading_score }}</strong></div>
                <div class="score-item">Overall Score: <strong>{{ $certificatetoefljunior->total_score }}</strong></div>
            </div>
            <div class="scores-right">
                <div class="score-item">‎</div>
                <div class="score-item">at: </div>
                <div class="score-item">date: </div>
            </div>
            <div class="scores-right-2">
                <div class="score-item"><strong>BPI English Lab</strong></div>
                <div class="score-item"><strong>Bandung, Indonesia</strong> </div>
                <div class="score-item"><strong>12-05-2025</strong></div>
            </div>
        </div>

        
        <div class="signatures">
            <div class="signature">
                <div class="signature-title">Development Director<br>of BPI Foundation</div>
                <div class="signature-line"></div>
                <div class="signature-name">Lukman Arif Rachman, M.Pd.</div>
            </div>
            
            <div class="signature">
                <div class="signature-title">Head of UPK Prodiksusbr<br>‎</div>
                <div class="signature-line"></div>
                <div class="signature-name">Lina Roufah, S.Pd.</div>
            </div>
            
            <div class="signature">
                <div class="signature-title">Principal of BPI<br>Junior High School</div>
                <div class="signature-line"></div>
                <div class="signature-name">Rina Indrawaty, S.Pd</div>
            </div>
        </div>
    </div>
</body>
</html>