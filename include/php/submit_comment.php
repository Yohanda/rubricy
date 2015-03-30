<?php
include "conn.php";
session_start();
$sql = "INSERT INTO [dbo].[tb_komentar]
           ([id_rubrik]
           ,[id_user]
           ,[isi_komentar])
     VALUES
           (".$_POST['id_rubrik']."
           ,".$_SESSION['id_user']."
           ,'".$_POST['comment']."')";


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
echo 'Berhasil';

?>