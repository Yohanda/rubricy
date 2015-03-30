<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Example of Bootstrap 3 Modals</title>
<script type="text/javascript" src="include/jQuery/jquery-1.11.1.min.js"></script>

<style>
#loader{
 z-index:999999;
 display:none;
 position:fixed;
 top:0;
 left:0;
 width:100%;
 height:100%;
 background:url(ajax-loader.gif) 50% 50% no-repeat #cccccc;
}
</style>
</head>
<body>
<div id="loader">
</div>
<script>

	 function loading() {
 $("#loader").fadeIn(500).show();
 
 $("#loader").delay(1000000).fadeOut(500).hide();
	 }

 </script>
 <button value="asd" onClick="loading();">CLICK</button>
</body>
</html>                                		