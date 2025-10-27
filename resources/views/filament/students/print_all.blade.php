<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Siswa</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Daftar Siswa</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NPM</th>
                <th>Semester</th>
                <th>Kelas</th>
                <th>Program Studi</th>
                <th>Fakultas</th>
                <th>Universitas</th>
                <th>Nomor WA</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $i => $student)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->npm }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>{{ $student->kelas }}</td>
                    <td>{{ $student->program_studi }}</td>
                    <td>{{ $student->fakultas }}</td>
                    <td>{{ $student->universitas }}</td>
                    <td>{{ $student->wa_number }}</td>
                    <td>{{ $student->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
