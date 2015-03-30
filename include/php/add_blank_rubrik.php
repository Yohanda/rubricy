<script>
var id;

function info_sukses() {
		$("#berhasil_tambah").modal('show');
	}
	function redirect_view(){
		$(location).attr('href',"index.php?view="+id);
	}
	
</script>
<div id="berhasil_tambah" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Information</h4>
            </div>
            <div class="modal-body">
                <p>Rubrik berhasil dibuat</p>
                
            </div>
            <div class="modal-footer">
               <button onclick="redirect_view();" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['isian'])){
	echo 'asd';
} else {
?>


<script type='text/javascript'>//<![CDATA[ 





// append row to the HTML table
function appendRow() {
	
    var tbl = document.getElementById('my_table'), // table reference
        row = tbl.insertRow(tbl.rows.length),      // append table row
        i;
    // insert table cells to the new row
    for (i = 0; i < tbl.rows[0].cells.length; i++) {
		if(i == 0){
        createCell(row.insertCell(i), document.getElementById('row').value + ' ( ' + document.getElementById('rowBobot').value + '% ) ', 'row', 0);
		} else if(i == (tbl.rows[0].cells.length-1)) {
			 createCell(row.insertCell(i), '<input type="button" name="delete"/>', 'row', 1);
		} else {
			 createCell(row.insertCell(i), '<input type="text" name="isian"/>', 'row', 1);
		}
    }
}
 
// create DIV element and append to the table cell
function createCell(cell, text, style, pointer) {
    var div = document.createElement('div'), // create DIV element	
	point = pointer;
    if(point == 1) {
        txt = document.createElement('input'); // create text node
	} else {
		 txt = document.createTextNode(text); // create text node
	}
    div.appendChild(txt);                    // append text node to the DIV
    div.setAttribute('class', style);        // set DIV class attribute
    div.setAttribute('className', style);    // set DIV class attribute for IE (?!)
    cell.appendChild(div);                   // append DIV to the table cell
}
// append column to the HTML table
function appendColumn() {
	
	
    var tbl = document.getElementById('my_table'), // table reference
        i;
    // open loop for each row and append cell
    for (i = 0; i < tbl.rows.length; i++) {
		
		if(i == 0) {
		createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), document.getElementById('col').value + ' ( ' + document.getElementById('colBobot').value + ' pts) ', 'col');
		} else {
		createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), '<input type="text" name="isian"/>', 'col', 1);
		}
		
		
        
    }
}

// delete table rows with index greater then 0
function deleteRows() {
    var tbl = document.getElementById('my_table');
        tbl.deleteRow((document.getElementById('rowIndex').value-1));
    
}
 
// delete table columns with index greater then 0
function deleteColumns() {
    var tbl = document.getElementById('my_table');
    for (i = 0; i < tbl.rows.length; i++) {
  
            tbl.rows[i].deleteCell(document.getElementById('colIndex').value-1);
        
    }
}
</script>
<h1>Create Rubric</h1><hr />
<h4>Rubric Information</h4>
<form id="rubrik_prop">
<table style="border-collapse: separate; width:100%; border-spacing: 20px;">
<tr>
<td>
<div class="form-group">
  <label for="pwd">Judul : </label>
   <input class="form-control" type="text" name="judul">
</div>
</td>
<td> <div class="form-group">
  <label for="pwd">Enrollment Key : </label>
  <input class="form-control" type="text" name="enrollment_key">
</div></td>
</tr>
<tr>
<td valign="top">

    <div class="form-group">
  <label for="sel1">Kategori :</label>
  <select name="kategori" class="form-control" id="sel1">
  <?php
  $sql = 'SELECT * FROM tb_kategori';
$stmt = sqlsrv_query($conn, $sql);

if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

while($kategori = sqlsrv_fetch_array($stmt)){
  
   echo '<option value="'.$kategori['id_kategori'].'">'.$kategori['nama_kategori'].'</option>';
  }
  ?>
  </select>
</div>



</td>
<td>
<div class="form-group">
  <label for="comment">Deskripsi :</label>
  <textarea class="form-control" name="deskripsi_rubrik" rows="5" ></textarea>
</div>
</td>
</tr>
<tr>
<td>
<div class="checkbox">
  <label class="checkbox-inline"><input  id="set_as_template" type="checkbox" name="set_as_template" value="1">Set as Template</label>
</div>
</td>
</tr>

</table>
</form>
<hr />
<h4>Rubric Editor</h4>
<form id="rubrik" action="">


<table id="my_table" class="table table-striped" align="center" cellspacing="0" cellpadding="0">
<thead>
<th>Kriteria</th>
<td>a ( 10 pts )</td>
<td>b ( 20 pts )</td>
</thead>
<tr>
<td>c ( 1% )</td>
<td><input type="text" name="isian" value="ac"/></td>
<td><input type="text" name="isian" value="bc"/></td>
</tr>
<tr>
<td>d  ( 2% )</td>
<td><input type="text" name="isian" value="ad"/></td>
<td><input type="text" name="isian" value="bd"/></td>
</tr>



</table>
<button type="submit" value="Save" id="btnSave"  class="btn btn-default">
  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
</button>
</form>
</input>
<br/><br/><hr />
<h4>Rubric Actions</h4>
  <div class="col-lg-4">
  <input type="text"  placeholder="Enter Item Name" class="form-control"  id="row">
  </div>
  <div class="col-lg-4">
  <input type="text" placeholder="Enter Weight" class="form-control" id="rowBobot">
 </div>
<button  onClick="appendRow();" type="button" id="irow" class="btn btn-default">Insert Row</button>
<br/><br/>


<div class="col-lg-4">
  <input type="text"  placeholder="Enter Heading" class="form-control"  id="col">
  </div>
  <div class="col-lg-4">
  <input type="text" placeholder="Enter Weight" class="form-control" id="colBobot">
 </div>
<button   onClick="appendColumn();" type="button" id="icol" class="btn btn-default">Insert Column</button>


<br><br />
<div class="col-lg-4">
<input id="rowIndex" class="form-control" placeholder="Enter Heading"/>
</div>
<button type="button"  onClick="deleteRows();"  id="icol"  class="btn btn-default">
  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Delete Row
</button>

<br><br />
<div class="col-lg-4">
<input id="colIndex" class="form-control" placeholder="Enter Heading"/>
</div>
<button type="button"  onClick="deleteColumns();"  id="icol"  class="btn btn-default">
  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Delete Column
</button>
<br />
<br>


<button onclick="info_sukses();">ASD</button>

<script type="text/javascript">
/*
   $('input[type=button]').click(function() {
	

		
    var deskripsi ="";
    var t = document.getElementById('my_table');
    for (var j=1; j<t.rows.length; j++) {
    var r = t.rows[j];
    var inputs = r.getElementsByTagName("input");
  
    for (var i=0; i<inputs.length; i++) {
		if(i != (inputs.length-1)){
        deskripsi += inputs[i].value + ",";
		
		} else {
		deskripsi += inputs[i].value + ";";
		}
	}
	}
	
   //alert(deskripsi);
});
*/


$(document).ready(function() {
	
	
    // process the form
    $('#rubrik').submit(function(event) {
 

var formElements=document.getElementById("rubrik_prop").elements;    
var postData=new Array();
var count_prop = 0;
for (var i=0; i<(formElements.length-1); i++) {
    if (formElements[i].type!="submit"){//we dont want to include the submit-buttom
        postData[count_prop]=formElements[i].value;
		count_prop++;
	}
}
var x=$("#set_as_template").is(":checked");
if(x == true){
	 postData[count_prop] = 1;
} else {
	 postData[count_prop] = 0;
}
//alert("Prop : " + postData.join(","));
	//ambil deskripsi
	var deskripsi ="";
    var t = document.getElementById('my_table');
    for (var j=1; j<t.rows.length; j++) {
		
    var r = t.rows[j];
    var inputs = r.getElementsByTagName("input");
  
    for (var i=0; i<inputs.length; i++) {
		if(i != (inputs.length-1)){
        deskripsi += inputs[i].value + ",";
		
		} else {
		deskripsi += inputs[i].value + ";";
		}
	}
	}
	//alert(deskripsi);
	
	
	
	
	
	
	
	//kriteria
var kriteria = new Array();
var counter_krit = 0;

var kriteria_persen = new Array();
var counter_krit2 = 0;
	
	 for (var r = 0, n = t.rows.length; r < n; r++) {
            for (var c = 0, m = t.rows[r].cells.length; c < m; c++) {
				if( c == 0 && r != 0) {
				//ambil persen
                kriteria_persen[counter_krit2] = t.rows[r].cells[c].innerHTML.replace ( /[^\d.]/g, '' );
				counter_krit2++;
				
				var temp_kriteria = t.rows[r].cells[c].innerHTML.replace(/<(?:.|\n)*?>/gm, '');
				kriteria[counter_krit] = temp_kriteria.substring(0,(temp_kriteria.indexOf("(")-1));
				  //alert( bobot[counter_bobot]);
				counter_krit++;
				}
            }
        }
		
		/*
		for(var i = 0; i < kriteria.length; i++) {
		alert(kriteria[i]);
		alert(kriteria_persen[i]);
	}*/
	//alert("nama kriteria : " + kriteria.join(","));
	//alert("persentase kriteria : " + kriteria_persen.join(","));
	
	//kriteria
	
	//bobot
	
var bobot = new Array();
var counter_bobot = 0;

var bobot_nilai = new Array();
var counter_bobot2 = 0;
	
	
	 for (var r = 0, n = t.rows.length; r < n; r++) {
            for (var c = 0, m = t.rows[r].cells.length; c < m; c++) {
				if( c != 0 && r == 0) {
  bobot_nilai[counter_bobot2] = t.rows[r].cells[c].innerHTML.replace( /[^\d.]/g, '' );
  //alert( bobot_nilai[counter_bobot2]);
				counter_bobot2++;             //alert(t.rows[r].cells[c].innerHTML.replace ( /[^\d.]/g, '' ));
				//ambil nama bobot
				var bobot_nama = t.rows[r].cells[c].innerHTML.replace(/<(?:.|\n)*?>/gm, '');
				bobot[counter_bobot] = bobot_nama.substring(0,(bobot_nama.indexOf("(")-1));
				  //alert( bobot[counter_bobot]);
				counter_bobot++;
				//"a ( 3% )".substring(0,"a ( 3% )".indexOf("("))
				}
            }
        }
		/*
		for(var i = 0; i < bobot.length; i++) {
		alert(bobot[i]);
		alert(bobot_nilai[i]);
	}*/
	//alert("bobot : " + bobot.join(","));
	//alert("bobot nilai : " + bobot_nilai.join(","));
	//bobot
	
	
	
	
	
	// process the form
        $.ajax(
    {
        url : "include/php/add_blank_respon.php",
        type: "POST",
        data : {  'rubrik_prop':postData.join(","),
		'deskripsi':deskripsi,
		'kriteria':kriteria.join(","),
		'kriteria_persen':kriteria_persen.join(","),
		'bobot':bobot.join(","),
		'bobot_nilai':bobot_nilai.join(",")
		},
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
			id = data;
			info_sukses();
			
			
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails
			id = jqXHR;
			info_sukses();
			
        }
    });
	return false;
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
	
	
	
	//ambil deskripsi





	/*bobot deskripsi	
	var t = document.getElementById('my_table');
	var bobot_deskripsi = "";
	var count = 0;
    for (var j=1; j<t.rows.length; j++) {
    var r = t.rows[j];
    var inputs = r.getElementsByTagName("input");
    var result = new Array(inputs.length);
    for (var i=0; i<inputs.length; i++) {
		
		if(i == 0){
			bobot_deskripsi += inputs[i].value;

		} else if(i == inputs.length-1){
			bobot_deskripsi += "," + inputs[i].value + ";";
		
		} else {
			bobot_deskripsi +=  "," + inputs[i].value;
	
		}
		
	}
	}

	bobot deskripsi	*/
	
	
	
	
       

        
    });

});
</script>

<?php
}
?>
