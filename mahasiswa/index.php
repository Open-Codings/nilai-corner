<?php 
	include '../connection.php';

	// mendapatkan data mahasiswa
	$sql = ociparse($conn, "SELECT * FROM mahasiswa");
	oci_execute($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Mahasiswa</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Daftar Mahasiswa</h3><br>
	<a class="btn btn-danger" href="../index.php">Kembali</a>
	<a class="btn btn-primary" href="./create.php">Tambah</a>
	<br><br>
	<table style="width:50vw">
		<thead>
			<tr>
				<th class="border">No.</th>
				<th class="border">NRP</th>
				<th class="border">Nama</th>
				<th class="border">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0; ?>
			<?php while ($row = oci_fetch_array($sql)) :?>
			<tr>
				<td class="border"><?= ++$i ?></td>
				<td class="border"><?= $row["MAHASISWA_NRP"] ?></td>
				<td class="border"><?= $row["MAHASISWA_NAMA"] ?></td>
				<td class="border">
					<a href="./detail.php?mahasiswa=<?= $row['MAHASISWA_ID'] ?>"> Detail </a>
					<span>.</span>
					<a href="./update.php?mahasiswa=<?= $row['MAHASISWA_ID'] ?>"> Ubah </a>
					<span>.</span>
					<a href="./delete.php?mahasiswa=<?= $row['MAHASISWA_ID'] ?>"> Hapus </a>
				</td class="border">
			</tr>
			<?php endwhile ?>
		</tbody>
	</table>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>