<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_part_im.php";

?>
<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        //color based on menu click
		if(	operator == "critical_data"){
			//remove
			$("#dt_critical").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table installClick-table");
			//add
			$("#dt_critical").addClass("criticalClick-table");
		}
		
		$('table').DataTable();
		return false;
    });
</script>
<?php

//call session
$date2 = date('Y-m-d');
$picknav_nik      	= isset($_SESSION['picknav_nik'])    	? $_SESSION['picknav_nik']   : '';
$picknav_pic      	= isset($_SESSION['picknav_pic'])    	? $_SESSION['picknav_pic']   : '';
$picknav_levelno  	= isset($_SESSION['picknav_levelno'])	? $_SESSION['picknav_levelno'] : '';
///$src_sdate_install	= isset($_POST['src_sdate_install']) 	? $_POST['src_sdate_install'] : '';
///$src_edate_install	= isset($_POST['src_edate_install']) 	? $_POST['src_edate_install'] : '';
$getjobno	= isset($_POST['jobno']) 	? $_POST['jobno'] : '';
$jobno = substr($getjobno,0,36);


$sql 	= "select distinct (critical_id),
			jobno,
			zfeeder,
			partno,
			critical_nik,
			critical_date,
			critical_time,
			expdate,
			source
			from criticalrecords
			where jobno = '{$jobno}'";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

if($exist == 0){ ?> <h4 class="warning" align="center" style="color: red;">No Critical Data</h4> <?php }
else{
	//echo '<h6 class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center" style="color: red;">JOB NO : '.$jobno.'</h6>';
	echo'<table id="dt_critical" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	echo'<thead>';
		echo'<tr>';
			echo'<th>NO</th>';
			echo'<th>PART NUMBER</th>';
			echo'<th>EXPIRED</th>';
			echo'<th>SCAN DATE</th>';
			echo'<th>STATUS</th>';
		echo'</tr>';
	echo'</thead>';
	echo'<tbody>';
	$no = 0;
	
	while(!$rs->EOF){
		$no++;
		$criticalid     = trim($rs->fields['0']);
		$jobno       	= trim($rs->fields['1']);
		$zfeeder  		= trim($rs->fields['2']);
		$partno  		= trim($rs->fields['3']);
		$expdate  		= date_format(date_create($rs->fields['7']), 'd M Y');
		$scannik      	= trim($rs->fields['4']);
		$scandate       = date_format(date_create($rs->fields['5']), 'd M Y');
		$scantime       = date_format(date_create($rs->fields['6']), 'H:i');
	
		echo'<td data-content="NO"><b>'.$no.'.</b></td>';
		echo'<td data-content="PART NUMBER">'.$partno.'</td>';
		echo'<td data-content="EXPIRED">'.$expdate.'</td>';
		echo'<td data-content="SCAN DATE">'.$scandate.' '.$scantime.'</td>';
		echo'<td data-content="Status">OK</td>';
		echo'</tr>';
		$rs->MoveNext();
	}
	echo'</tbody>';
	echo'</table>';
}

$rs->Close();
$db->Close();
$db=null;
?>