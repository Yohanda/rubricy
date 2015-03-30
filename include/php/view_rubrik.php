<script type="text/javascript">
var id_user;
var id_rubrik;
	function konfirmasi(id_user, id_rubrik) {
		this.id_user = id_user;
		this.id_rubrik = id_rubrik;
		$("#konfirmasi").modal('show');
	};
	function tutup_konfirmasi() {
	$("#konfirmasi").modal('hide');
	}
	function refresh_my_rubrics(){
	location.reload();
	}
	function unenroll() {
		$.ajax(
    {
        url : "include/php/unenroll.php",
        type: "POST",
        data : {  
		'id_rubrik':id_rubrik,
		'id_user':id_user
		},
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
		
			$("#berhasil_hapus").modal('show');
			
			
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails
			alert("Gagal"); 
        }
    });
		
	
	}
</script>
<div id="konfirmasi" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button onclick="tutup_konfirmasi();unenroll();" type="button" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>

<div id="berhasil_hapus" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Attention</h4>
            </div>
            <div class="modal-body">
                <p>Anda telah melakukan unenroll</p>
                
            </div>
            <div class="modal-footer">
               <button onclick="refresh_my_rubrics();" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>






<div id="berhasil" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <div class="modal-body">
                <p>Anda berhasil enroll</p>
                
            </div>
            <div class="modal-footer">
               <button onclick="refresh_view();" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
var id;
function refresh_view(){
	$(location).attr('href',"index.php?view="+id);
	}
	function join_me(id_rubrik) {
		id = id_rubrik;
			$.ajax(
    {
        url : "include/php/enroll.php",
        type: "POST",
        data : {  
		'id_rubrik':id,
		'enroll_input':$('#enroll_key').val()
		},
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
			if(data == 1) {
			$("#berhasil").modal('show');
			} else {
			alert("Enrollment key salah");
			}
			
			
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails
			alert("Gagal"); 
        }
    });
		
	
	}
</script>
<?php
//get current id
$sql = 'SELECT * FROM tb_rubrik where id_rubrik = '.$_GET['view'];
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
$sql = 'SELECT count(*) as "jumlah" FROM tb_join where id_rubrik = '.$_GET['view']." AND id_user = ".$_SESSION['id_user'];
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
</div><button type="button"  onClick="join_me('.$_GET['view'].');"  id="icol"  class="btn btn-default">
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>Enroll Me
</button>';
	
} else {


//get kriteria & bobot
$get_kriteria = "select * from tb_kriteria where id_rubrik =".$_GET['view']." ORDER BY id_kriteria ASC";



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





echo '<table class="table table-striped">';
echo '<thead><th>Kriteria</th>';
//print bobot
$get_bobot = "select * from tb_bobot where id_rubrik =".$_GET['view']." ORDER BY id_bobot ASC";



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
    echo "<td>".$row['deskripsi_bobot']."</td>";
}




echo '</tr>';
}

echo '</table><br>';
echo '<button onclick="konfirmasi('.$_SESSION['id_user'].', '.$_GET['view'].');"  value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Unenroll
</button><a style="margin-left:3%;"  href="index.php?menu=my_rubrics&view_enrolled='.$_GET['view'].'"><button type="submit" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> View Enrolled Students
</button></a>';
if($rubrik_prop['status_evaluasi'] == 2){
	echo '<a style="margin-left:3%;" href="index.php?menu=my_rubrics&view_enrolled='.$_GET['view'].'"><button type="submit" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> View Report
</button></a>';
}
echo '<hr>';

echo '<h1>Komentar</h1>';

$get_comment = 'select count(*) as "jumlah" from tb_komentar where id_rubrik = '.$_GET['view'];



$stmt_comment = sqlsrv_query( $conn, $get_comment );
if( $stmt_comment === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_comment);
if($row['jumlah'] == 0){
	echo 'Belum ada komentar<hr>';
} else {
	$get_comment = 'select * from tb_komentar  INNER JOIN tb_user on tb_user.id_user = tb_komentar.id_user where id_rubrik = '.$_GET['view'];



$stmt_comment = sqlsrv_query( $conn, $get_comment );
if( $stmt_comment === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<ul class="list-group">';


while($row = sqlsrv_fetch_array($stmt_comment)){
	echo '<li class="list-group-item">';
	$date = new DateTime();
	$waktu ="";
	if($row['waktu_komentar']->format('d') == $date->format('d')){
		$waktu = "Today at ".$row['waktu_komentar']->format('H:i');
	} else if($row['waktu_komentar']->format('d/m') == date('d/m', strtotime('-1 day'))){
		$waktu = "Yesterday ".$row['waktu_komentar']->format('H:i');
	} else {
		$waktu = $row['waktu_komentar']->format('d/m/Y');
	}
	
	echo "<b>".$row['username']."</b> (".$waktu.") said : <br>".$row['isi_komentar'];
	echo '</li>';
}
echo '</ul>';
}


if(isset($_SESSION['user'])){
	
	
	echo '<form action="include/php/submit_comment.php" method="post">
	<label for="comment">Logged as '.$_SESSION['user'].'</label>
	<textarea name="comment" class="form-control" rows="5"></textarea><br><input type="hidden" name="id_rubrik" value="'.$_GET['view'].'"><input class="form-control" style="width:20%;" type="submit"></form><br><br>';
}
}
}
?>