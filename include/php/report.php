<?php
//get current id
$sql = 'SELECT * FROM tb_rubrik where id_rubrik = '.$_GET['id_rubrik'];
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

$rubrik_prop = sqlsrv_fetch_array($stmt);

echo '<h1>'.$rubrik_prop['judul'].'</h1>';

$sql = 'SELECT * FROM tb_kategori where id_kategori = '.$rubrik_prop['id_kategori'];
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

$kategori = sqlsrv_fetch_array($stmt);

echo "Kategori : ".$kategori['nama_kategori']."<br>";
echo "Deskripsi : ".$rubrik_prop['deskripsi'];

if(!isset($_SESSION['id_user'])){
	echo '<div class="alert alert-warning" role="alert">
  Anda harus <b>Login</b> untuk melihat
</div>';
} else {
//cek di daftar user
$sql = 'SELECT count(*) as "jumlah" FROM tb_join where id_rubrik = '.$_GET['id_rubrik']." AND id_user = ".$_SESSION['id_user'];
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

$join = sqlsrv_fetch_array($stmt);

if($rubrik_prop['id_user'] != $_SESSION['id_user'] && $join['jumlah'] == 0){
	echo '<div class="alert alert-warning" role="alert">
  Anda harus <b>Enroll</b> untuk melihat
</div>';
	
	echo '<div class="col-lg-4">
<input type="password" class="form-control" name="enroll_key" id="enroll_key" placeholder="Enter Enroll Key"/>
</div><button type="button"  onClick="join_me('.$_GET['id_rubrik'].');"  id="icol"  class="btn btn-default">
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>Enroll Me
</button>';
	
} else {


//get kriteria & bobot
$get_murid = "select * from tb_join  inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik =".$_GET['id_rubrik'];



$stmt_murid = sqlsrv_query( $conn, $get_murid );
if( $stmt_murid === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$arr_murid;
$count = 0;
while ($row = sqlsrv_fetch_array($stmt_murid)) {
    $arr_murid[$count] = $row;
	$count++;
}





echo '<table id="report" class="table table-striped">';
echo '<thead><th>Nama</th>';

$get = "select * from tb_kriteria where id_rubrik =".$_GET['id_rubrik']." ORDER BY id_kriteria ASC";



$stmt = sqlsrv_query( $conn, $get);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$arr_kriteria = array();
$count_k = 0;
while ($row = sqlsrv_fetch_array($stmt)) {
   $arr_kriteria[$count_k] = $row;
	echo "<th>".$row['nama_kriteria'].' ( '.$row['persentase_kriteria']." % )</th>";
	$count_k++;
}
echo '<th>Nilai Akhir</th></thead>';

for($i = 0; $i < sizeof($arr_murid);$i++) {
echo '<tr>';
echo '<td>'.$arr_murid[$i]['username'].'</td>';

//get deskripsi

for($j = 0; $j < sizeof($arr_kriteria); $j++) {
$get_nilai = "select * from tb_nilai inner join tb_bobot on tb_bobot.id_bobot = tb_nilai.id_bobot where id_user = ".$arr_murid[$i]['id_user']." AND id_kriteria = ".$arr_kriteria[$j]['id_kriteria'];

$stmt_nilai = sqlsrv_query( $conn, $get_nilai );
if( $stmt_nilai === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$baris = sqlsrv_fetch_array($stmt_nilai);
echo "<td><font color='#00FF00'><b>".$baris['nilai_bobot']."</b></font> (".$baris['nilai_bobot']*($arr_kriteria[$j]['persentase_kriteria']/100).")</td>";

}

echo "<td><b>".$arr_murid[$i]['total_nilai']."</b></td>";

echo '</tr>';
}

echo '</table><br>';

}
}
?>

<button type="submit" onClick="$('#report').tableExport({type:'excel',escape:'false'});" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Export to Excel
</button>

<button type="submit" onClick="$('#report').tableExport({type:'pdf',escape:'false'});" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Export to Pdf
</button>

<button type="submit" onClick="$('#report').tableExport({type:'csv',escape:'false'});" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Export to CSV
</button>
