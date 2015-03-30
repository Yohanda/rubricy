<?php
include "conn.php";
$data['id_row'] = 72;
$get_kriteria = "select * from tb_kriteria where id_rubrik =".$data['id_row']." ORDER BY id_kriteria ASC";



$stmt_get_kriteria = sqlsrv_query( $conn, $get_kriteria );
if( $stmt_get_kriteria === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$arr_kriteria;
$count = 0;
while ($row = sqlsrv_fetch_array($stmt_get_kriteria)) {
    $arr_kriteria[$count] = $row;
	$count++;
}


$get_bobot = "select * from tb_bobot where id_rubrik =".$data['id_row']." ORDER BY id_bobot ASC";



$stmt_get_bobot = sqlsrv_query( $conn, $get_bobot );
if( $stmt_get_bobot === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$arr_bobot;
$count = 0;
while ($row = sqlsrv_fetch_array($stmt_get_bobot)) {
    $arr_bobot[$count] = $row;
	$count++;
}

$_POST['deskripsi'] = "ac,bc;ds,df;";
$row_dekrip = explode(";",$_POST['deskripsi']);
$count_k =0;
$count_b =0;
$sql_dekrip = "";
for ($i = 0; $i < (sizeof($row_dekrip)-1); $i++) {
	$dekrip = explode(",",$row_dekrip[$i]);

	$count_b =0;
	for ($j = 0; $j < sizeof($dekrip); $j++) {
		$sql_dekrip .= "INSERT INTO [dbo].[tb_deskripsi_bobot]
           ([id_bobot]
           ,[id_kriteria]
           ,[deskripsi_bobot])
     VALUES
           (".$arr_bobot[$count_b]['id_bobot']."
           ,".$arr_kriteria[$count_k]['id_kriteria']."
           ,'".$dekrip[$j]."');";
		   $count_b++;
	echo $sql_dekrip."<br><br>";	 
	}
	$count_k++;
}

$stmt_dekrip = sqlsrv_query( $conn, $sql_dekrip );
if( $stmt_dekrip === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo 'Berhasil';


?>