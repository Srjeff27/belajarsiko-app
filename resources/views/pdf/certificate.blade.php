<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        :root {
            --primary: #4f47e6;
        }

        .frame {
            border: 8px solid var(--primary);
            border-radius: 12px;
            background: #fff;
            padding: 10px;
        }

        .frame-inner {
            border: 1px solid #c7c9fa;
            border-radius: 8px;
            padding: 40px 80px;
            height: 530px;
            box-sizing: border-box;
            position: relative;
        }

        /* Header / Brand */
        .brand-centered {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-logo-text img {
            height: 60px;
            position: relative;
            top: -3px;
            /* Naikkan logo sebesar 3px */
            vertical-align: middle;
        }


        .brand-logo-text h2 {
            display: inline-block;
            margin: 0 0 0 8px;
            color: var(--primary);
            font-size: 32px;
            font-weight: 700;
            vertical-align: middle;
        }

        .brand-code {
            font-size: 14px;
            color: #6b7280;
            font-family: DejaVu Sans Mono, monospace;
            margin-top: 6px;
        }

        /* Konten utama */
        .cert-title {
            text-align: center;
            margin: 16px 0 0;
            font-size: 26px;
            font-weight: 700;
            color: #374151;
            letter-spacing: 1px;
        }

        .sub {
            text-align: center;
            margin: 4px 0 16px;
            font-size: 14px;
            color: #6b7280;
        }

        .name {
            text-align: center;
            font-size: 40px;
            font-weight: 800;
            color: #111827;
            margin: 12px 0;
            line-height: 1.2;
        }

        .desc {
            text-align: center;
            color: #374151;
            font-size: 16px;
            margin-bottom: 8px;
            margin-top: 20px;
        }

        .course {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .muted {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        /* Tanda tangan di tengah bawah */
        .signers {
            position: absolute;
            bottom: 80px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .sign {
            display: inline-block;
            text-align: center;
        }

        .sign img {
            height: 85px;
            margin-bottom: 5px;
            filter: contrast(125%) brightness(90%) drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.4));
            -webkit-filter: contrast(125%) brightness(90%) drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.4));
        }


        .sign .line {
            width: 200px;
            height: 1px;
            background: #cbd5e1;
            margin: 8px auto 6px;
        }

        .sign .name {
            font-size: 13px;
            font-weight: 700;
            margin: 0;
            color: #1f2937;
        }

        .sign .role {
            font-size: 11px;
            color: #6b7280;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            z-index: -1;
            opacity: 0.05;
        }

        .watermark img {
            width: 450px;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
    <title>Sertifikat BelajarSiko</title>
</head>

<body>
    <div class="frame">
        <div class="frame-inner">

            <!-- Watermark -->
            <div class="watermark">
                <img src="{{ public_path('images/logo-sbu.svg') }}" alt="Watermark" />
            </div>

            <!-- Brand -->
            <div class="brand-centered">
                <div class="brand-logo-text">
                    <img src="{{ public_path('images/logo-sbu.svg') }}" alt="BelajarSiko" />
                    <h2>BelajarSiko</h2>
                </div>
                <div class="brand-code">Kode: {{ $certificate->unique_code }}</div>
            </div>

            <!-- Isi utama -->
            <div class="cert-title">SERTIFIKAT PENYELESAIAN</div>
            <div class="sub">DIBERIKAN KEPADA</div>
            <div class="name">{{ strtoupper($user->name) }}</div>
            <div class="desc">Telah berhasil menyelesaikan dan lulus dari kursus:</div>
            <div class="course">{{ $course->title }}</div>
            <div class="muted">Diterbitkan pada {{ $certificate->generated_at->isoFormat('D MMMM YYYY') }}</div>

            <!-- TTD Tengah -->
            <div class="signers">
                <div class="sign">
                    @if (!empty($directorSignaturePath) && file_exists($directorSignaturePath))
                        <img src="{{ $directorSignaturePath }}" alt="Tanda tangan Director" />
                    @else
                        <div style="height:65px"></div>
                    @endif
                    <div class="line"></div>
                    <div class="name">{{ $directorName }}</div>
                    <div class="role">Director of BelajarSiko</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                Sertifikat ini diterbitkan secara digital oleh BelajarSiko.<br>
                Verifikasi di belajarsiko.my.id/verify/{{ $certificate->unique_code }}
            </div>

        </div>
    </div>
</body>

</html>
