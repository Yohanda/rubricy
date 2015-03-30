<h1>Enrolled Students</h1>
<?php

$get_list = 'select count(*) as "jumlah" from tb_join where id_rubrik = '.$_GET['view_enrolled'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Belum ada murid yang enrolled<hr>';
} else {
$get_list = 'select * from tb_join inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik = '.$_GET['view_enrolled'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>Nama</th><th>Waktu</th></thead>';
while($row = sqlsrv_fetch_array($stmt_list)){
	
	$date = new DateTime();
	$waktu ="";
	if($row['waktu_join']->format('d') == $date->format('d')){
		$waktu = "Today at ".$row['waktu_join']->format('H:i A');
	} else if($row['waktu_join']->format('d/m') == date('d/m', strtotime('-1 day'))){
		$waktu = "Yesterday ".$row['waktu_join']->format('H:i');
	} else {
		$waktu = $row['waktu_join']->format('d/m/Y');
	}
	
	echo '<tr>';
	echo '<td>'.$row['username'].'</td>';
	echo '<td>'.$waktu.'</td>';
	
	echo '</tr>';
	
}
echo '</table>';
}
?>
