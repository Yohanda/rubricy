<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="include/jQuery/jquery-ui.structure.min.css"/>
<link rel="stylesheet" type="text/css" href="include/jQuery/jquery-ui.theme.min.css"/>
<link rel="stylesheet" type="text/css" href="plugin/appendGrid/jquery.appendGrid-1.5.2.css"/>

<script type="text/javascript" src="include/jQuery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="include/jQuery/jquery-ui-1.11.1.min.js"></script>
<script type="text/javascript" src="plugin/appendGrid/jquery.appendGrid-1.5.2.js"></script>



<link rel="stylesheet" href="include/css/formoid-solid-blue.css" type="text/css" />


<link rel="stylesheet" href="include/css/menubar.css">

</head>

<body style="padding:0; margin:0;">

<script id="jsSource" type="text/javascript">
$(function () {
    // Initialize appendGrid
    $('#tblAppendGrid').appendGrid({
        caption: 'Kriteria Penilaian',
        initRows: 1,
        columns: [
                { name: 'Album', display: 'Album', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'} },
                { name: 'Artist', display: 'Artist', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '100px'} },
                { name: 'Year', display: 'Year', type: 'text', ctrlAttr: { maxlength: 4 }, ctrlCss: { width: '40px'} },
                { name: 'Origin', display: 'Origin', type: 'select', ctrlOptions: { 0: '{Choose}', 1: 'Hong Kong', 2: 'Taiwan', 3: 'Japan', 4: 'Korea', 5: 'US', 6: 'Others'} },
                { name: 'Poster', display: 'With Poster?', type: 'checkbox' },
                { name: 'Price', display: 'Price', type: 'text', ctrlAttr: { maxlength: 10 }, ctrlCss: { width: '50px', 'text-align': 'right' }, value: 0 },
                { name: 'RecordId', type: 'hidden', value: 0 }
            ]
    });
    // Handle `Load` button click
    $('#btnLoad').button().click(function () {
        $('#tblAppendGrid').appendGrid('load', [
            { 'Album': 'Dearest', 'Artist': 'Theresa Fu', 'Year': '2009', 'Origin': 1, 'Poster': true, 'Price': 168.9, 'RecordId': 123 },
            { 'Album': 'To be Free', 'Artist': 'Arashi', 'Year': '2010', 'Origin': 3, 'Poster': true, 'Price': 152.6, 'RecordId': 125 },
            { 'Album': 'Count On Me', 'Artist': 'Show Luo', 'Year': '2012', 'Origin': 2, 'Poster': false, 'Price': 306.8, 'RecordId': 127 },
            { 'Album': 'Wonder Party', 'Artist': 'Wonder Girls', 'Year': '2012', 'Origin': 4, 'Poster': true, 'Price': 108.6, 'RecordId': 129 },
            { 'Album': 'Reflection', 'Artist': 'Kelly Chen', 'Year': '2013', 'Origin': 1, 'Poster': false, 'Price': 138.2, 'RecordId': 131 }
        ]);
    });
    // Handle `Serialize` button click
    $('#btnSerialize').button().click(function () {
        alert('Here is the serialized data!!\n' + $(document.forms[0]).serialize());
    });
});
  </script>


<table border="0" cellspacing="0" cellpadding="0" width="100%" style="  border:0; margin:0;">
<tr  id="header"  height="150px" style="padding-left:5%;"><td>
<img src="image/logo.png" height="70%" style="margin-left:1%" />
</td>
<td>
<?php
if(!isset($_SESSION['user'])) {
?>
<a href="index.php?menu=register">Register</a><a href="index.php?menu=login">Login</a>
<?php
} else {
	echo 'Welcome, '.$_SESSION['user'].'<a href="index.php?menu=logout">Logout</a>';
}

?>
</td></tr>
<tr id="menubar"  style=" margin:0; padding-left:5;" height="50px"><td colspan="2">
<div id='cssmenu' style="padding:0; margin:0;">
<ul>
   <li class='active'><a href='index.php'><span>Home</span></a></li>
   <li><a href='#'><span>FAQ</span></a></li>
   <li><a href='#'><span>About</span></a></li>
</ul>
</div>
</td></tr>
<tr height="450px"  style="background:url(image/background.png) repeat;"><td style="background:#FFF;">

<?php
if(isset($_SESSION['user'])) {
	include "include/php/dashboard_user.php";
} 
if(isset($_GET['menu'])) {
	if($_GET['menu'] == "register"){
		include "form/register.php";
	} else if($_GET['menu'] == "login"){
		include "form/login.php";
	} else if($_GET['menu'] == "logout"){
		include "include/php/logout.php";
	} else if($_GET['menu'] == "tambah_rubrik"){
		if(isset($_GET['do'])) {
		include "include/php/add_blank_rubrik.php";	
		} else {
		include "include/php/menu_tambah_rubrik.php";
		}
		
	} else {
	}
  
} 
?>

</td>
<td style="background:#CCC">
<h1>Search</h1>

</td>
</tr>
<tr id="footer" bgcolor="#A1BDF1" height="50px"><td colspan="2"><center><font color="#FFFFFF">Copyright &copy; 2015 by Sistem Informasi ITS</font></center></td></tr>

</table>

<script type="text/javascript" src="formoid_files/formoid1/formoid-solid-blue.js"></script>

</body>
</html>