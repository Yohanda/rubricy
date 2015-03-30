<?php
$total = 0;
$get_user = "select * from tb_user where id_user =".$_GET['view_id_user'];

$stmt_user = sqlsrv_query( $conn, $get_user );
if( $stmt_user === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$row = sqlsrv_fetch_array($stmt_user);
 
echo '<h1>Score for '.$row['username'].'</h1>';

$get= "select * from tb_rubrik where id_rubrik =".$_GET['id_rubrik'];

$stmt = sqlsrv_query( $conn, $get );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$row = sqlsrv_fetch_array($stmt);

echo '<h3>Rubrik : '.$row['judul'].'</h4>';
$get_kriteria = "select * from tb_kriteria where id_rubrik =".$_GET['id_rubrik']." ORDER BY id_kriteria ASC";



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

$arr_nilai = array();
$i_nilai = 0;

$get_nilai = "select * from tb_nilai where id_rubrik =".$_GET['id_rubrik']." AND id_user = ".$_GET['view_id_user'];

$stmt_nilai = sqlsrv_query( $conn, $get_nilai );
if( $stmt_nilai === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while ($row = sqlsrv_fetch_array($stmt_nilai)) {
    $arr_nilai[$i_nilai] = $row;
	$i_nilai++;
}




//get kriteria & bobot
$get_kriteria = "select * from tb_kriteria where id_rubrik =".$_GET['id_rubrik']." ORDER BY id_kriteria ASC";



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

echo '<form action="index.php?menu=assesment&id_rubrik='.$_GET['id_rubrik'].'&id_user='.$_GET['view_id_user'].'&submit=true" method="post">';
echo '<table class="table table-striped">';
echo '<thead><th>Kriteria</th>';
//print bobot
$get_bobot = "select * from tb_bobot where id_rubrik =".$_GET['id_rubrik']." ORDER BY id_bobot ASC";



$stmt_get_bobot = sqlsrv_query( $conn, $get_bobot );
if( $stmt_get_bobot === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$arr_bobot;
$count = 0;
while ($row = sqlsrv_fetch_array($stmt_get_bobot)) {
    $arr_bobot[$count] = $row;
	echo "<td>".$arr_bobot[$count]['nama_bobot'].' ( '.$arr_bobot[$count]['nilai_bobot']." pts )</td>";
	$count++;
}
echo '</thead>';

for($i = 0; $i < sizeof($arr_kriteria);$i++) {
echo '<tr>';
echo '<td>'.$arr_kriteria[$i]['nama_kriteria'].' ( '.$arr_kriteria[$i]['persentase_kriteria'].'% )</td>';

//get deskripsi


$get_bobot = "select * from tb_deskripsi_bobot where id_kriteria = ".$arr_kriteria[$i]['id_kriteria'];



$stmt_get_bobot = sqlsrv_query( $conn, $get_bobot );
if( $stmt_get_bobot === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while ($row = sqlsrv_fetch_array($stmt_get_bobot)) {
	$index_sama;
	for($j = 0; $j < sizeof($arr_nilai); $j++){
		
		if($arr_kriteria[$i]['id_kriteria'] == $arr_nilai[$j]['id_kriteria']) {
		$index_sama = $j;
		}
	}
	
	if($arr_kriteria[$i]['id_kriteria'] == $arr_nilai[$index_sama]['id_kriteria'] && $row['id_bobot'] == $arr_nilai[$index_sama]['id_bobot']){
	$temu;
	for($k=0;$k<sizeof($arr_bobot);$k++){
		if($row['id_bobot'] == $arr_bobot[$k]['id_bobot']){
			$temu = $k;
			break;
		}
	}
	$total_temp = $arr_kriteria[$i]['persentase_kriteria']*($arr_bobot[$temu]['nilai_bobot']/100);
	$total += $total_temp;
	echo '<td style="background:#00EA00;">';
    echo '<div class="radio"><label><input checked disabled type="radio" name="'.$arr_kriteria[$i]['id_kriteria'].'" value="'.$row['id_bobot'].'"> <font color="#FFFFFF">'.$row['deskripsi_bobot']." = ".$total_temp."</font></label></div>";
	echo '</td>';
	} else {
	echo '<td>';
    echo '<div class="radio"><label><input disabled type="radio" name="'.$arr_kriteria[$i]['id_kriteria'].'" value="'.$row['id_bobot'].'">'.$row['deskripsi_bobot']."</label></div>";
	echo '</td>';
	}
	
}




echo '</tr>';
}

echo '</table><br>Total Nilai : '.$total.' out of '.$arr_bobot[sizeof($arr_bobot)-1]['nilai_bobot'].'<br><h5>Keterangan:</h5><button style="background:#00EA00;" type="button" class="btn btn-default" aria-label="Left Align">
 <font color="#FFFFFF">Nilai yang diberikan</font>
</button></form><br>';
?>