<?php
if(!$_POST) {
?>
<h1>Login </h1>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
Username : <input type="text" name="username" /><br />
Password :<input type="password" name="password" /><br />
<input type="submit">
</form>
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
		echo '<meta http-equiv="refresh" content="0;index.php">';
	} else {
		echo 'login gagal';
	
	}
}
	
}
?>