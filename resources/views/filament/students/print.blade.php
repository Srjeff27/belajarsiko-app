<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Cetak Data Siswa - {{ $user->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .container { max-width: 800px; margin: 0 auto; padding: 24px; }
        h1 { font-size: 20px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        td { padding: 8px 6px; vertical-align: top; }
        tr + tr td { border-top: 1px solid #ddd; }
        .label { width: 200px; font-weight: bold; }
        .value { width: calc(100% - 200px); }
        .footer { margin-top: 28px; font-size: 11px; color: #666; }
    </style>
</head>
<body>
<div class="container">
    <h1>Data Siswa: {{ $user->name }}</h1>

    <table>
        <tbody>
            <tr>
                <td class="label">Nama</td>
                <td class="value">{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="label">NPM</td>
                <td class="value">{{ $user->npm }}</td>
            </tr>
            <tr>
                <td class="label">Semester</td>
                <td class="value">{{ $user->semester }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="value">{{ $user->kelas }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td class="value">{{ $user->program_studi }}</td>
            </tr>
            <tr>
                <td class="label">Fakultas</td>
                <td class="value">{{ $user->fakultas }}</td>
            </tr>
            <tr>
                <td class="label">Universitas</td>
                <td class="value">{{ $user->universitas }}</td>
            </tr>
            <tr>
                <td class="label">Nomor WA</td>
                <td class="value">{{ $user->wa_number }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="value">{{ $user->alamat }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">Dicetak pada: {{ now()->toDateTimeString() }}</div>
</div>
</body>
</html>