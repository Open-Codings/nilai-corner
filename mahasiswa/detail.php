<?php 
	include "../connection.php";

	$id = $_GET["mahasiswa"];

	$sql = ociparse($conn, "SELECT * FROM mahasiswa WHERE mahasiswa_id=" . $id);
	oci_execute($sql);
	$row = oci_fetch_array($sql);

	$sql2 = ociparse($conn, "
		SELECT mmk.mahasiswa_mata_kuliah_id, mk.mata_kuliah_id, mk.mata_kuliah_nama, mk.mata_kuliah_deskripsi, mn.mahasiswa_nilai_nilai
            FROM mata_kuliah mk JOIN mahasiswa_mata_kuliah mmk
                ON mk.mata_kuliah_id = mmk.mahasiswa_mata_kuliah_mata_kuliah_id 
            LEFT JOIN mahasiswa_nilai mn
                ON mk.mata_kuliah_id = mn.mahasiswa_nilai_mata_kuliah_id 
                	AND mmk.mahasiswa_mata_kuliah_mahasiswa_id = mn.mahasiswa_nilai_mahasiswa_id
		WHERE mmk.mahasiswa_mata_kuliah_mahasiswa_id=" . $id);
	ociexecute($sql2);

	$sql3 = ociparse($conn, "SELECT * FROM mata_kuliah");
	ociexecute($sql3);

	if (isset($_POST["add-mk-submit"])) {
		$mkId = $_POST["add-mk-id"];

		$randId = rand(100, 10000);

		$add_mk_sql = ociparse($conn, "declare begin p_mahasiswa_mata_kuliah($randId, $id, $mkId, 'insert'); end;");
		ociexecute($add_mk_sql);

		if (oci_num_rows($add_mk_sql) > 0) {
			echo "
				<script>alert('mata kuliah berhasil ditambahkan');
					document.location.href = 'detail.php?mahasiswa=$id';
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
	<title>Detail Mahasiswa</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">
	<br>
	<h3>Detail Mahasiswa</h3>
	<div >
		<div style="width:30vw">
		<div class ="row">
			<span class="col">NRP</span>
			<span class="col">:</span>
			<span class="col-3"><?= $row["MAHASISWA_NRP"] ?></span>
		
		</div>
		<div class ="row">
			<span class="col">Nama</span>
			<span class="col">:</span>
			<span class="col-3"><?= $row["MAHASISWA_NAMA"] ?></span>
			
		</div>
		</div>
		<br>
		<form  method="POST">
			<span>Mata kuliah:</span>
			<select style="width:30vw" class="form-select" name="add-mk-id">	
				<?php while ($row = oci_fetch_array($sql3)) :?>
					<option value="<?= $row['MATA_KULIAH_ID'] ?>"><?= $row["MATA_KULIAH_NAMA"] ?></option>
				<?php endwhile ?>
			</select>
			<br>
			<a class="btn btn-danger" href="./index.php">Kembali</a>
			<button class="btn btn-primary" type="submit" name="add-mk-submit">Tambah MK</button>
		</form>
		<br>
		<table style="width:50vw">
			<thead>
				<tr >
					<th class="border" >No</th>
					<th class="border" >Nama</th>
					<th class="border" >Nilai</th>
					<th class="border" >Aksi</th>
				</tr>
				
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php while ($row = oci_fetch_array($sql2)) :?>
				<tr >
					<td class="border" ><?= ++$i ?></td>
					<td class="border" ><?= $row["MATA_KULIAH_NAMA"] ?></td>
					<td class="border" ><?= $row["MAHASISWA_NILAI_NILAI"] ?></td>
					<td class="border" >
						<a href="./in-score.php?mahasiswa=<?= $id ?>&mata_kuliah=<?= $row['MATA_KULIAH_ID'] ?>">Score</a>
						<a href="./mk-delete.php?mahasiswa=<?= $id ?>&mata_kuliah=<?= $row['MATA_KULIAH_ID'] ?>">Delete</a>
					</td>
				</tr>
				<?php endwhile ?>
			</tbody>
		</table>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>