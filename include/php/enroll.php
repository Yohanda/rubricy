<?php
include "conn.php";
session_start();

$sql = "select * from tb_rubrik where id_rubrik=".$_POST['id_rubrik'];



//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$row = sqlsrv_fetch_array($stmt);

if($row['enrollment_key'] != $_POST['enroll_input']){
	echo '0';
} else {

$sql = "INSERT INTO [dbo].[tb_join]
           ([id_rubrik]
           ,[id_user])
     VALUES
           (".$_POST['id_rubrik']."
           ,".$_SESSION['id_user'].")";



//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
echo '1';
}
?>