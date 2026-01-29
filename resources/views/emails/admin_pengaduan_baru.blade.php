<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Baru Masuk</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        /* CARD UTAMA */
        .card {
            max-width: 650px;
            margin: auto;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }

        /* HEADER */
        .card-header {
            background: linear-gradient(135deg, #0B4EA2 0%, #5C6AC4 100%);
            color: #fff;
            padding: 25px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 22px;
            font-weight: 700;
        }
        .card-header span {
            font-size: 30px;
        }

        /* BODY */
        .card-body {
            padding: 25px 30px;
        }

        /* INFO TABLE */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 10px 0;
            vertical-align: middle;
        }
        .info-table td.label {
            font-weight: 700;
            color: #64748b;
            width: 140px;
        }
        .info-table td.value {
            font-weight: 600;
            color: #1e293b;
        }

        /* BADGE STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
        }
        .status-pending { background: #fff8e6; color: #d97706; border: 1px solid #fef3c7; }
        .status-diproses { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-selesai { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

        /* DESKRIPSI */
        .desc-box {
            background: #f8fafc;
            border-radius: 15px;
            padding: 15px;
            border: 1px solid #e2e8f0;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 20px;
        }

        /* CTA BUTTON */
        .btn-login {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, #0B4EA2, #5C6AC4);
            color: #fff;
            padding: 14px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            margin: 15px 0;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(11,78,162,0.3);
        }

        /* FOOTER */
        .footer {
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
            margin-top: 25px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        /* RESPONSIVE */
        @media(max-width: 480px){
            .card { padding: 0; border-radius: 15px; }
            .card-header { font-size: 20px; padding: 20px; }
            .card-header span { font-size: 26px; }
            .card-body { padding: 20px; }
            .btn-login { font-size: 14px; padding: 12px 20px; }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <span>📩</span> Pengaduan Baru Masuk
        </div>

        <div class="card-body">
            <table class="info-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">{{ $pengaduan->nama_mahasiswa }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">{{ $pengaduan->email }}</td>
                </tr>
                <tr>
                    <td class="label">Judul</td>
                    <td class="value">{{ $pengaduan->judul }}</td>
                </tr>
                <tr>
                    <td class="label">No Tiket</td>
                    <td class="value">#{{ $pengaduan->nomor_tiket }}</td>
                </tr>
                <tr>
                    <td class="label">Status Awal</td>
                    <td class="value">
                        @php
                            $statusClass = match($pengaduan->status){
                                'pending' => 'status-pending',
                                'diproses' => 'status-diproses',
                                'selesai' => 'status-selesai',
                                default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="desc-box">
                <strong>Catatan / Deskripsi:</strong><br>
                {{ $pengaduan->deskripsi }}
            </div>

            <a href="{{ route('admin.login') }}" class="btn-login">Login Admin untuk Menindaklanjuti</a>
        </div>

        <div class="footer">
            Sistem Pengaduan UMB &bull; &copy; {{ date('Y') }}
        </div>
    </div>

</body>
</html>
