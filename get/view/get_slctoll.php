<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik     = isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic     = isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';

$jobno3           = isset($_POST['jobno'])	          ? $_POST['jobno']	            : '';
$model3           = isset($_POST['model'])	          ? $_POST['model']	            : '';
$serial3          = isset($_POST['serial'])	          ? $_POST['serial']	        : '';
$pwbname3         = isset($_POST['pwbname'])	      ? $_POST['pwbname']	        : '';
$proces3          = isset($_POST['proces'])	          ? $_POST['proces']	        : '';
$jdate3           = isset($_POST['jdate'])	          ? $_POST['jdate']	            : '';

$sql1	 = "select jobid, zno, jobdate, jobtime, sts_opstart, op_name, op_startdate, op_starttime, op_endname, op_enddate, op_endtime
			from diff_zfeeder2('{$jobno3}') 
			group by zno, jobdate, jobtime, sts_opstart, op_name, jobid,op_startdate, op_starttime, op_endname, op_enddate, op_endtime";
$rs1      = $db->Execute($sql1);
$exist   = $rs1->RecordCount();
$no      = 0;

if($exist == 0){ echo'<h4 class="warning" align="center" style="color: red;">No Loading List Data</h4>'; }
else{
    echo'<table id="dt_zfeed_oll" class="table table-striped dt_zfeed_oll table-hover col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead align="center">';
			echo'<th><center><INPUT type="checkbox" onchange="checkAll(this)" name="chk[]" /></center></th>';
			echo'<th>NO</th>';
			echo'<th>Z-FEEDER</th>';
		echo'</thead>';
        echo'<tbody>';
		
		while(!$rs1->EOF){
			$no++;
			$jobid      = trim($rs1->fields['0']);
			$zfeeder    = trim($rs1->fields['1']);
			$jobdate    = date_format(date_create($rs1->fields['2']), 'd M Y');
			$jobtime    = date_format(date_create($rs1->fields['3']), 'H:i');
		    $sts_opstart2= trim($rs1->fields['4']);
			$opname1     = trim($rs1->fields['5']);
			$opname     = isset($opname1) ? $opname1 : '<font style="color: red">-</font>';
            echo'<tr>';
				echo'<td align="center">
					<input type="checkbox" name="item[]" id="item[]" value="'.$zfeeder.'" />
					<input type="hidden" name="jobno3" id="jobno3" value="'.$jobid.'" />
					<input type="hidden" name="jdate3" id="jdate3" value="'.$jdate3.'" />
					<input type="hidden" name="model3" id="model3" value="'.$model3.'" />
					<input type="hidden" name="serial3" id="serial3" value="'.$serial3.'" />
					<input type="hidden" name="pwbname3" id="pwbname3" value="'.$pwbname3.'" />
					<input type="hidden" name="proces3" id="proces3" value="'.$proces3.'" />
					<label id="checkanimate"></label>
				</td>';
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
            echo'</tr>';
			$rs1->MoveNext();
		}
	echo'</tbody>';
	echo'</table>';
}


$rs1->Close();
$db->Close();
$db=null;
?>