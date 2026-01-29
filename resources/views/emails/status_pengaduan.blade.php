<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengaduan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            max-width: 600px;
            margin: auto;
            padding: 30px 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #0B4EA2, #5C6AC4);
            padding: 20px 25px;
            border-radius: 15px;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
        }
        .header span {
            font-size: 28px;
        }

        /* BODY */
        .body {
            margin-top: 20px;
            color: #1e293b;
            font-size: 15px;
            line-height: 1.6;
        }
        .body p {
            margin: 10px 0;
        }
        .body strong {
            color: #0B4EA2;
        }

        /* BADGE STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
        }
        .status-pending { background: #fff8e6; color: #d97706; border: 1px solid #fef3c7; }
        .status-diproses { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-selesai { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

        /* CTA BUTTON */
        .btn-detail {
            display: inline-block;
            margin-top: 25px;
            background: linear-gradient(135deg, #0B4EA2, #5C6AC4);
            color: #fff;
            padding: 14px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(11,78,162,0.3);
        }

        /* FOOTER */
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        /* RESPONSIVE */
        @media(max-width: 480px){
            .card { padding: 20px 15px; border-radius: 15px; }
            .header { font-size: 18px; padding: 15px; border-radius: 12px; }
            .header span { font-size: 24px; }
            .btn-detail { padding: 12px 20px; font-size: 14px; }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="header">
            <span>📬</span>
            Status Pengaduan Telah Diperbarui
        </div>

        <div class="body">
            <p>Halo <strong>{{ $pengaduan->nama_mahasiswa }}</strong>,</p>
            <p>Status pengaduan Anda dengan nomor tiket <strong>#{{ $pengaduan->nomor_tiket }}</strong> telah diperbarui.</p>
            <p><strong>Judul Laporan:</strong> {{ $pengaduan->judul }}</p>
            <p>Status saat ini:</p>
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

            <p>Silakan klik tombol di bawah untuk melihat detail lengkap pengaduan Anda.</p>

            <a href="{{ route('admin.login') }}" class="btn-detail">Lihat Detail Pengaduan</a>
        </div>

        <div class="footer">
            <p>Hormat kami,</p>
            <strong>Sistem Pengaduan UMB</strong>
        </div>
    </div>

</body>
</html>
