<?php
include "conn.php";
session_start();
//echo "Rubrik Prop : ".$_POST['rubrik_prop']."<br>";
$prop = explode(",",$_POST['rubrik_prop']);



$sql = "UPDATE [dbo].[tb_rubrik]
   SET [judul] = '".$prop[0]."'
      ,[status_berbagi] = ".$prop[4]."
      ,[enrollment_key] = '".$prop[1]."'
      ,[deskripsi] = '".$prop[3]."'
      ,[id_kategori] = ".$prop[2]."
 WHERE id_rubrik = ".$_POST['id_rubrik'];
 


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$sql = "delete from tb_deskripsi_bobot where id_rubrik=".$_POST['id_rubrik'];
 


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}




$sql = "delete from tb_bobot where id_rubrik=".$_POST['id_rubrik'];
 


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}



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
           (".$_POST['id_rubrik']."
           ,'".$bobot[$i]."'
           ,".$bobot_nilai[$i].");";


}

$stmt = sqlsrv_query( $conn, $sql_bobot );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


//echo "Kriteria : ".$_POST['kriteria']."<br>";
//echo "Kriteria Persen : ".$_POST['kriteria_persen']."<br>";

$sql = "delete from tb_kriteria where id_rubrik=".$_POST['id_rubrik'];
 


//echo $sql."<br>";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

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
           (".$_POST['id_rubrik']."
           ,'".$kriteria[$i]."'
           ,".$kriteria_persen[$i].")";


}

$stmt = sqlsrv_query( $conn, $sql_kriteria );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


//echo "Deskripsi : ".$_POST['deskripsi']."<br>";
$get_kriteria = "select * from tb_kriteria where id_rubrik =".$_POST['id_rubrik']." ORDER BY id_kriteria ASC";



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


$get_bobot = "select * from tb_bobot where id_rubrik =".$_POST['id_rubrik']." ORDER BY id_bobot ASC";



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
		   ,".$_POST['id_rubrik']."
           ,'".$dekrip[$j]."');";
		   $count_b++;
		 
	}
	$count_k++;
}

$stmt_dekrip = sqlsrv_query( $conn, $sql_dekrip );
if( $stmt_dekrip === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo $_POST['id_rubrik'];

?>