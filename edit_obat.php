<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $nama_obat = $_POST['nama_obat'];
    $satuan    = $_POST['satuan'];
    $stok      = $_POST['stok'];

    mysqli_query($koneksi, "UPDATE obat SET nama_obat='$nama_obat', satuan='$satuan', stok='$stok' WHERE id_obat='$id'");
    header("Location: obat.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Obat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --bg-body: #0f172a; --bg-card: #1e293b; --accent-amber: #fbbf24; --text-main: #f8fafc; --text-sub: #94a3b8; --border-color: rgba(255, 255, 255, 0.08); }
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); color: var(--text-main); padding: 28px; min-height: 100vh; }
        .form-card { max-width: 500px; margin: 40px auto; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 32px; }
        .form-card h2 { font-size: 20px; color: var(--accent-amber); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        label { display: block; font-size: 13px; font-weight: 600; color: var(--text-sub); margin-bottom: 6px; }
        input { width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; outline: none; }
        .btn-group { display: flex; gap: 10px; }
        .btn-update { flex: 1; background: linear-gradient(135deg, #d97706, #f59e0b); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; }
        .btn-cancel { background: #334155; color: white; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Data Obat</h2>
        <form method="POST">
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" value="<?= $data['nama_obat']; ?>" required>
            <label>Satuan</label>
            <input type="text" name="satuan" value="<?= $data['satuan']; ?>" required>
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
            <div class="btn-group">
                <a href="obat.php" class="btn-cancel">Batal</a>
                <button type="submit" name="update" class="btn-update"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>