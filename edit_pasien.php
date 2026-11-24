<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $no_rm        = $_POST['no_rm'];
    $nama_pasien  = $_POST['nama_pasien'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat       = $_POST['alamat'];

    mysqli_query($koneksi, "UPDATE pasien SET no_rm='$no_rm', nama_pasien='$nama_pasien', jenis_kelamin='$jenis_kelamin', tanggal_lahir='$tanggal_lahir', alamat='$alamat' WHERE id_pasien='$id'");
    header("Location: pasien.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pasien</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --bg-body: #0f172a; --bg-card: #1e293b; --accent-blue: #38bdf8; --text-main: #f8fafc; --text-sub: #94a3b8; --border-color: rgba(255, 255, 255, 0.08); }
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-body); color: var(--text-main); padding: 28px; min-height: 100vh; }
        .form-card { max-width: 550px; margin: 30px auto; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 32px; }
        .form-card h2 { font-size: 20px; color: var(--accent-blue); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        label { display: block; font-size: 13px; font-weight: 600; color: var(--text-sub); margin-bottom: 6px; }
        input, select, textarea { width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; outline: none; }
        .btn-group { display: flex; gap: 10px; }
        .btn-update { flex: 1; background: linear-gradient(135deg, #0284c7, #2563eb); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; }
        .btn-cancel { background: #334155; color: white; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2><i class="fa-solid fa-user-pen"></i> Edit Data Pasien</h2>
        <form method="POST">
            <label>No. RM</label>
            <input type="text" name="no_rm" value="<?= $data['no_rm']; ?>" required>
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" value="<?= $data['nama_pasien']; ?>" required>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="L" <?= $data['jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option>
                <option value="P" <?= $data['jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option>
            </select>
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir']; ?>" required>
            <label>Alamat</label>
            <textarea name="alamat" rows="3" required><?= $data['alamat']; ?></textarea>
            <div class="btn-group">
                <a href="pasien.php" class="btn-cancel">Batal</a>
                <button type="submit" name="update" class="btn-update"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>