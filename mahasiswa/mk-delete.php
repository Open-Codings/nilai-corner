<?php 
	include "../connection.php";

	$mId = $_GET["mahasiswa"];
	$mkId = $_GET["mata_kuliah"];

	$sql = ociparse($conn, "
		declare begin 
			p_mahasiswa_mata_kuliah('', $mId, $mkId, 'delete'); 
			p_mahasiswa_nilai('', $mId, $mkId, '', 'delete'); 
		end;");
	oci_execute($sql);

	if (oci_num_rows($sql) > 0) {
		echo "
			<script>alert('mata kuliah berhasil dihapus');
				document.location.href = 'detail.php?mahasiswa=$mId';
			</script>
		";
	}
?>
<a href="./index.php">Kembali</a>