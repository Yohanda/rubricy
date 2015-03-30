<?php
echo '<h1>Pilih Methode Penilaian</h1>';
if(!isset($_GET['evaluation_method'])) {
$get_list = 'select count(*) as "jumlah" from tb_join where id_rubrik = '.$_GET['evaluation'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Anda tidak bisa menilai rubrik, belum ada murid yang enrolled<hr>';
} else {





echo '<ul>
<li><a href="index.php?menu=assesment&evaluation='.$_GET['evaluation'].'&evaluation_method=1">Top-down Evaluation</a></li>
<li><a href="index.php?menu=assesment&evaluation='.$_GET['evaluation'].'&evaluation_method=2">Peer Evaluation</a></li>
</ul>';
}


} else {
$sql = 'UPDATE [dbo].[tb_rubrik]
   SET 
       [evaluation_method] = '.$_GET['evaluation_method'].'
      ,[status_evaluasi] = 1
      
 WHERE id_rubrik = '.$_GET['evaluation'];



$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

if($_GET['evaluation_method'] == 2) {
$get_list = 'select count(*) as "jumlah" from tb_join where id_rubrik = '.$_GET['evaluation'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
$evaluator = array();
$already = array();
$count_terpakai=0;
if($row['jumlah'] < 2) {
	echo 'Penilaian Peer tidak bisa dilakukan jika hanya terdapat 1 murid';
} else {
	for($i = 0; $i < $row['jumlah']; $i){
	$temp = mt_rand(0,($row['jumlah']-1));
	while($temp == $i){
		$temp = mt_rand(0,($row['jumlah']-1));
	}
	$evaluator[$i] = mt_rand(0,($row['jumlah']-1));
	}
}

} else {

echo 'Penilaian berhasil disimpan!';

}
echo '<meta http-equiv="refresh" content="2; URL=index.php?menu=assesment">';

}
?>
