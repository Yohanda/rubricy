

<?php 
if(!$_POST) {
	?>
<form enctype="multipart/form-data" class="formoid-solid-blue" style="background-color:#ffffff;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:480px;min-width:150px" method="post" action="<?php $_SERVER['PHP_SELF']; ?>"><div class="title"><h2>Register</h2></div>
	<div class="element-input"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="username" required="required" placeholder="Username"/><span class="icon-place"></span></div></div>
	<div class="element-password"><label class="title"></label><div class="item-cont"><input class="large" type="password" name="password" value="" required="required" placeholder="Password"/><span class="icon-place"></span></div></div>
	<div class="element-name"><label class="title"></label><span class="nameFirst"><input placeholder="Name First" type="text" size="8" name="nameFirst" required="required"/><span class="icon-place"></span></span><span class="nameLast"><input placeholder="Name Last" type="text" size="14" name="nameLast" required="required"/><span class="icon-place"></span></span></div>
	<div class="element-select"><label class="title">Gender :</label><div class="item-cont"><div class="large"><span><select name="gender" required="required">

		<option value="0">Male</option>
		<option value="1">Female</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-email"><label class="title"></label><div class="item-cont"><input class="large" type="email" name="email" value="" placeholder="Email"/><span class="icon-place"></span></div></div>
	<div class="element-file"><label class="title">Profile Picture : <br></label><div class="item-cont"><label class="large" ><div class="button">Choose File</div><input type="file" class="file_input" name="pp" /><div class="file_text">No file selected</div><span class="icon-place"></span></label></div></div>
<div class="submit"><input type="submit" value="Submit"/></div></form>
<?php
} else {
include "include/php/conn.php";
$sql = "
INSERT INTO [dbo].[tb_user]
           ([username]
           ,[password_user]
           ,[profile_picture]
           ,[first_name]
           ,[last_name]
           ,[gender]
           ,[email]
           ,[hak_akses])
     VALUES
           ('".$_POST['username']."'
           ,'".md5($_POST['password'])."'
           , ''
           ,'".$_POST['nameFirst']."'
           ,'".$_POST['nameLast']."'
           ,".$_POST['gender']."
           ,'".$_POST['email']."'
           ,'')
";
echo $sql."<br>";


$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} else {
//get current id
$sql = 'SELECT SCOPE_IDENTITY() as "id_row"';
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

	$data = sqlsrv_fetch_array($stmt);
	echo 'Berhasil ditambahkan';
	$_SESSION['id_user'] = $data['id_row'];
}


$file_dir = "C:\\xampp\\htdocs\\rubrik\\user\\".$data['id_row'];
mkdir($file_dir, 0777);
foreach ($_FILES as $file_name => $file_array){

print "path : ".$file_array['tmp_name']."<br>\n";
print "name : ".$file_array['name']; echo"<br>";
print "size : ".$file_array['size']; echo"<br>";
print "type : ".$file_array['type']; echo"<br>";

	if(is_uploaded_file($file_array['tmp_name'])){
	move_uploaded_file($file_array['tmp_name'], 
	$file_dir."\\".$file_array['name']) or die ("Couldn't copy");
	print "file was moved!<br><br>";
	$dir = substr($file_dir."\\".$file_array['name'],20);
	$sql = "UPDATE [dbo].[tb_user]
   SET 
       [profile_picture] = '".str_replace("\\", "/", $dir)."'
 WHERE [id_user] = ".$data['id_row'];

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


	}
}


sqlsrv_free_stmt( $stmt);


echo 'Registrasi Berhasil, <a href="index.php">Klik disini</a> untuk kembali ke Halaman Utama';


}
?>