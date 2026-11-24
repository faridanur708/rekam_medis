<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $id_pasien      =$_POST['id_pasien'];
    $id_dokter      =$_POST['id_dokter'];
    $id_obat        =$_POST['id_obat'];
    $tanggal_periksa=$_POST['tanggal_periksa'];
    $keluhan        =$_POST['keluhan'];
    $diagnosa       =$_POST['diagnosa'];
    $tindakan       =$_POST['tindakan'];
    $resep          =$_POST['resep'];

    mysqli_query($koneksi, "INSERT INTO rekam_medis VALUES(NULL, '$id_pasien', '$id_dokter', '$id_obat', '$tanggal_periksa', '$keluhan', '$diagnosa', '$tindakan', '$resep')");
    header("Location: rekam_medis.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Rekam Medis Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-hover: #334155;
            --accent-blue: #38bdf8;
            --accent-rose: #fb7185;
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); color: var(--text-main); padding: 28px; min-height: 100vh; }

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

        .brand { font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; gap: 8px; }
        .nav-links a { color: var(--text-sub); text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.25s ease; display: flex; align-items: center; gap: 8px; }
        .nav-links a:hover { color: var(--text-main); background: var(--bg-hover); }
        .nav-links a.active { color: #ffffff; background: linear-gradient(135deg, #e11d48, #fb7185); }

        .form-card { max-width: 800px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 32px; }
        .form-card h2 { font-size: 22px; color: var(--accent-rose); margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .full-width { grid-column: span 2; }

        label { display: block; font-size: 13px; font-weight: 600; color: var(--text-sub); margin-bottom: 6px; }
        input, select, textarea { width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; outline: none; }
        input:focus, select:focus, textarea:focus { border-color: var(--accent-rose); }

        .btn-group { display: flex; gap: 12px; margin-top: 10px; }
        .btn-submit { flex: 1; background: linear-gradient(135deg, #e11d48, #fb7185); color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; cursor: pointer; }
        .btn-cancel { background: var(--bg-hover); color: var(--text-main); text-decoration: none; padding: 14px 24px; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-heart-pulse"></i> SIM-REKAM MEDIS</div>
        <div class="nav-links">
            <a href="index.php"><i class="fa-solid fa-grid-2"></i> Dashboard</a>
            <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Pasien</a>
            <a href="dokter.php"><i class="fa-solid fa-user-md"></i> Dokter</a>
            <a href="obat.php"><i class="fa-solid fa-capsules"></i> Obat</a>
            <a href="rekam_medis.php" class="active"><i class="fa-solid fa-file-medical"></i> Rekam Medis</a>
        </div>
    </nav>

    <div class="form-card">
        <h2><i class="fa-solid fa-notes-medical"></i> Input Catatan Pemeriksaan Medis</h2>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Pilih Pasien</label>
                    <select name="id_pasien" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php
                        $pasien = mysqli_query($koneksi, "SELECT * FROM pasien");
                        while ($p = mysqli_fetch_assoc($pasien)) {
                            echo "<option value='".$p['id_pasien']."'>".$p['no_rm']." - ".$p['nama_pasien']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label>Pilih Dokter Pemeriksa</label>
                    <select name="id_dokter" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php
                        $dokter = mysqli_query($koneksi, "SELECT * FROM dokter");
                        while ($d = mysqli_fetch_assoc($dokter)) {
                            echo "<option value='".$d['id_dokter']."'>".$d['nama_dokter']." (".$d['spesialisasi'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label>Pilih Obat Diberikan</label>
                    <select name="id_obat" required>
                        <option value="">-- Pilih Obat --</option>
                        <?php
                        $obat = mysqli_query($koneksi, "SELECT * FROM obat");
                        while ($o = mysqli_fetch_assoc($obat)) {
                            echo "<option value='".$o['id_obat']."'>".$o['nama_obat']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_periksa" required>
                </div>

                <div class="full-width">
                    <label>Keluhan Pasien</label>
                    <textarea name="keluhan" rows="2" placeholder="Keluhan yang dirasakan pasien" required></textarea>
                </div>

                <div class="full-width">
                    <label>Hasil Diagnosa</label>
                    <textarea name="diagnosa" rows="2" placeholder="Hasil analisa dokter" required></textarea>
                </div>

                <div class="full-width">
                    <label>Tindakan Medis</label>
                    <textarea name="tindakan" rows="2" placeholder="Tindakan yang diberikan" required></textarea>
                </div>

                <div class="full-width">
                    <label>Resep / Aturan Minum Obat</label>
                    <input type="text" name="resep" placeholder="Contoh: 3x1 tablet sesudah makan" required>
                </div>
            </div>

            <div class="btn-group">
                <a href="rekam_medis.php" class="btn-cancel">Batal</a>
                <button type="submit" name="simpan" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Transaksi Rekam Medis</button>
            </div>
        </form>
    </div>

</body>
</html>