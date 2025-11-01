<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sertifikat BelajarSiko</title>
<style>
  @page { size: A4 landscape; margin: 30px 40px; }

  :root{
    --primary:#4f47e6; --primary-200:#c7c9fa; --ink:#1f2937; --muted:#6b7280;
    --scale:1.00;
  }
  body{ font-family: DejaVu Sans, sans-serif; color:var(--ink); margin:0; background:#fff; }

  /* ====== FONT LUSITANA (untuk nama) ====== */
  @font-face{
    font-family:'Lusitana';
    font-style:normal; font-weight:400;
    src:url("{{ public_path('fonts/lusitana/Lusitana-Regular.ttf') }}") format('truetype');
  }
  @font-face{
    font-family:'Lusitana';
    font-style:normal; font-weight:700;
    src:url("{{ public_path('fonts/lusitana/Lusitana-Bold.ttf') }}") format('truetype');
  }

  /* ====== TANPA BINGKAI (bersih) ====== */
  .frame{ border:none; border-radius:0; background:transparent; padding:0; box-shadow:none; }
  .frame-inner{ border:none; border-radius:0; padding:42px 80px; min-height:530px; position:relative; box-sizing:border-box; }

  /* ====== BRAND ====== */
  .brand-centered{ text-align:center; margin-bottom:18px; transform:scale(var(--scale)); transform-origin:center top; }
  .brand-logo-text{ white-space:nowrap; }
  .brand-logo-text img{ height:56px; position:relative; top:-6px; vertical-align:middle; }
  .brand-logo-text h2{ display:inline-block; margin:0 0 0 10px; color:var(--primary); font-size:32px; font-weight:800; vertical-align:middle; }
  .brand-code{ display:block; margin-top:-3px; font-size:16px; color:#6b7280; line-height:1.1; font-family: DejaVu Sans Mono, monospace; font-style:italic; }
  .brand-number{ display:block; margin-top:2px; font-size:14px; color:#6b7280; line-height:1.1; font-family: DejaVu Sans Mono, monospace; }

  /* ====== JUDUL ====== */
  .title-wrap{ text-align:center; margin-top:10px; }
  .title-main{
    font-family: "DejaVu Serif", serif; font-weight:900; font-size:44px;
    letter-spacing:6px; text-transform:uppercase; color:#1f4a5a; margin:10px 0 4px;
  }
  .title-sub{
    font-family: "DejaVu Serif", serif; font-weight:600; font-size:18px;
    letter-spacing:8px; text-transform:uppercase; color:#6b7280; margin:0 0 12px;
  }

  /* ====== KONTEN ====== */
  .sub{ text-align:center; margin:6px 0 14px; font-size:16px; color:#6b7280; }
  .name{
    text-align:center; font-family:'Lusitana','DejaVu Serif',serif;
    font-weight:700; font-style:normal; font-size:45px;
    line-height:1.15; margin:12px 0; color:#111827;
  }
  .desc{ text-align:center; color:#374151; font-size:18px; margin:20px 0 10px; }
  .course{ text-align:center; font-size:32px; font-weight:800; color:var(--primary); margin-bottom:18px; }
  .course-subtitle{ text-align:center; font-size:16px; color:#4b5563; font-style:italic; margin-top:-8px; margin-bottom:10px; }
  .duration{ text-align:center; font-size:14px; color:#6b7280; margin-top:0; }
  .muted{ text-align:center; font-size:14px; color:#6b7280; }

  /* ====== TANDA TANGAN (Halaman 1 saja) ====== */
  .signers{ position:absolute; bottom:50px; left:0; right:0; text-align:center; }
  .sign{ display:inline-block; width:40%; margin:0 3%; vertical-align:top; }
  .sign img{
    height:90px; margin-bottom:2px;
    filter:contrast(125%) brightness(90%) drop-shadow(1px 1px 2px rgba(0,0,0,.35));
    -webkit-filter:contrast(125%) brightness(90%) drop-shadow(1px 1px 2px rgba(0,0,0,.35));
  }
  /* Signature overlay container */
  .sig-wrap{ position:relative; display:inline-block; height:90px; }
  .sign .sign-image{ position:relative; z-index:1; }
  /* Cap/Stamp overlay (Director) */
  .sign .stamp{
    position:absolute; z-index:2; left:50%; top:2px;
    transform:translateX(-50%) rotate(-12deg);
    -webkit-transform:translateX(-50%) rotate(-12deg);
    height:98px !important; /* slightly larger for emphasis */
    margin:0 !important; filter:none !important; -webkit-filter:none !important;
    opacity:0.55; /* semi-transparent for realistic stamp */
    pointer-events:none;
  }
  .sign .line{ width:260px; height:2px; background:#cbd5e1; margin:0 auto 4px; }
  .sign .name{ font-size:18px; font-weight:800; color:var(--ink); margin:2px 0 0; }
  .sign .role{ font-size:12px; color:#6b7280; margin-top:3px; }

  /* ====== CATATAN VERIFIKASI (hanya halaman 2) ====== */
  .verify-note{
    display:block;
    margin-top:12px;
    font-size:9px;       /* kecil */
    font-style:italic;   /* italic */
    color:#6b7280;
    text-align:center;
  }

  /* ====== WATERMARK ====== */
  .watermark{ position:absolute; top:50%; left:50%; transform:translate(-50%,-50%) rotate(-45deg); z-index:-1; opacity:.05; }
  .watermark img{ width:520px; }

  /* ====== LAMPIRAN KOMPETENSI ====== */
  .page-break{ page-break-before: always; }
  .section-title{ text-align:center; font-family: "DejaVu Serif", serif; font-weight:800; font-size:22px; color:#1f4a5a; margin:0 0 18px; }
  table.competency{ width:100%; border-collapse:collapse; font-size:12px; }
  table.competency th, table.competency td{ border:1px solid #d1d5db; padding:8px; vertical-align:top; }
  table.competency th{ background:#eef2ff; color:#1f2937; text-transform:uppercase; font-weight:700; font-size:11px; }
  .assess-meta{ margin-top:14px; font-size:12px; color:#374151; }
</style>
</head>
<body>

  <!-- Halaman 1 -->
  <div class="frame">
    <div class="frame-inner">
      <!-- Watermark -->
      <div class="watermark">
        <img src="{{ public_path('images/logo-sbu.svg') }}" alt="Watermark">
      </div>

      <!-- Brand -->
      <div class="brand-centered">
        <div class="brand-logo-text">
          <img src="{{ public_path('images/logo-sbu.svg') }}" alt="BelajarSiko">
          <h2>BelajarSiko</h2>
        </div>
        <div class="brand-code">Kode: {{ $certificate->unique_code }}</div>
        @if(!empty($formalNumber))
          <div class="brand-number">Nomor: {{ $formalNumber }}</div>
        @endif
      </div>

      <!-- Judul -->
      <div class="title-wrap">
        <div class="title-main">SERTIFIKAT</div>
        <div class="title-sub">{{ $certificateType ?? 'KELULUSAN' }}</div>
      </div>

      <div class="sub">DIBERIKAN KEPADA</div>
      <div class="name">{{ strtoupper($user->name) }}</div>
      <div class="desc">Dengan ini menyatakan bahwa nama tersebut telah <strong>LULUS</strong> dan terbukti <strong>KOMPETEN</strong> dalam kursus:</div>
      <div class="course">{{ $course->title }}</div>
      @if(!empty($courseSubtitle))
        <div class="course-subtitle">{{ $courseSubtitle }}</div>
      @endif
      @if(!empty($totalJP))
        <div class="duration">Total {{ $totalJP }} Jam Pelajaran (JP)</div>
      @endif
      <div class="muted">Diterbitkan pada {{ $certificate->generated_at->isoFormat('D MMMM YYYY') }}</div>

      <!-- Tanda tangan (Director kiri, Mentor kanan) -->
      <div class="signers">
        <!-- Director (KIRI) -->
        <div class="sign">
          @if (!empty($directorSignaturePath) && file_exists($directorSignaturePath))
            <div class="sig-wrap">
              <img class="sign-image" src="{{ $directorSignaturePath }}" alt="Tanda tangan Director">
              <img class="stamp" src="{{ public_path('images/Cap.svg') }}" alt="Cap/Stamp">
            </div>
          @else
            <div style="height:90px"></div>
          @endif
          <div class="line"></div>
          <div class="name">{{ $directorName }}</div>
          <div class="role">Director of BelajarSiko</div>
        </div>
        <!-- Mentor (KANAN) -->
        <div class="sign">
          @if (!empty($mentorSignaturePath) && file_exists($mentorSignaturePath))
            <img src="{{ $mentorSignaturePath }}" alt="Tanda tangan Mentor">
          @else
            <div style="height:90px"></div>
          @endif
          <div class="line"></div>
          <div class="name">{{ $mentorName }}</div>
          <div class="role">Mentor</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Halaman 2: Rincian Kompetensi -->
  <div class="page-break"></div>
  <div class="frame">
    <div class="frame-inner">

      <div class="section-title">Rincian Kompetensi</div>
      @php
        $items = $competencyItems ?? ($certificate->competencies ?? ($course->certificate_competencies ?? null));
        if (!is_array($items) || empty($items)) {
            $items = [
              ['kompetensi' => 'Logika & Pemecahan Masalah', 'butir' => 'Menganalisis masalah dan merancang solusi terstruktur', 'nilai' => '', 'keterangan' => ''],
              ['kompetensi' => 'Algoritma Dasar', 'butir' => 'Kontrol alur, perulangan, fungsi/prosedur', 'nilai' => '', 'keterangan' => ''],
              ['kompetensi' => 'Struktur Data Dasar', 'butir' => 'Array/List, Dictionary/Map, Stack/Queue', 'nilai' => '', 'keterangan' => ''],
              ['kompetensi' => 'Pemrograman Python Dasar', 'butir' => 'Sintaks dasar, modul, pengelolaan lingkungan', 'nilai' => '', 'keterangan' => ''],
              ['kompetensi' => 'Debugging & Testing', 'butir' => 'Menemukan, memperbaiki bug dan uji sederhana', 'nilai' => '', 'keterangan' => ''],
            ];
        }
      @endphp

      <table class="competency">
        <thead>
          <tr>
            <th style="width:32%">Kompetensi</th>
            <th>Indikator/Butir Penilaian</th>
            <th style="width:10%">JP</th>
            <th style="width:22%">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $row)
            <tr>
              <td>{{ $row['kompetensi'] ?? ($row['name'] ?? '') }}</td>
              <td>{{ $row['butir'] ?? ($row['indicator'] ?? '') }}</td>
              <td>{{ $row['jp'] ?? '' }}</td>
              <td>{{ $row['keterangan'] ?? ($row['note'] ?? '') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- (Halaman 2 TANPA tanda tangan) -->
      <div class="verify-note">
        Sertifikat digital resmi BelajarSiko — keaslian terjamin.
        Verifikasi keabsahan di <strong>belajarsiko.my.id/verify/RQ5AHGUJAS</strong>.
      </div>

    </div>
  </div>

</body>
</html>
