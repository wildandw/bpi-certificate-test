<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1300">
    <title>IELTS Prediction Test Report Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 20px;
            position: relative;
            background-color: grey;
        }
        .container {
            position: relative;
            padding: 20px;
            max-width: 1150px;
            margin: 0 auto;
        }
        .background-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 1;
            z-index: -1;
            background-image: url('https://bpi-english-lab.com/wp-content/uploads/2025/05/ielts_bg.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            margin-left: 30px;
        }
        .ielts-logo {
            width: 150px;
            height: auto;
            margin-top: 40px;
            margin-bottom: -30px;
        }

        .bpi-logo {
            width: 90px;
            height: auto;
            margin-right: 40px;
            margin-bottom: 10px;
            margin-top: 40px;
        }

        .report-title {
            font-weight: bold;
            font-size: 18px;
            margin-left: -600px;
            margin-top: 110px;
        }
        .date-section {
            display: flex;
            justify-content: space-between;
            margin: 10px 40px 0 190px;
        }
        .date-input {
            width: 200px;
            height: 25px;
            text-align: center;
            border: 1px solid #000;
        }
        .reference-input {
            width: 250px;
            height: 25px;
            text-align: center;
            border: 1px solid #000;
            font-size: 12px;
        }
        .divider {
            border-top: 1px solid #000;
            width: 95%;
            margin: 10px 0 0 20px;
        }
        .divider2 {
            border-top: 1px solid #000;
            width: 95%;
            margin: 0 0 0 20px;
        }
        .candidate-section {
            display: flex;
            justify-content: space-between;
            margin-left: 40px;
            margin-right: 40px;
        }
        .candidate-left {
            width: 70%;
        }
        .candidate-right {
            width: 30%;
            text-align: center;
        }
        .form-row {
            display: flex;
            margin-bottom: 10px;
            align-items: center;
        }
        .form-label {
            width: 200px;
            font-weight: bold;
            font-size: 14px;
        }
        .form-input {
            flex: 1;
            height: 25px;
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
        }
        .sex-input {
            width: 40px;
            height: 33px;
            border: 1px solid #000;
            text-align: center;
            margin-left: 10px;
        }
        .test-results {
            margin: 20px 40px 0 40px;
        }
        .results-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: -40px 0;
        }
        .result-box {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .result-label {
            font-weight: bold;
            font-size: 14px;
            margin-right: 10px;
            color: #333;
        }
        .result-value {
            width: 50px;
            height: 35px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }
        
        .cefr-container {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
            margin-bottom: 50px;
        }

        .cefr-box {
            border: 1px solid #000;
            width: 80px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 30px;
        }

        .validation-section {
            text-align: center;
            margin: 10px -100px 0 0;
        }
        .validation-text {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .qr-code {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        .valid-until {
            font-weight: bold;
            margin-top: 10px;
        }
        .cefr-label {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            margin-bottom: 20px;
        }
        .signature {
            text-align: center;
            width: 30%;
        }
        .signature-line {
            width: 70%;
            border-top: 1px solid #000;
            margin: 10px 0;
            margin-top: 130px;
            margin-left: 45px;
        }
        .signature-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            text-align: center;
        }
        .signature-name {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="background-img"></div>
        <div class="header">
            <img src="https://1000logos.net/wp-content/uploads/2021/03/IELTS-logo.png" alt="IELTS Logo" class="ielts-logo">
            <div class="report-title">Prediction Test Report Form</div>
            <img src="https://bpiedu.id/yayasanbpi/images/2022/10/03/logo%20bpi%20clear.png" alt="BPI Logo" class="bpi-logo">
        </div>
        
        <div class="date-section">
            <div>Test Date: <input type="text" class="date-input" value="12/05/2025"></div>
            <input type="text" class="reference-input" value="LEAD00/00.0000/000-BILO/D-YYYY">
        </div>
        
        <div class="divider"></div>
        
        <div class="candidate-section">
            <div class="candidate-left">
                <h3>Candidate Details</h3>
                
                <div class="form-row">
                    <div class="form-label">Nama</div>
                    <input type="text" class="form-input" value="{{ $certificateieltstestc->name}}" readonly>
                </div>
                
                <div class="form-row">
                    <div class="form-label">Date of Birth Sex (M/F)</div>
                    <input type="text" class="form-input" style="width: 200px;" value="01/01/2001" readonly>
                    <input type="text" class="sex-input" value="M" readonly>
                </div>
                
                <div class="form-row">
                    <div class="form-label">Country or Region of Origin</div>
                    <input type="text" class="form-input" value="INDONESIA" readonly>
                </div>
                
                <div class="form-row">
                    <div class="form-label">Country or Region of Nationality</div>
                    <input type="text" class="form-input" value="INDONESIA" readonly>
                </div>
                
                <div class="form-row">
                    <div class="form-label">First Language</div>
                    <input type="text" class="form-input" value="BAHASA INDONESIA" readonly>
                </div>
            </div>
            
            <div class="candidate-right">
                <div class="validation-section">
                    <div class="validation-text">Scan here for validation</div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://bpi-english-lab.com/validate/12345" alt="QR Code" class="qr-code">
                    <div class="valid-until">Valid until: DD/MM/YY</div>
                </div>
            </div>
        </div>
        
        <div class="test-results">
            <div class="form-label">Test Results</div>
            <div class="results-row">
                <div class="result-box">
                    <div class="result-label">LISTENING</div>
                    <div class="result-value">{{ $certificateieltstestc->listening_score}}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">READING</div>
                    <div class="result-value">{{ $certificateieltstestc->reading_score}}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">WRITING</div>
                    <div class="result-value">{{ $certificateieltstestc->writing_score}}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">SPEAKING</div>
                    <div class="result-value">{{ $certificateieltstestc->speaking_score}}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">OVERALL BAND SCORE</div>
                    <div class="result-value">{{ $certificateieltstestc->total_score}}</div>
                </div>
                    <div class="cefr-container">
                        <div class="cefr-label">CEFR</div>
                        <div class="cefr-box">C1</div>
                </div>
            </div>
        </div>
        
        
        <div class="divider2"></div>
        
        <div class="signatures">
            <div class="signature">
                <div class="signature-title">Development Director<br>of BPI Foundation</div>
                <div class="signature-line"></div>
                <div class="signature-name">Lukman Arif Rachman, M.Pd.</div>
            </div>
            
            <div class="signature">
                <div class="signature-title">Head of UPK Prodiksus<br>‎ </div>
                <div class="signature-line"></div>
                <div class="signature-name">Lina Roufah, S.Pd.</div>
            </div>
            
            <div class="signature">
                <div class="signature-title">Principal of BPI 1<br>Senior High School</div>
                <div class="signature-line"></div>
                <div class="signature-name">Tatang, M.Pd.</div>
            </div>
        </div>
    </div>
</body>
</html>