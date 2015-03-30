<h1>Daftar Report</h1>
<?php
include "conn.php";
$get_list = 'select * from tb_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori where status_evaluasi = 2 AND id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>Judul</th><th>Kategori</th><th>Tipe Penilaian</th><th>Waktu Pembuatan</th></thead>';
while($row = sqlsrv_fetch_array($stmt_list)){
	echo '<tr>';
	$date = new DateTime();
	$waktu ="";
	if($row['tanggal_dibuat']->format('d') == $date->format('d')){
		$waktu = "Today at ".$row['tanggal_dibuat']->format('H:i A');
	} else if($row['tanggal_dibuat']->format('d/m') == date('d/m', strtotime('-1 day'))){
		$waktu = "Yesterday ".$row['tanggal_dibuat']->format('H:i A');
	} else {
		$waktu = $row['tanggal_dibuat']->format('d/m/Y');
	}
	echo '<td><a href="index.php?menu=report&id_rubrik='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>';
	if($row['evaluation_method'] == 1){
		echo "Top-down Evaluation";
	} else if($row['evaluation_method'] == 2) {
		echo "Peer Evaluation";
	}
	echo '</td>';
	echo '<td>'.$waktu.'</td>';
	
	echo '</tr>';
	
}


$get_list = 'select * from tb_join  inner join tb_rubrik on tb_rubrik.id_rubrik = tb_join.id_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori where tb_rubrik.status_evaluasi = 2 AND tb_join.id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while($row = sqlsrv_fetch_array($stmt_list)){
	echo '<tr>';
	$date = new DateTime();
	$waktu ="";
	if($row['tanggal_dibuat']->format('d') == $date->format('d')){
		$waktu = "Today at ".$row['tanggal_dibuat']->format('H:i A');
	} else if($row['tanggal_dibuat']->format('d/m') == date('d/m', strtotime('-1 day'))){
		$waktu = "Yesterday ".$row['tanggal_dibuat']->format('H:i A');
	} else {
		$waktu = $row['tanggal_dibuat']->format('d/m/Y');
	}
	echo '<td><a href="index.php?menu=report&id_rubrik='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>';
	if($row['evaluation_method'] == 1){
		echo "Top-down Evaluation";
	} else if($row['evaluation_method'] == 2) {
		echo "Peer Evaluation";
	}
	echo '</td>';
	echo '<td>'.$waktu.'</td>';
	
	echo '</tr>';
	
}

echo '</table>';


?>