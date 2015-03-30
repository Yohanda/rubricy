<?php
include "conn.php";

$sql = "delete from tb_nilai where id_rubrik = ".$_POST['id_rubrik']." AND id_user=".$_POST['id_user'].";";

$sql .= "delete from tb_komentar where id_rubrik = ".$_POST['id_rubrik']." AND id_user=".$_POST['id_rubrik'].";";
 
$sql .= "delete from tb_join where id_rubrik = ".$_POST['id_rubrik']." AND id_user=".$_POST['id_user'].";";

//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
echo $sql;
?>