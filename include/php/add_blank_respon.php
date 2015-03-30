<?php
include "conn.php";
session_start();
//echo "Rubrik Prop : ".$_POST['rubrik_prop']."<br>";
$prop = explode(",",$_POST['rubrik_prop']);



$sql = "INSERT INTO [dbo].[tb_rubrik]
           ([judul]
		   ,[enrollment_key]
		   ,[id_kategori]
           ,[deskripsi]
           ,[status_berbagi]
		   ,[id_user])
     VALUES (
	 		'".$prop[0]."'
           ,'".$prop[1]."'
           ,'".$prop[2]."'
           ,'".$prop[3]."'
		   ,'".$prop[4]."'
		   ,".$_SESSION['id_user']."
		   )";


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


//get current id
$sql = 'SELECT SCOPE_IDENTITY() as "id_row"';
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

$data = sqlsrv_fetch_array($stmt);

//echo $data['id_row']; 

$_SESSION['id_rubrik'] = $data['id_row'];



$bobot = explode(",",$_POST['bobot']);
$bobot_nilai = explode(",",$_POST['bobot_nilai']);
//echo "Bobot : ".$_POST['bobot']."<br>";
//echo "Bobot Nilai : ".$_POST['bobot_nilai']."<br>";
$sql_bobot ="";
for ($i = 0; $i < sizeof($bobot); $i++) {
$sql_bobot .= "INSERT INTO [dbo].[tb_bobot]
           ([id_rubrik]
           ,[nama_bobot]
           ,[nilai_bobot])
     VALUES
           (".$data['id_row']."
           ,'".$bobot[$i]."'
           ,".$bobot_nilai[$i].");";


}

$stmt = sqlsrv_query( $conn, $sql_bobot );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


//echo "Kriteria : ".$_POST['kriteria']."<br>";
//echo "Kriteria Persen : ".$_POST['kriteria_persen']."<br>";

$kriteria = explode(",",$_POST['kriteria']);
$kriteria_persen = explode(",",$_POST['kriteria_persen']);
//echo "Bobot : ".$_POST['bobot']."<br>";
//echo "Bobot Nilai : ".$_POST['bobot_nilai']."<br>";
$sql_kriteria ="";
for ($i = 0; $i < sizeof($kriteria); $i++) {
$sql_kriteria .= "INSERT INTO [dbo].[tb_kriteria]
           ([id_rubrik]
           ,[nama_kriteria]
           ,[persentase_kriteria])
     VALUES
           (".$data['id_row']."
           ,'".$kriteria[$i]."'
           ,".$kriteria_persen[$i].")";


}

$stmt = sqlsrv_query( $conn, $sql_kriteria );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


//echo "Deskripsi : ".$_POST['deskripsi']."<br>";
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
		   ,[id_rubrik]
           ,[deskripsi_bobot])
     VALUES
           (".$arr_bobot[$count_b]['id_bobot']."
           ,".$arr_kriteria[$count_k]['id_kriteria']."
		   ,".$data['id_row']."
           ,'".$dekrip[$j]."');";
		   $count_b++;
		 
	}
	$count_k++;
}

$stmt_dekrip = sqlsrv_query( $conn, $sql_dekrip );
if( $stmt_dekrip === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo $data['id_row'];

?>