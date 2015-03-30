<?php
echo '<h1>Hasil Pencarian</h1>';

if($_GET['kriteria'] == "id_user"){
$get_list = "select * from tb_user
where username =  '".$_GET['keyword']."'";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$user = sqlsrv_fetch_array($stmt_list);
$_GET['keyword'] = $user['id_user'];
}


$get_list = 'select count(*) as "jumlah" from tb_rubrik
where '.$_GET['kriteria']." LIKE  '%".$_GET['keyword']."%'";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Tidak ada hasil<hr>';
} else {
$get_list = "select * from tb_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori inner join tb_user on tb_user.id_user = tb_rubrik.id_user where tb_rubrik.".$_GET['kriteria']." LIKE  '%".$_GET['keyword']."%'";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
echo 'Terdapat '.$row['jumlah']." hasil";
echo '<table class="table table-striped">';
echo '<thead><th>Judul</th><th>Kategori</th><th>Pembuat</th><th>Waktu Pembuatan</th><th>Deskripsi</th></thead>';
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
	echo '<td><a href="index.php?menu=my_rubrics&view='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>'.$row['username'].'</td>';
	echo '<td>'.$waktu.'</td>';
	echo '<td>'.$row['deskripsi'].'</td>';
	echo '</tr>';
	
}
echo '</table>';
}
?>