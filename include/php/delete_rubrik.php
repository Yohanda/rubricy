<?php
include "conn.php";

$sql = "delete from tb_deskripsi_bobot where id_rubrik=".$_POST['id_rubrik'].";";

$sql .= "delete from tb_komentar where id_rubrik=".$_POST['id_rubrik'].";";
 
$sql .= "delete from tb_bobot where id_rubrik=".$_POST['id_rubrik'].";";

$sql .= "delete from tb_kriteria where id_rubrik=".$_POST['id_rubrik'].";";

$sql .= "delete from tb_rubrik where id_rubrik=".$_POST['id_rubrik'].";";


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
echo $sql;
?>