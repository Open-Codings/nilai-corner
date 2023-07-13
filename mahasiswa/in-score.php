<?php 
	include "../connection.php";

	$mid = $_GET["mahasiswa"];
	$mkid = $_GET["mata_kuliah"];

	// medapatkan data matakuliah dan nilai dari mata kuliah yang dipilih
	$sql = ociparse($conn, "
		SELECT m.mahasiswa_nama, mk.mata_kuliah_nama FROM mahasiswa_mata_kuliah mmk
		    JOIN mahasiswa m
		        ON mmk.mahasiswa_mata_kuliah_mahasiswa_id = m.mahasiswa_id
		    JOIN mata_kuliah mk
		        on mmk.mahasiswa_mata_kuliah_mata_kuliah_id = mk.mata_kuliah_id
		WHERE mmk.mahasiswa_mata_kuliah_mahasiswa_id=". $mid ." AND mmk.mahasiswa_mata_kuliah_mata_kuliah_id=". $mkid);
	oci_execute($sql);
	$row = oci_fetch_array($sql);

	// mendapatkan nilai dari mata kuliah yang dipilih
	$sql2 = ociparse($conn, "
		SELECT * FROM mahasiswa_nilai
		WHERE mahasiswa_nilai_mahasiswa_id=". $mid ." AND mahasiswa_nilai_mata_kuliah_id=". $mkid);
	oci_execute($sql2);
	$row2 = oci_fetch_array($sql2);

	if (isset($_POST["submit"])) {
		$nilai = $_POST["mk-nilai"];
		if ($row2) {
			// ketika nilai ada maka update
			$sql = ociparse($conn, "declare begin p_mahasiswa_nilai('', $mid, $mkid, $nilai, 'update'); end;");
			ociexecute($sql);

			if (oci_num_rows($sql) > 0) {
				echo "
					<script>alert('nilai berhasil diubah');
						document.location.href = 'detail.php?mahasiswa=$mid';
					</script>
				";
			}
		} else {
			// ketika tidak ada nilai maka insert
			$randId = rand(100, 10000);
			$sql = ociparse($conn, "declare begin p_mahasiswa_nilai($randId, $mid, $mkid, $nilai, 'insert'); end;");
			ociexecute($sql);

			if (oci_num_rows($sql) > 0) {
				echo "
					<script>alert('nilai berhasil ditambahkan');
						document.location.href = 'detail.php?mahasiswa=$mid';
					</script>
				";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<br>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Input Nilai</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<h3>Input Nilai <?= $row["MATA_KULIAH_NAMA"] ?> Untuk <?= $row["MAHASISWA_NAMA"] ?></h3>
	<form method="POST">
		<label for="mk-nilai">Nilai</label>
		<input class="input -number" type="number" name="mk-nilai" id="mk-nilai" value="<?= $row2['MAHASISWA_NILAI_NILAI'] ?>">
		<button class="btn btn-primary" type="submit" name="submit">Simpan</button>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>