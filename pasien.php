<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $no_rm        =$_POST['no_rm'];
    $nama_pasien  =$_POST['nama_pasien'];
    $jenis_kelamin =$_POST['jenis_kelamin'];
    $tanggal_lahir =$_POST['tanggal_lahir'];
    $alamat       =$_POST['alamat'];

    mysqli_query($koneksi, "INSERT INTO pasien VALUES(NULL, '$no_rm', '$nama_pasien', '$jenis_kelamin', '$tanggal_lahir', '$alamat')");
    header("Location: pasien.php");
}

if (isset($_POST['update'])) {
    $id_pasien    =$_POST['id_pasien'];
    $no_rm        =$_POST['no_rm'];
    $nama_pasien  =$_POST['nama_pasien'];
    $jenis_kelamin =$_POST['jenis_kelamin'];
    $tanggal_lahir =$_POST['tanggal_lahir'];
    $alamat       =$_POST['alamat'];

    mysqli_query($koneksi, "UPDATE pasien SET no_rm='$no_rm', nama_pasien='$nama_pasien', jenis_kelamin='$jenis_kelamin', tanggal_lahir='$tanggal_lahir', alamat='$alamat' WHERE id_pasien='$id_pasien'");
    header("Location: pasien.php");
}

if (isset($_GET['hapus'])) {
    $id =$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pasien WHERE id_pasien='$id'");
    header("Location: pasien.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Rekam Medis</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --bg-body: #0f172a; --bg-card: #1e293b; --bg-hover: #334155; --accent-blue: #38bdf8; --accent-rose: #fb7185; --text-main: #f8fafc; --text-sub: #94a3b8; --border-color: rgba(255, 255, 255, 0.08); }
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); color: var(--text-main); padding: 28px; min-height: 100vh; }

        .navbar { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid var(--border-color); padding: 16px 28px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .brand { font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; gap: 8px; }
        .nav-links a { color: var(--text-sub); text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.25s ease; display: flex; align-items: center; gap: 8px; }
        .nav-links a:hover { color: var(--text-main); background: var(--bg-hover); }
        .nav-links a.active { color: #ffffff; background: linear-gradient(135deg, #0284c7, #2563eb); }

        .grid-container { display: grid; grid-template-columns: 350px 1fr; gap: 24px; }
        .card-panel { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px; }
        .card-panel h3 { font-size: 18px; margin-bottom: 20px; color: var(--accent-blue); display: flex; align-items: center; gap: 8px; }

        label { display: block; font-size: 13px; font-weight: 600; color: var(--text-sub); margin-bottom: 6px; }
        input, select, textarea { width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; outline: none; }
        
        .btn-submit { width: 100%; background: linear-gradient(135deg, #0284c7, #2563eb); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 16px; color: var(--text-sub); font-size: 12px; text-transform: uppercase; border-bottom: 1px solid var(--border-color); }
        td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid var(--border-color); }

        .btn-edit { color: var(--accent-blue); background: rgba(56, 189, 248, 0.1); padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; margin-right: 5px; border: none; cursor: pointer; }
        .btn-delete { color: var(--accent-rose); background: rgba(251, 113, 133, 0.1); padding: 6px 12px; border-radius: 8px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; }

        /* Custom SweetAlert Dark */
        .swal2-popup { background: #1e293b !important; color: #f8fafc !important; border-radius: 20px !important; border: 1px solid rgba(255,255,255,0.1) !important; }
        .swal2-title { color: #f8fafc !important; }
        .swal2-html-container { color: #94a3b8 !important; }

        /* MODAL EDIT MENGAMBANG */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(8px); display: none; justify-content: center; align-items: center; z-index: 999; }
        .modal-box { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 32px; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-close { background: none; border: none; color: var(--text-sub); font-size: 20px; cursor: pointer; }
        .btn-group-modal { display: flex; gap: 10px; margin-top: 10px; }
        .btn-cancel { flex: 1; background: #334155; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fa-solid fa-heart-pulse"></i> SIM-REKAM MEDIS</div>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="pasien.php" class="active"><i class="fa-solid fa-user-injured"></i> Pasien</a>
            <a href="dokter.php"><i class="fa-solid fa-user-md"></i> Dokter</a>
            <a href="obat.php"><i class="fa-solid fa-capsules"></i> Obat</a>
            <a href="rekam_medis.php"><i class="fa-solid fa-file-medical"></i> Rekam Medis</a>
        </div>
    </nav>

    <div class="grid-container">
        <div class="card-panel">
            <h3><i class="fa-solid fa-user-plus"></i> Tambah Pasien</h3>
            <form method="POST">
                <label>No. RM</label>
                <input type="text" name="no_rm" placeholder="RM-001" required>
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" placeholder="Nama Pasien" required>
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>
                <label>Alamat Pasien</label>
                <textarea name="alamat" rows="3" required></textarea>
                <button type="submit" name="tambah" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Data Pasien</button>
            </form>
        </div>

        <div class="card-panel">
            <h3><i class="fa-solid fa-users"></i> Daftar Pasien Terdaftar</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>JK</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id_pasien DESC");
                    while ($d = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong style="color:var(--accent-blue)"><?= $d['no_rm']; ?></strong></td>
                        <td><?= $d['nama_pasien']; ?></td>
                        <td><?= $d['jenis_kelamin']; ?></td>
                        <td><?= $d['tanggal_lahir']; ?></td>
                        <td><?= $d['alamat']; ?></td>
                        <td>
                            <button class="btn-edit" onclick="openModalPasien('<?= $d['id_pasien']; ?>', '<?=$d['no_rm']; ?>', '<?= $d['nama_pasien']; ?>', '<?=$d['jenis_kelamin']; ?>', '<?= $d['tanggal_lahir']; ?>', '<?= htmlspecialchars($d['alamat'], ENT_QUOTES); ?>')"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                            <button class="btn-delete" onclick="konfirmasiHapus('pasien.php?hapus=<?= $d['id_pasien']; ?>', '<?=$d['nama_pasien']; ?>')"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDIT PASIEN -->
    <div class="modal-overlay" id="modalPasien">
        <div class="modal-box">
            <div class="modal-header">
                <h3 style="color:var(--accent-blue)"><i class="fa-solid fa-pen-to-square"></i> Edit Data Pasien</h3>
                <button class="btn-close" onclick="closeModalPasien()">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="id_pasien" id="edit_id_pasien">
                <label>No. RM</label>
                <input type="text" name="no_rm" id="edit_no_rm" required>
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" id="edit_nama_pasien" required>
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" id="edit_jk" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="edit_tgl" required>
                <label>Alamat</label>
                <textarea name="alamat" id="edit_alamat" rows="3" required></textarea>

                <div class="btn-group-modal">
                    <button type="button" class="btn-cancel" onclick="closeModalPasien()">Batal</button>
                    <button type="submit" name="update" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Update Pasien</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalPasien(id, norm, nama, jk, tgl, alamat) {
            document.getElementById('edit_id_pasien').value = id;
            document.getElementById('edit_no_rm').value = norm;
            document.getElementById('edit_nama_pasien').value = nama;
            document.getElementById('edit_jk').value = jk;
            document.getElementById('edit_tgl').value = tgl;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('modalPasien').style.display = 'flex';
        }

        function closeModalPasien() {
            document.getElementById('modalPasien').style.display = 'none';
        }

        // KONFIRMASI HAPUS SWEETALERT2
        function konfirmasiHapus(urlHapus, nama) {
            Swal.fire({
                title: 'Hapus Pasien?',
                text: "Data pasien '" + nama + "' akan dihapus permanen!",
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