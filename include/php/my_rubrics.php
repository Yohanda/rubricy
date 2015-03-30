<script type="text/javascript">
var id_rubrik;
	function konfirmasi(id_rubrik) {
		this.id_rubrik = id_rubrik;
		$("#konfirmasi").modal('show');
	};
	function tutup_konfirmasi() {
	$("#konfirmasi").modal('hide');
	}
	function refresh_my_rubrics(){
	$(location).attr('href',"index.php?menu=my_rubrics");
	}
	function delete_rubrik() {
		$.ajax(
    {
        url : "include/php/delete_rubrik.php",
        type: "POST",
        data : {  
		'id_rubrik':id_rubrik
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
                <button onclick="tutup_konfirmasi();delete_rubrik();" type="button" class="btn btn-primary">Delete</button>
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
                <p>Data berhasil dihapus</p>
                
            </div>
            <div class="modal-footer">
               <button onclick="refresh_my_rubrics();" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<?php
echo '<h1>My Rubrics</h1>';
$get_list = 'select count(*) as "jumlah" from tb_rubrik where id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Anda belum memiliki Rubrik<hr>';
} else {
$get_list = 'select * from tb_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori where id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>Judul</th><th>Kategori</th><th>Waktu Pembuatan</th><th>Deskripsi</th><th>Action</th></thead>';
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
	echo '<td>'.$waktu.'</td>';
	echo '<td>'.$row['deskripsi'].'</td>';
	echo '
	<td><a href="index.php?edit='.$row['id_rubrik'].'"><button type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
</button></a>

<button onclick="konfirmasi('.$row['id_rubrik'].');" type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
</button></td>';
	echo '</tr>';
	
}
echo '</table>';
}
?>












<?php
echo '<h1>My Enrolled Rubrics</h1>';
$get_list = 'select count(*) as "jumlah" from tb_join where id_user = '.$_SESSION['id_user'];



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$row = sqlsrv_fetch_array($stmt_list);
if($row['jumlah'] == 0){
	echo 'Anda belum enroll dirubrik manapun<hr>';
} else {
$get_list = 'select * from tb_join inner join tb_rubrik on tb_join.id_rubrik = tb_rubrik.id_rubrik inner join tb_kategori on tb_kategori.id_kategori = tb_rubrik.id_kategori where tb_join.id_user = '.$_SESSION['id_user'];



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
	echo '<td><a href="index.php?menu=my_rubrics&view='.$row['id_rubrik'].'">'.$row['judul'].'</a></td>';
	echo '<td>'.$row['nama_kategori'].'</td>';
	echo '<td>'.$waktu.'</td>';
	echo '<td>'.$row['deskripsi'].'</td>';
	
	echo '</tr>';
	
}
echo '</table>';
}
?>
















<script>



        $(document).on("click", ".alert", function(e) {
            bootbox.prompt("What is your name?", function(result) {                
  if (result === null) {                                             
    Example.show("Prompt dismissed");                              
  } else {
    Example.show("Hi <b>"+result+"</b>");                          
  }
});
        });
    </script>