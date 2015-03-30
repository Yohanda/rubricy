<script type="text/javascript">
var id_rubrik;
var id_user;
	function konfirmasi(id_user, id_rubrik) {
		this.id_rubrik = id_rubrik;
		this.id_user = id_user;
		$("#konfirmasi").modal('show');
	};
	function tutup_konfirmasi() {
	$("#konfirmasi").modal('hide');
	}
	function refresh_my_rubrics(){
	$(location).attr('href',"index.php?menu=assesment");
	}
	function delete_rubrik() {
		$.ajax(
    {
        url : "include/php/delete_score.php",
        type: "POST",
        data : {  
		'id_rubrik':id_rubrik,
		'id_user':id_user
		},
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
			//alert(data);
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



<h1>Pilih Murid yang Akan Dinilai</h1>
<?php
$get_list = 'select count(*) as "jumlah" from tb_join inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik = '.$_GET['id_rubrik']." AND evaluated = 0";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$row = sqlsrv_fetch_array($stmt_list);

if($row['jumlah'] == 0){
	echo 'Tidak ada murid yang bisa dinilai';
} else {

$get_list = 'select * from tb_join inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik = '.$_GET['id_rubrik']." AND evaluated = 0";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>No.</th><th>Nama</th></thead>';
$no =1;
while($row = sqlsrv_fetch_array($stmt_list)){
	
	
	echo '<tr>';
	echo '<td>'.$no.'</td>'; $no++;
	echo '<td><a href="index.php?menu=assesment&id_rubrik='.$_GET['id_rubrik'].'&id_user='.$row['id_user'].'">'.$row['username'].'</a></td>';
	
	echo '</tr>';
	
}
echo '</table>';
}



?>

<br /><hr />
<h1>Murid yang Sudah dinilai</h1>
<?php
$get_list = 'select count(*) as "jumlah" from tb_join inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik = '.$_GET['id_rubrik']." AND evaluated = 1";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$row = sqlsrv_fetch_array($stmt_list);

if($row['jumlah'] == 0){
	echo 'Tidak ada murid yang sudah dinilai';
} else {

$get_list = 'select * from tb_join inner join tb_user on tb_user.id_user = tb_join.id_user where id_rubrik = '.$_GET['id_rubrik']." AND evaluated = 1";



$stmt_list = sqlsrv_query( $conn, $get_list );
if( $stmt_list === false) {
    die( print_r( sqlsrv_errors(), true) );
}

echo '<table class="table table-striped">';
echo '<thead><th>No.</th><th>Nama</th><th>Action</th></thead>';
$no =1;
while($row = sqlsrv_fetch_array($stmt_list)){
	
	
	echo '<tr>';
	echo '<td>'.$no.'</td>'; $no++;
	echo '<td><a href="index.php?menu=assesment&id_rubrik='.$_GET['id_rubrik'].'&view_id_user='.$row['id_user'].'">'.$row['username'].'</a></td>';
	
	echo '<td><a href="index.php?menu=assesment&id_rubrik='.$_GET['id_rubrik'].'&edit_id_user='.$row['id_user'].'"><button type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
</button></a>

<button onclick="konfirmasi('.$row['id_user'].', '.$_GET['id_rubrik'].');" type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
</button></td></tr>';
	
}
echo '</table>';
}



