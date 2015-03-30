<div id="berhasil" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <div class="modal-body">
                <p>Penilaian Rubrik telah dihentikan</p>
                
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
	$(location).attr('href',"index.php?menu=report");
	}
	function update_status(id_rubrik) {
		id = id_rubrik;
			$.ajax(
    {
        url : "include/php/status_evaluated.php",
        type: "POST",
        data : {  
		'id_rubrik':id
		},
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
		
			$("#berhasil").modal('show');
			
			
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails
			alert("Gagal"); 
        }
    });
		
	
	}
</script>
<h1>Daftar Penilaian</h1>
<?php
$get_list = 'select count(*) as "jumlah" from tb_rubrik where status_evaluasi = 1 AND id_user='.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);

echo '<a href="index.php?menu=assesment&do=new_evaluation"><div align="right"><button type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Buat Penilaian Baru
</button></div></a><br><br>';

if($row['jumlah'] == 0){
	echo 'Belum ada penilaian atau Anda tidak memiliki Rubrik<hr>';
} else {
$get_list = 'select *  from tb_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori  where status_evaluasi = 1 AND id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>Judul</th><th>Kategori</th><th>Tipe Penilaian</th><th>Waktu Pembuatan</th><th>Action</th></thead>';
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
	echo '<td><a href="index.php?menu=assesment&id_rubrik='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>';
	if($row['evaluation_method'] == 1){
		echo "Top-down Evaluation";
	} else if($row['evaluation_method'] == 2) {
		echo "Peer Evaluation";
	}
	echo '</td>';
	echo '<td>'.$waktu.'</td>';
	echo '<td><button onclick="update_status('.$row['id_rubrik'].');" type="button" class="btn btn-default">
   Close
</button></td>';
	echo '</tr>';
	
}
echo '</table>';
}
?>