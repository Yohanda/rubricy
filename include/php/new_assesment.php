<?php
echo '<h1>Pilih Rubrik</h1>';

$get_list = 'select count(*) as "jumlah" from tb_rubrik where id_user = '.$_SESSION['id_user']." AND status_evaluasi = 0";




$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Tidak ada Rubrik<hr>';
} else {

$get_list = 'select * from tb_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori where  status_evaluasi = 0 AND id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>Judul</th><th>Kategori</th><th>Waktu Pembuatan</th><th>Deskripsi</th></thead>';
while($row = sqlsrv_fetch_array($stmt_list)){
	echo '<tr>';
	$date = new DateTime();
	$waktu ="";
	if($row['tanggal_dibuat']->format('d') == $date->format('d')){
		$waktu = "Today at ".$row['tanggal_dibuat']->format('H:i A');
	} else if($row['tanggal_dibuat']->format('d/m') == date('d/m', strtotime('-1 day'))){
		$waktu = "Yesterday ".$row['tanggal_dibuat']->format('H:i');
	} else {
		$waktu = $row['tanggal_dibuat']->format('d/m/Y');
	}
	echo '<td><a href="index.php?menu=assesment&evaluation='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>'.$waktu.'</td>';
	echo '<td>'.$row['deskripsi'].'</td>';
	
	echo '</tr>';
	
}
echo '</table>';
}
?>