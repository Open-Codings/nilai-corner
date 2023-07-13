<?php 
	include "../connection.php";

	$id = $_GET["mahasiswa"];

	// mendapatkan data mahasiswa
	$sql = ociparse($conn, "SELECT * FROM mahasiswa WHERE mahasiswa_id=" . $id);
	oci_execute($sql);
	$row = oci_fetch_array($sql);

	if (isset($_POST["submit"])) {
		// mengambil data dari post
		$mId = $_POST["mahasiswa_id"];
		$mNrp = $_POST["mahasiswa_nrp"];
		$mNama = $_POST["mahasiswa_nama"];

		$sql = ociparse($conn, "declare begin p_mahasiswa($mId, '$mNrp', '$mNama', 'update'); end;");
		ociexecute($sql);

		// kondisi ketika berhasil dan redirect
		if (oci_num_rows($sql) > 0) {
			echo "
				<script>alert('mahasiswa berhasil diubah');
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
	<title>Ubah Mahasiswa</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Ubah Mahasiswa</h3>
	<br>
	<form style="width:30vw" method="POST">
		<input type="hidden" name="mahasiswa_id" value="<?= $row['MAHASISWA_ID'] ?>">
		<div class="row">
			<label class="col" for="mahasiswa_nrp">NRP</label>
			<input class="col" type="text" name="mahasiswa_nrp" id="mahasiswa_nrp" value="<?= $row['MAHASISWA_NRP'] ?>">
		</div>
		<br>
		<div class="row">
			<label class="col" for="mahasiswa_nama">Nama</label>
			<input class="col" type="text" name="mahasiswa_nama" id="mahasiswa_nama" value="<?= $row['MAHASISWA_NAMA'] ?>">
		</div>
		<br>
		<button class="btn btn-primary" type="submit" name="submit">Ubah</button>
		<a class="btn btn-danger" href="./index.php">Batal</a>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>