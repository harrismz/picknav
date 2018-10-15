<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
        //color based on menu click
		if(	smt == "smt_picknav"){
			//remove
			$("#dt_zfeed").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_zfeed").addClass("pickingClick-table");
		}
		return false;
    });
</script>
<?php

$picknav_nik     = isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic     = isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';

$jobno3           = isset($_POST['jobno'])	          ? $_POST['jobno']	            : '';
$model3           = isset($_POST['model'])	          ? $_POST['model']	            : '';
$serial3          = isset($_POST['serial'])	          ? $_POST['serial']	        : '';
$jdate3           = isset($_POST['jdate'])	          ? $_POST['jdate']	            : '';

$sql1	 = "select jobid, zno, jobdate, jobtime, sts_opstart, op_name, op_startdate, op_starttime,
        op_endname, op_enddate, op_endtime, unf_name, unf_date, unf_time
		from diff_zfeeder2_unf('{$jobno3}') group by zno, jobdate, jobtime, sts_opstart, op_name, jobid, op_startdate, op_starttime,
        op_endname, op_enddate, op_endtime, unf_name, unf_date, unf_time";
$rs1      = $db->Execute($sql1);
$exist   = $rs1->RecordCount();
$no      = 0;

if($exist == 0){ echo'<h4 class="warning" align="center" style="color: red;">No Loading List Data</h4>'; }
else{
    echo'<table id="dt_zfeed" class="table table-striped table-hover col-xs-12 col-sm-12 col-md-12 col-lg-12" border="1">';
		echo'<thead align="center">';
			echo'<th><center>ACTION</center></th>';
			echo'<th>NO</th>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>START PIC</th>';
			echo'<th>START DATE</th>';
			echo'<th>END PIC</th>';
			echo'<th>END DATE</th>';
			echo'<th>UNFINISH</th>';
			echo'<th>DATE</th>';
		echo'</thead>';
        echo'<tbody>';
		
		while(!$rs1->EOF){
			$no++;
			$jobid             = trim($rs1->fields['0']);
			$zfeeder           = trim($rs1->fields['1']);
			$jobdate           = date_format(date_create($rs1->fields['2']), 'd M Y');
			$jobtime           = date_format(date_create($rs1->fields['3']), 'H:i');
			$sts_opstart2      = trim($rs1->fields['4']);
			$opname1           = trim($rs1->fields['5']);
			
			$op_startdate1     = isset($rs1->fields['6']) ? date_format(date_create($rs1->fields['6']), 'd M Y') : "";
			$op_starttime1     = isset($rs1->fields['7']) ? " (".date_format(date_create($rs1->fields['7']), 'H:i').")" : "";
			$op_endname1       = trim($rs1->fields['8']);
			$op_enddate1       = isset($rs1->fields['9']) ? date_format(date_create($rs1->fields['9']), 'd M Y') : "";
			$op_endtime1       = isset($rs1->fields['10']) ? " (".date_format(date_create($rs1->fields['10']), 'H:i').")" : "";
			$op_unf_name1      = trim($rs1->fields['11']);
			$op_unf_date1      = isset($rs1->fields['12']) ? date_format(date_create($rs1->fields['9']), 'd M Y') : "";
			$op_unf_time1      = isset($rs1->fields['13']) ? " (".date_format(date_create($rs1->fields['10']), 'H:i').")" : "";
			
			$op_startdate2     = $op_startdate1.$op_starttime1;
			$op_enddate2       = $op_enddate1.$op_endtime1;
			$op_unf_date2      = $op_unf_date1.$op_unf_time1;
			
			if($op_startdate2 ==""){ $op_startdate= '<font style="color: gray;">-</font>'; }
			else{ $op_startdate= trim($op_startdate2); }
			if($op_enddate2   ==""){ $op_enddate  = '<font style="color: gray;">-</font>'; }
			else{ $op_enddate  = trim($op_enddate2); }
			if($op_unf_date2   ==""){ $op_unf_date  = '<font style="color: gray;">-</font>'; }
			else{ $op_unf_date  = trim($op_unf_date2); }
			
			if($opname1 ==""){ $opname= '<font style="color: gray;">-</font>'; }
			else{ $opname= $opname1; }
			if($op_enddate2 ==""){ $op_endname= '<font style="color: gray;">-</font>'; }
			elseif($op_endname1 ==""){ $op_endname = $opname; }
			else{ $op_endname = $op_endname1; }
			if($op_unf_name1 ==""){ $op_unf_name = $op_unf_name1; }
			else{ $op_unf_name = $op_unf_name1; }
			
            if($sts_opstart2 === "1"){
				echo'<tr style="background-color:yellow !important">';
				echo'<td data-content="ACTION"></td>';
			}
			elseif($sts_opstart2 === "2"){
				echo'<tr style="background-color:lightgreen !important">';
				echo'<td data-content="ACTION" align="center">
					<button id="btn_unfinish" class="btn-unfinish" onclick="unfinish_zfeed('.$no.')">UNFINISH</button>
					<input type="hidden" name="jobno_detailzfeed'.$no.'" id="jobno_detailzfeed'.$no.'" value="'.$jobid.'" />
					<input type="hidden" name="zfeed_detailzfeed'.$no.'" id="zfeed_detailzfeed'.$no.'" value="'.$zfeeder.'" />
					<input type="hidden" name="jdate_detailzfeed'.$no.'" id="jdate_detailzfeed'.$no.'" value="'.$rs1->fields['2'].'" />
				</td>';
			}
			elseif($sts_opstart2 === "4"){
				echo'<tr style="background-color:lightblue !important">';
				echo'<td data-content="ACTION" align="center">
					<button id="btn_unfinish" class="btn-unfinish" onclick="unfinish_zfeed('.$no.')">UNFINISH</button>
					<input type="hidden" name="jobno_detailzfeed'.$no.'" id="jobno_detailzfeed'.$no.'" value="'.$jobid.'" />
					<input type="hidden" name="zfeed_detailzfeed'.$no.'" id="zfeed_detailzfeed'.$no.'" value="'.$zfeeder.'" />
					<input type="hidden" name="jdate_detailzfeed'.$no.'" id="jdate_detailzfeed'.$no.'" value="'.$rs1->fields['2'].'" />
				</td>';
			}
			elseif($sts_opstart2 == ""){
				echo'<tr>';
				echo'<td data-content="ACTION"></td>';
			}
			
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
				echo'<td data-content="START PIC" id="select_pic">'.$opname.'</td>';
				echo'<td data-content="START DATE" >'.$op_startdate.'</td>';
				echo'<td data-content="END PIC" >'.$op_endname.'</td>';
				echo'<td data-content="END DATE" >'.$op_enddate.'</td>';
				echo'<td data-content="UNFINISH" >'.$op_unf_name.'</td>';
				echo'<td data-content="DATE" >'.$op_unf_date.'</td>';
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