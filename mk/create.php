<?php 
	include "../connection.php";

	if (isset($_POST["submit"])) {
		// mendapatkan data dari form post
		$mId = rand(100, 10000);
		$mNama = $_POST["mata_kuliah_nama"];
		$mDes = $_POST["mata_kuliah_deskripsi"];

		// insert data
		$sql = ociparse($conn, "declare begin p_mata_kuliah($mId, '$mNama', '$mDes', 'insert'); end;");
		ociexecute($sql);

		// kondisi ketika berhasil dan redirect
		if (oci_num_rows($sql) > 0) {
			echo "
				<script>alert('mata kuliah berhasil ditambahkan');
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
	<title>Tambah Mata Kuliah</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Tambah Mata Kuliah</h3>
	<br>
	<form style="width:30vw" method="POST">
		<div class="row">
			<label class="col" for="mata_kuliah_nama">Nama</label>
			<input class="col" type="text" name="mata_kuliah_nama" id="mata_kuliah_nama">
		</div>
		<br>
		<div class="row">
			<label class="col" for="mata_kuliah_deskripsi">Deskripsi</label>
			<input class="col" type="text" name="mata_kuliah_deskripsi" id="mata_kuliah_deskripsi">
		</div>
		<br>
		<button class="btn btn-primary" type="submit" name="submit">Simpan</button>
		<a class="btn btn-danger" href="./index.php">Batal</a>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>