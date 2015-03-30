<?php
include "conn.php";


$sql = "UPDATE [dbo].[tb_rubrik]
   SET [status_evaluasi] = 2
 WHERE id_rubrik=".$_POST['id_rubrik'];



//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
?>
