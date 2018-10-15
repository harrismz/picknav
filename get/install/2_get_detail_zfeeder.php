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
		if(	smt == "2_install"){
			//remove
			$("#dt_zfeed").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_zfeed").addClass("installClick-table");
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

/*$sql1	 = "select jobid, zno, jobdate, jobtime, sts_opstart, op_name, op_startdate, op_starttime,
        op_endname, op_enddate, op_endtime
		from diff_zfeeder2('{$jobno3}') group by zno, jobdate, jobtime, sts_opstart, op_name, jobid, op_startdate, op_starttime,
        op_endname, op_enddate, op_endtime";
*/		
$sql1	 = "select jobid, zno_ins, jobdate, jobtime, sts_install, sts_ins_startname, sts_ins_endname, 
					sts_ins_startdate, sts_ins_starttime, sts_ins_enddate, sts_ins_endtime, unf_insname, unf_insdate, unf_instime
					from diff_zfeeder_install2_unf('{$jobno3}') 
					group by zno_ins, jobdate, jobtime, sts_install, jobid, sts_ins_startname, sts_ins_endname, 
					sts_ins_startdate, sts_ins_starttime, sts_ins_enddate, sts_ins_endtime, unf_insname, unf_insdate, unf_instime";
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
			$jobid             = trim($rs1->fields[0]);
			$zfeeder           = trim($rs1->fields[1]);
			$jobdate           = date_format(date_create($rs1->fields[2]), 'd M Y');
			$jobtime           = date_format(date_create($rs1->fields[3]), 'H:i');
			$sts_install2      = trim($rs1->fields[4]);
			$sts_sname1        = trim($rs1->fields[5]);
			$sts_ename1        = trim($rs1->fields[6]);
			
			$sts_sdate1     = isset($rs1->fields[7]) ? date_format(date_create($rs1->fields[7]), 'd M Y') : "";
			$sts_stime1     = isset($rs1->fields[8]) ? " (".date_format(date_create($rs1->fields[8]), 'H:i').")" : "";
			$sts_edate1     = isset($rs1->fields[9]) ? date_format(date_create($rs1->fields[9]), 'd M Y') : "";
			$sts_etime1     = isset($rs1->fields[10]) ? " (".date_format(date_create($rs1->fields[10]), 'H:i').")" : "";
			
			$sts_unfname1   = trim($rs1->fields[11]);
			$sts_unfdate1   = isset($rs1->fields[12]) ? date_format(date_create($rs1->fields[9]), 'd M Y') : "";
			$sts_unfitime1  = isset($rs1->fields[13]) ? " (".date_format(date_create($rs1->fields[10]), 'H:i').")" : "";
			
			$sts_sdate2     = $sts_sdate1.$sts_stime1;
			$sts_edate2     = $sts_edate1.$sts_etime1;
			$sts_unfdate2   = $sts_unfdate1.$sts_unfitime1;
			
			if($sts_sdate2 ==""){ $sts_sdate= '<font style="color: gray;">-</font>'; }
			else{ $sts_sdate= trim($sts_sdate2); }
			if($sts_edate2   ==""){ $sts_edate  = '<font style="color: gray;">-</font>'; }
			else{ $sts_edate  = trim($sts_edate2); }
			if($sts_unfdate2   ==""){ $sts_unfdate  = '<font style="color: gray;">-</font>'; }
			else{ $sts_unfdate  = trim($sts_unfdate2); }
			
			if($sts_sname1 ==""){ $sts_sname= '<font style="color: gray;">-</font>'; }
			else{ $sts_sname= $sts_sname1; }
			if($sts_ename1 ==""){ $sts_ename= '<font style="color: gray;">-</font>'; }
			elseif($sts_ename1 ==""){ $sts_ename = $sts_sname; }
			else{ $sts_ename = $sts_ename1; }
			if($sts_unfname1 ==""){ $sts_unfname= '<font style="color: gray;">-</font>'; }
			else{ $sts_unfname= $sts_unfname1; }
			
            if($sts_install2 === "1"){
				echo'<tr style="background-color:yellow !important">';
				echo'<td data-content="ACTION"></td>';
			}
			elseif($sts_install2 === "2"){
				echo'<tr style="background-color:lightgreen !important">';
				echo'<td data-content="ACTION" align="center">
					<button id="btn_unfinish" class="btn-unfinish" onclick="unfinish_zfeed('.$no.')">UNFINISH</button>
					<input type="hidden" name="jobno_detailzfeed'.$no.'" id="jobno_detailzfeed'.$no.'" value="'.$jobid.'" />
					<input type="hidden" name="zfeed_detailzfeed'.$no.'" id="zfeed_detailzfeed'.$no.'" value="'.$zfeeder.'" />
					<input type="hidden" name="jdate_detailzfeed'.$no.'" id="jdate_detailzfeed'.$no.'" value="'.$rs1->fields['2'].'" />
				</td>';
			}
			elseif($sts_install2 === "4"){
				echo'<tr style="background-color:lightblue !important">';
				echo'<td data-content="ACTION" align="center">
					<button id="btn_unfinish" class="btn-unfinish" onclick="unfinish_zfeed('.$no.')">UNFINISH</button>
					<input type="hidden" name="jobno_detailzfeed'.$no.'" id="jobno_detailzfeed'.$no.'" value="'.$jobid.'" />
					<input type="hidden" name="zfeed_detailzfeed'.$no.'" id="zfeed_detailzfeed'.$no.'" value="'.$zfeeder.'" />
					<input type="hidden" name="jdate_detailzfeed'.$no.'" id="jdate_detailzfeed'.$no.'" value="'.$rs1->fields['2'].'" />
				</td>';
			}
			elseif($sts_install2 == ""){
				echo'<tr>';
				echo'<td data-content="ACTION"></td>';
			}
			
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
				echo'<td data-content="START PIC" id="select_pic">'.$sts_sname.'</td>';
				echo'<td data-content="START DATE" >'.$sts_sdate.'</td>';
				echo'<td data-content="END PIC" >'.$sts_ename.'</td>';
				echo'<td data-content="END DATE" >'.$sts_edate.'</td>';
				echo'<td data-content="UNFINISH" >'.$sts_unfname.'</td>';
				echo'<td data-content="DATE" >'.$sts_unfdate.'</td>';
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