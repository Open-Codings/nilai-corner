<?php 
	include "../connection.php";

	if (isset($_POST["submit"])) {
		// mendapatkan data dari post
		$mId = rand(100, 10000);
		$mNrp = $_POST["mahasiswa_nrp"];
		$mNama = $_POST["mahasiswa_nama"];

		$sql = ociparse($conn, "declare begin p_mahasiswa($mId, '$mNrp', '$mNama', 'insert'); end;");
		ociexecute($sql);

		// kondisi ketika berhasil dan redirect
		if (oci_num_rows($sql) > 0) {
			echo "
				<script>alert('mahasiswa berhasil ditambahkan');
					document.location.href = 'index.php';
				</script>
			";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Mahasiswa</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Tambah Mahasiswa</h3>
	<form style="width:30vw" method="POST">
		<div class="row">
			<label class="col" for="mahasiswa_nrp">NRP</label>
			<input class="col" type="text" name="mahasiswa_nrp" id="mahasiswa_nrp">
		</div>
		<div class="row">
			<label class="col" for="mahasiswa_nama">Nama</label>
			<input class="col" type="text" name="mahasiswa_nama" id="mahasiswa_nama">
		</div>
		<br>
		<button class="btn btn-primary" type="submit" name="submit">Simpan</button>
		<a class="btn btn-danger" href="./index.php">Kembali</a>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>