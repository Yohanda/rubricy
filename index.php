<?php
include "include/php/conn.php";
session_start();
?>
<!DOCTYPE html >
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="include/jQuery/jquery-ui.structure.min.css"/>
<link rel="stylesheet" type="text/css" href="include/jQuery/jquery-ui.theme.min.css"/>

<script type="text/javascript" src="include/jQuery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="include/jQuery/jquery-ui-1.11.1.min.js"></script>




<link rel="stylesheet" href="include/css/formoid-metro-cyan.css" type="text/css" />


<link rel="stylesheet" href="include/css/menubar.css">



<link href="include/css/bootstrap.min.css" rel="stylesheet">


<script type="text/javascript" src="export/tableExport.js"></script>
<script type="text/javascript" src="export/jquery.base64.js"></script>
<script type="text/javascript" src="export/html2canvas.js"></script>
<script type="text/javascript" src="export/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="export/jspdf/jspdf.js"></script>
<script type="text/javascript" src="export/jspdf/libs/base64.js"></script>

</head>

<body style="padding:0; margin:0;" >


<table border="0" cellspacing="0" cellpadding="0" width="100%" style="  border:0; margin:0;">
<tr  id="header"  height="150px" style="padding-left:5%; width:70%;"><td>
<img src="image/logo.png" height="70%" style="margin-left:1%" />
</td>
<td style="position: relative;">
<?php
if(!isset($_SESSION['user'])) {
	echo '<div class="btn-group" style="  position: absolute; top: 2px; right: 5px;" role="group" aria-label="...">
  
  <button type="button" class="btn btn-default"><a href="index.php?menu=register">Register</a></button>
   <button type="button" class="btn btn-default"><a href="index.php?menu=login">Login</a></button>

 
</div>';

} else {
	echo '<div class="btn-group" style="  position: absolute; top: 2px; right: 5px;" role="group" aria-label="...">
  <button type="button" class="btn btn-default"><img src="'.$_SESSION['profil'].'" width="15px" height="15px"></button>
  <button type="button" class="btn btn-default">'.$_SESSION['user'].'</button>
   <button type="button" class="btn btn-default"><a href="index.php?menu=logout">Logout</a></button>

 
</div>';
	
}

?>
</td></tr>
<tr id="menubar"  style=" margin:0; padding-left:5;" height="50px"><td colspan="2">
<div id='cssmenu' style="padding:0; margin:0;">
<ul>
<?php
if(isset($_SESSION['id_user'])){
	if(!isset($_GET['menu'])){
	echo "<li class='active'><a href='index.php'><span>Home</span></a></li>";
   echo "<li><a href='index.php?menu=my_rubrics'><span>My Rubrics</span></a></li>
   <li><a href='index.php?menu=tambah_rubrik'><span>Create</span></a></li>
   <li><a href='index.php?menu=assesment'><span>Assesment</span></a></li>
   <li><a href='index.php?menu=report'><span>Report</span></a></li>";
	} else {
   echo "<li><a href='index.php'><span>Home</span></a></li>";
   echo "<li ";
   if($_GET['menu'] == "my_rubrics" ) {
	   echo "class='active'";
   }
   echo "><a href='index.php?menu=my_rubrics'><span>My Rubrics</span></a></li>
   <li ";
   if($_GET['menu'] == "tambah_rubrik") {
	   echo "class='active'";
   }
   echo "><a href='index.php?menu=tambah_rubrik'><span>Create</span></a></li>
   <li ";
   if($_GET['menu'] == "assesment") {
	   echo "class='active'";
   }
   echo "><a href='index.php?menu=assesment'><span>Assesment</span></a></li>
   <li ";
   if($_GET['menu'] == "report") {
	   echo "class='active'";
   }
   echo "><a href='index.php?menu=report'><span>Report</span></a></li>";
	}
	
} else {

   echo "<li class='active'><a href='index.php'><span>Home</span></a></li>
   <li><a href='#'><span>FAQ</span></a></li>
   <li><a href='#'><span>About</span></a></li>";


}
?>
</ul>
</div>
</td></tr>
<tr height="450px"><td valign="top" style="background:#FFF; padding-left:5%; padding-top:1%; padding-right:5%;">
<?php

	

		
	
	
if(isset($_GET['kriteria'])) {
	include "include/php/search.php";
} else if(isset($_GET['view'])) {
	include "include/php/view_rubrik.php";
} else if(isset($_GET['view_enrolled'])) {
	include "include/php/view_enrolled_students.php";
} else if(isset($_GET['edit'])) {
	include "include/php/edit_rubrik.php";
} else if(isset($_GET['menu'])) {
	if($_GET['menu'] == "report"){
		if(isset($_GET['id_rubrik'])){
		include "include/php/report.php";
		} else {
		include "include/php/list_report.php";
		}
	} else if($_GET['menu'] == "assesment"){
		if(isset($_GET['do'])){
			
			if($_GET['do'] == "new_evaluation"){
				include "include/php/new_assesment.php";
			}
			
		} else if(isset($_GET['evaluation'])) {
			include "include/php/evaluation_method.php";
		} else if(isset($_GET['id_user'])){
			include "include/php/input_score.php";
		}  else if(isset($_GET['view_id_user'])){
			include "include/php/view_score.php";
		} else if(isset($_GET['edit_id_user'])){
			include "include/php/edit_score.php";
		} else if(isset($_GET['id_rubrik'])){
			include "include/php/select_student.php";
		} else {
			include "include/php/assesment.php";
		}
	
	} else if($_GET['menu'] == "register"){
		include "form/register.php";
	} else if($_GET['menu'] == "login"){
		include "form/login.php";
	} else if($_GET['menu'] == "logout"){
		include "include/php/logout.php";
	} else if($_GET['menu'] == "tambah_rubrik"){
		if(isset($_GET['do'])) {
		if($_GET['do'] == "blank"){
		include "include/php/add_blank_rubrik.php";	
		} else if($_GET['do'] == "existing"){
		include "include/php/add_existing_rubrik.php";	
		}
		} else 	{
		include "include/php/menu_tambah_rubrik.php";
		}
		
	} else if($_GET['menu'] == "my_rubrics"){
		include "include/php/my_rubrics.php";
	}  
	}  else {
		include "include/php/dashboard_user.php";
	}
?>

</td>
<td style="width:20%; padding-top:1%;" valign="top">
<div class="panel panel-default" >
  <div class="panel-heading">
    <h3 class="panel-title"><b>Search</b></h3>
  </div>
  <div class="panel-body">
  <form action="index.php" method="get">
    <div class="form-group">
  <label for="sel1">Kriteria</label>
  <select name="kriteria" class="form-control" id="sel1">
    <option value="judul">Judul</option>
    <option value="id_user">User</option>
  </select>
</div>
<div class="form-group">
  <label for="pwd">Keyword : </label>
  <input name="keyword" type="text" class="form-control" id="pwd">
</div>
<div class="form-group" align="right" >
<button type="submit" style="width:100%" class="btn btn-default">
  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
</button>
  
  </form>
</div>

  </div>
</div>

</td>
</tr>
<tr id="footer" bgcolor="#A1BDF1" height="50px"><td colspan="2"><center><font color="#FFFFFF">Copyright &copy; 2015 by Sistem Informasi ITS</font></center></td></tr>

</table>

<script type="text/javascript" src="include/js/formoid-metro-cyan.js"></script>


<script src="include/js/bootstrap.min.js"></script>


</body>
</html>