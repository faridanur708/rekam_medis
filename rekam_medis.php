<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM rekam_medis WHERE id_rekam='$id'");
    header("Location: rekam_medis.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Rekam Medis</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --bg-body: #0f172a; --bg-card: #1e293b; --bg-hover: #334155; --accent-rose: #fb7185; --accent-blue: #38bdf8; --text-main: #f8fafc; --text-sub: #94a3b8; --border-color: rgba(255, 255, 255, 0.08); }
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); color: var(--text-main); padding: 28px; min-height: 100vh; }

        .navbar { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid var(--border-color); padding: 16px 28px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .brand { font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; gap: 8px; }
        .nav-links a { color: var(--text-sub); text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.25s ease; display: flex; align-items: center; gap: 8px; }
        .nav-links a:hover { color: var(--text-main); background: var(--bg-hover); }
        .nav-links a.active { color: #ffffff; background: linear-gradient(135deg, #e11d48, #fb7185); }

        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header-section h2 { font-size: 24px; font-weight: 800; }

        .btn-add { background: linear-gradient(135deg, #e11d48, #fb7185); color: white; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; }
        .card-table { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 14px; color: var(--text-sub); font-size: 12px; text-transform: uppercase; border-bottom: 1px solid var(--border-color); }
        td { padding: 14px; font-size: 13px; border-bottom: 1px solid var(--border-color); }

        .badge-date { background: rgba(56, 189, 248, 0.1); color: var(--accent-blue); padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 12px; }
        .btn-delete { color: var(--accent-rose); background: rgba(251, 113, 133, 0.1); padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; }

        .swal2-popup { background: #1e293b !important; color: #f8fafc !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.1) !important; }
        .swal2-title { color: #f8fafc !important; }
        .swal2-html-container { color: #94a3b8 !important; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-heart-pulse"></i> SIM-REKAM MEDIS</div>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="pasien.php"><i class="fa-solid fa-user-injured"></i> Pasien</a>
            <a href="dokter.php"><i class="fa-solid fa-user-md"></i> Dokter</a>
            <a href="obat.php"><i class="fa-solid fa-capsules"></i> Obat</a>
            <a href="rekam_medis.php" class="active"><i class="fa-solid fa-file-medical"></i> Rekam Medis</a>
        </div>
    </nav>

    <div class="header-section">
        <div>
            <h2>Riwayat Pemeriksaan Pasien</h2>
            <p style="color:var(--text-sub); font-size:14px;">Seluruh catatan rekam medis terdaftar (SQL JOIN)</p>
        </div>
        <a href="tambah_rekam.php" class="btn-add"><i class="fa-solid fa-plus"></i> Rekam Medis Baru</a>
    </div>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Periksa</th>
                    <th>Nama Pasien</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Obat</th>
                    <th>Resep</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query_sql = "SELECT 
                                rekam_medis.id_rekam,
                                rekam_medis.tanggal_periksa,
                                pasien.nama_pasien,
                                dokter.nama_dokter,
                                obat.nama_obat,
                                rekam_medis.keluhan,
                                rekam_medis.diagnosa,
                                rekam_medis.tindakan,
                                rekam_medis.resep
                              FROM rekam_medis
                              JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien
                              JOIN dokter ON rekam_medis.id_dokter = dokter.id_dokter
                              JOIN obat ON rekam_medis.id_obat = obat.id_obat
                              ORDER BY rekam_medis.id_rekam DESC";

                $query = mysqli_query($koneksi, $query_sql);

                while ($d = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge-date"><?= $d['tanggal_periksa']; ?></span></td>
                    <td><strong><?= $d['nama_pasien']; ?></strong></td>
                    <td><?= $d['nama_dokter']; ?></td>
                    <td><?= $d['keluhan']; ?></td>
                    <td><?= $d['diagnosa']; ?></td>
                    <td><?= $d['tindakan']; ?></td>
                    <td><span style="color:#fbbf24; font-weight:600"><?= $d['nama_obat']; ?></span></td>
                    <td><?= $d['resep']; ?></td>
                    <td>
                        <button class="btn-delete" onclick="konfirmasiHapus('rekam_medis.php?hapus=<?= $d['id_rekam']; ?>', '<?= $d['nama_pasien']; ?>')"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function konfirmasiHapus(urlHapus, nama) {
            Swal.fire({
                title: 'Hapus Rekam Medis?',
                text: "Rekam medis pasien '" + nama + "' akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fb7185',
                cancelButtonColor: '#334155',
                confirmButtonText: '<i class="fa-solid fa-trash"></i> Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlHapus;
                }
            });
        }
    </script>
</body>
</html>