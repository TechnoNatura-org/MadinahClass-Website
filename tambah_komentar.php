<!-- By: ©2020 Arsa Satria, https://arsasatria.my.id/ -->

<?php
session_start();
include 'koneksi.php';
include 'csrf.php';
 
$nama_pengirim = $_POST["nama_pengirim"];
$komen = $_POST["komen"];
$komen_id = $_POST["komentar_id"];
 
$query = "INSERT INTO chat7m (parent_komentar_id, komentar, nama_pengirim) VALUES (?, ?, ?)";
$dewan1 = $db1->prepare($query);
$dewan1->bind_param("sss", $komen_id, $komen, $nama_pengirim);
$dewan1->execute();
 
echo json_encode(['success' => 'Sukses']);
?>