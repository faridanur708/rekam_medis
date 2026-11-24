<?php
include 'koneksi.php';

// Hitung Agregat Data
$q_pasien = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pasien");
$d_pasien = mysqli_fetch_assoc($q_pasien);

$q_dokter = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM dokter");
$d_dokter = mysqli_fetch_assoc($q_dokter);

$q_obat   = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM obat");
$d_obat   = mysqli_fetch_assoc($q_obat);

$q_rekam  = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM rekam_medis");
$d_rekam  = mysqli_fetch_assoc($q_rekam);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rekam Medis</title>
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-hover: #334155;
            --accent-blue: #38bdf8;
            --accent-green: #34d399;
            --accent-amber: #fbbf24;
            --accent-rose: #fb7185;
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 28px;
            min-height: 100vh;
        }

        /* Top Navigation Header */
        .navbar {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            padding: 16px 28px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .brand {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-sub);
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a:hover {
            color: var(--text-main);
            background: var(--bg-hover);
        }

        .nav-links a.active {
            color: #ffffff;
            background: linear-gradient(135deg, #0284c7, #2563eb);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        /* Header Title */
        .header-title {
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-title p {
            color: var(--text-sub);
            font-size: 14px;
            margin-top: 4px;
        }

        .btn-quick-add {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: transform 0.2s;
        }

        .btn-quick-add:hover {
            transform: translateY(-2px);
        }

        /* Stats Grid */
        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        /* Card Link Wrapper Agar Kartu Bisa Ditekan */
        .stat-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            border-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        }

        .stat-card:active {
            transform: translateY(-2px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .card-pasien::before { background: linear-gradient(90deg, #38bdf8, #0284c7); }
        .card-dokter::before { background: linear-gradient(90deg, #34d399, #059669); }
        .card-obat::before   { background: linear-gradient(90deg, #fbbf24, #d97706); }
        .card-rekam::before  { background: linear-gradient(90deg, #fb7185, #e11d48); }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-title {
            color: var(--text-sub);
            font-size: 14px;
            font-weight: 600;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(255, 255, 255, 0.05);
            transition: transform 0.2s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }

        .card-pasien .stat-icon { color: var(--accent-blue); }
        .card-dokter .stat-icon { color: var(--accent-green); }
        .card-obat .stat-icon   { color: var(--accent-amber); }
        .card-rekam .stat-icon  { color: var(--accent-rose); }

        .stat-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
        }

        /* Recent Activity Table Preview */
        .section-table {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 700;
        }

        .section-header a {
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            color: var(--text-sub);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge-date {
            background: rgba(56, 189, 248, 0.1);
            color: var(--accent-blue);
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar">
        <div class="brand">
            <i class="fa-solid fa-heart-pulse"></i> SIM-REKAM MEDIS
        </div>
        <div class="nav-links">
            <a href="index.php" class="active">Dashboard</a>
            <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Pasien</a>
            <a href="dokter.php"><i class="fa-solid fa-user-md"></i> Dokter</a>
            <a href="obat.php"><i class="fa-solid fa-capsules"></i> Obat</a>
            <a href="rekam_medis.php"><i class="fa-solid fa-file-medical"></i> Rekam Medis</a>
        </div>
    </nav>

    <!-- Header Title Area -->
    <div class="header-title">
        <div>
            <h1>Ringkasan Eksekutif</h1>
            <p>Sistem Pengelolaan Rekam Medis Terpadu SMK Negeri 3 Tuban</p>
        </div>
        <a href="tambah_rekam.php" class="btn-quick-add">
            <i class="fa-solid fa-plus"></i> Rekam Medis Baru
        </a>
    </div>

    <!-- Stats Cards Grid (Dapat Ditekan / Clickable) -->
    <div class="grid-stats">
        <!-- Kartu Pasien (Klik -> pasien.php) -->
        <a href="pasien.php" class="stat-card-link">
            <div class="stat-card card-pasien">
                <div class="stat-header">
                    <span class="stat-title">Total Pasien Terdaftar</span>
                    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                </div>
                <div class="stat-value"><?= $d_pasien['total']; ?></div>
            </div>
        </a>

        <!-- Kartu Dokter (Klik -> dokter.php) -->
        <a href="dokter.php" class="stat-card-link">
            <div class="stat-card card-dokter">
                <div class="stat-header">
                    <span class="stat-title">Dokter Aktif</span>
                    <div class="stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
                </div>
                <div class="stat-value"><?= $d_dokter['total']; ?></div>
            </div>
        </a>

        <!-- Kartu Obat (Klik -> obat.php) -->
        <a href="obat.php" class="stat-card-link">
            <div class="stat-card card-obat">
                <div class="stat-header">
                    <span class="stat-title">Jenis Obat Available</span>
                    <div class="stat-icon"><i class="fa-solid fa-pills"></i></div>
                </div>
                <div class="stat-value"><?= $d_obat['total']; ?></div>
            </div>
        </a>

        <!-- Kartu Rekam Medis (Klik -> rekam_medis.php) -->
        <a href="rekam_medis.php" class="stat-card-link">
            <div class="stat-card card-rekam">
                <div class="stat-header">
                    <span class="stat-title">Total Transaksi Medis</span>
                    <div class="stat-icon"><i class="fa-solid fa-notes-medical"></i></div>
                </div>
                <div class="stat-value"><?= $d_rekam['total']; ?></div>
            </div>
        </a>
    </div>

    <!-- Preview Tabel Rekam Medis Terakhir -->
    <div class="section-table">
        <div class="section-header">
            <h3>Pemeriksaan Medis Terbaru</h3>
            <a href="rekam_medis.php">Lihat Semua Data <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Diagnosa Ringkas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q_preview = mysqli_query($koneksi, "SELECT rekam_medis.tanggal_periksa, pasien.nama_pasien, dokter.nama_dokter, rekam_medis.diagnosa 
                                                     FROM rekam_medis 
                                                     JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien 
                                                     JOIN dokter ON rekam_medis.id_dokter = dokter.id_dokter 
                                                     ORDER BY rekam_medis.id_rekam DESC LIMIT 3");
                if (mysqli_num_rows($q_preview) > 0) {
                    while ($r = mysqli_fetch_assoc($q_preview)) {
                        echo "<tr>
                                <td><span class='badge-date'>".$r['tanggal_periksa']."</span></td>
                                <td><strong>".$r['nama_pasien']."</strong></td>
                                <td>".$r['nama_dokter']."</td>
                                <td>".$r['diagnosa']."</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center; color: var(--text-sub);'>Belum ada transaksi rekam medis recorded.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>