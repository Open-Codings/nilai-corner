<?php 
	$conn = oci_connect("SKYE", "nevergone");
	if (!$conn) echo "[failed] can not connect to database";
	error_reporting(0);	
?>