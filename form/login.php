<?php
if(!$_POST) {
?>
<form class="formoid-metro-cyan" style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;max-width:480px;min-width:150px" method="post" action="<?php $_SERVER['PHP_SELF'] ?>"><div class="title"><h2>Login</h2></div>
	<div class="element-input" title="Isikan username Anda"><label class="title">Username<span class="required">*</span></label><input class="large" type="text" name="username" required="required"/></div>
	<div class="element-password" title="Isikan password Anda"><label class="title">Password<span class="required">*</span></label><input class="large" type="password" name="password" value="" required="required"/></div>
<div class="submit"><input type="submit" value="Submit"/></div></form>
<?php
} else {
	
	
include "include/php/conn.php";

$sql = "SELECT * FROM tb_user WHERE username = '".$_POST["username"]."'";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} else {
	$fetch = sqlsrv_fetch_array($stmt);
	if($fetch["password_user"] == md5($_POST["password"])){

		$_SESSION['user'] = $fetch['username'];
		$_SESSION['id_user'] = $fetch['id_user'];
		$_SESSION['profil'] = $fetch['profile_picture'];
		echo '<meta http-equiv="refresh" content="0;index.php">';
	} else {
		echo 'login gagal';
	
	}
}
	
}
?>