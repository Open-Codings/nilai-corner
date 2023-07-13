<?php 
	include "../connection.php";

	$id = $_GET["mata_kuliah"];

	// mendapatkan data mata kuliah
	$sql = ociparse($conn, "SELECT * FROM mata_kuliah WHERE mata_kuliah_id=" . $id);
	oci_execute($sql);
	$row = oci_fetch_array($sql);

	if (isset($_POST["submit"])) {
		// mendapatkan data dari form post
		$mId = $_POST["mata_kuliah_id"];
		$mNama = $_POST["mata_kuliah_nama"];
		$mDes = $_POST["mata_kuliah_deskripsi"];

		$sql = ociparse($conn, "declare begin p_mata_kuliah($mId, '$mNama', '$mDes', 'update'); end;");
		ociexecute($sql);

		// kondisi ketika berhasil dan redirect
		if (oci_num_rows($sql) > 0) {
			echo "
				<script>alert('mata kuliah berhasil diubah');
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
	<title>Ubah Mata Kuliah</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Ubah Mata Kuliah</h3>
	
	<form style="width:50vw" method="POST">
		<input type="hidden" name="mata_kuliah_id" value="<?= $id ?>">
		<div class="row">
			<label class="col" for="mata_kuliah_nama">Nama</label>
			<input class="col" type="text" name="mata_kuliah_nama" id="mata_kuliah_nama" value="<?= $row['MATA_KULIAH_NAMA'] ?>">
		</div>
		<br>
		<div class="row">
			<label class="col"  for="mata_kuliah_deskripsi">Deskripsi</label>
			<input class="col"  type="text" name="mata_kuliah_deskripsi" id="mata_kuliah_deskripsi" value="<?= $row['MATA_KULIAH_DESKRIPSI'] ?>">
		</div>
		<br>
		<button class="btn btn-primary" type="submit" name="submit">Ubah</button>
		<a class="btn btn-danger" href="./index.php">Batal</a>
	</form>
</body>
</html>