<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_smt_feeder.php";
include "../../../adodb/con_part_im.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
        //color based on menu click
		if(	operator == "2_smartInstallDesk"){
			//remove
			$("#dt_installdesk").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_installdesk").addClass("installClick-table");
		}
		
		return false;
		
		$("#snfeeder").focus();
    });
</script>
<?php

//call session
$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
$picknav_nik    = isset($_POST['nik'])   ? $_POST['nik']  : '';
$jobno      	= isset($_POST['jobno']) ? $_POST['jobno'] : '';
$zfeed     		= isset($_POST['zfeed']) ? $_POST['zfeed'] : '';

$sql 	= "  select distinct (b.feeder_id),
		  feeder_date,
		  (select max(a.feeder_time) from feederrecords a
		  where a.jobno = '{$jobno}'
		  and a.feeder_id = b.feeder_id
		  and a.zfeeder = '{$zfeed}')
		  as feeder_time,
		  b.sn
		  from feederrecords b
		  where b.jobno = '{$jobno}'
		  and b.zfeeder = '{$zfeed}'
		  order by feeder_time asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

if($exist == 0){
    ?>
        <h4 class="warning" align="center"><label style="color:red; font-weight:bold;">NOT AVAILABLE</h4>
    <?php
}
else{
	
	echo'<input class="form-control" type="text" name="snfeeder" id="snfeeder" class="" placeholder="SCAN FEEEDER" />';
	
	echo'<table id="dt_installfeeder" align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<thead>';
        echo'<th>NO</th>';
        echo'<th>Z-FEEDER</th>';
        echo'<th>DATE</th>';
        echo'<th>STATUS</th>';
    echo'</thead>';
    echo'<tbody>';
    $no = 0;
    while(!$rs->EOF){
        $no++;
		$zfeeder 	= trim($rs->fields['0']);
		$scan_date	= trim($rs->fields['1']);
		$scan_time	= trim($rs->fields['2']);
		$sn			= trim($rs->fields['3']);
		echo'<tr style="color:green">';
			echo'<td data-content="NO">'.$no.'.</td>';
			echo'<td data-content="Z-FEEDER">'.$sn.'</td>';
			echo'<td data-content="DATE">'.$scan_date.'</td>';
			echo'<td data-content="STATUS">OK</td>';
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