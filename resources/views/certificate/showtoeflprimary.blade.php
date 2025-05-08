<!DOCTYPE html>
<html>
<head>
  <style>
    body, html { margin:0; padding:0; }
    .bg { position:absolute; top:0; left:0; width:100%; z-index:0; }
    .field { position:absolute; z-index:1; font-family:sans-serif; }
    .certificate-no { top: 40px; left: 50px; font-size:14px; }
    .person-name   { top:120px; left:0; width:100%; text-align:center; font-size:36px; font-weight:bold; }
    .stars.reading { top:200px; left:180px; }
    .stars.listening { top:230px; left:180px; }
    .stars.speaking  { top:200px; left:450px; }
    .stars.writing   { top:230px; left:450px; }
    .qr-code { top:500px; left:50px; }
    .footer-date { position:absolute; bottom:60px; left:50px; font-size:12px; }
    .footer-signer { position:absolute; bottom:60px; right:100px; font-size:12px; }
  </style>
</head>
<body>
  {{-- Background image --}}
  <img src="{{ public_path('img/certificate-bg.png') }}" class="bg" />

  {{-- No Sertifikat --}}
  <div class="field certificate-no">
    No: {{ $certificateNumber }}
  </div>

  {{-- Nama Peserta --}}
  <div class="field person-name">
    {{ $user->name }}
  </div>

  {{-- Bintang untuk tiap skill --}}
  @foreach(['reading','listening','speaking','writing'] as $skill)
    <div class="field stars {{ $skill }}">
      @for($i=0; $i < $scores[$skill]; $i++)
        <img src="{{ public_path('img/star.png') }}" width="20" />
      @endfor
    </div>
  @endforeach

  {{-- QR Code --}}
  <div class="field qr-code">
    <img src="{{ $qr }}" width="120" />
  </div>

  {{-- Footer --}}
  <div class="field footer-date">
    Valid until: {{ $validUntil->format('d/m/Y') }}
  </div>
  <div class="field footer-signer">
    {{ $signerName }}
  </div>
</body>
</html>
