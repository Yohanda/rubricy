
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Add Rows &amp; Columns to a table dynamically - jsFiddle demo by afzaalace</title>
  
  <script type='text/javascript' src='jquery-1.11.2.min.js'></script>

  
  <style type='text/css'>
    td{padding:5px;}
  </style>
  


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$('#irow').click(function(){
    if($('#row').val()){
        $('#mtable tbody').append($("#mtable tbody tr:last").clone());
        $('#mtable tbody tr:last :text').attr('checked',false);
        $('#mtable tbody tr:last td:first').html($('#row').val());
    }else{alert('Enter Text');}
});
$('#icol').click(function(){
    if($('#col').val()){
        $('#mtable tr').append($("<td>"));
        $('#mtable thead tr>td:last').html($('#col').val());
        $('#mtable tbody tr').each(function(){$(this).children('td:last').append($('<input type="text">'))});
    }else{alert('Enter Text');}
});
});//]]>  

</script>


</head>
<body>
  <table border="1" id="mtable">
    <thead><tr><td>Item</td><td>Red</td><td>Green</td></tr></thead>
    <tbody><tr><td>Some Item</td><td><input type="text" name="f1"  /></td><td><input type="text" name="f2"  /></td></tr></tbody>
   
</table>
<input type="button" value="clickme"></input>
<br/><br/>
<input id="row" placeholder="Enter Item Name"/><button id="irow">Insert Row</button><br/><br/>
<input id="col" placeholder="Enter Heading"/><button id="icol">Insert Column</button><br>



<button id="btnGo">Go</button>
<script type="text/javascript">
   $('input[type=button]').click(function() {
    var data = $("#mtable").find('input')
          .not('input[type=button]')
          .serialize();
		  alert(data);
});

String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
} 
</script>
  
</body>


</html>

