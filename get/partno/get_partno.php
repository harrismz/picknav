<?php
//	start session
	session_start();
	date_default_timezone_set('Asia/Jakarta');

//***
//	include database connection
	include "../../../adodb/con_part_im.php";

//***
//	call session
	$picknav_pic 	 = isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
	$picknav_levelno = isset($_SESSION['picknav_levelno'])? $_SESSION['picknav_levelno'] : '';

//***
//	get POST
	$src_sdate   = isset($_POST['src_sdate']) ? $_POST['src_sdate']	 : '';
	$src_edate   = isset($_POST['src_edate']) ? $_POST['src_edate']	 : '';
	$src_model   = isset($_POST['src_model']) ? $_POST['src_model']	 : '';
	$src_partno  = isset($_POST['src_partno'])? $_POST['src_partno']: '';
	$src_jobno   = isset($_POST['src_jobno']) ? $_POST['src_jobno']	 : '';
	$date1 		 = date("Y-m-d", strtotime("-7 Day"));
	$date2 		 = date('Y-m-d');

//***
//	Query
	if($src_sdate == ''){
		$sql 	= "select jobline, point, partnumber, jobmodelname, jobno, pwb_name, process, jobpwbno,
				jobdate, jobtime, jobstartserial, joblotsize, sts_opstart, sts_install 
				from search_partno4('{$date2}','{$date2}','{$src_jobno}','{$src_partno}','{$src_model}')";
		$rs		= $db->Execute($sql);
		$exists	= $rs->RecordCount();
	}
	else{
		$sql 	= "select jobline, point, partnumber, jobmodelname, jobno, pwb_name, process, jobpwbno,
				jobdate, jobtime, jobstartserial, joblotsize, sts_opstart, sts_install 
				from search_partno4('{$src_sdate}','{$src_edate}','{$src_jobno}','{$src_partno}','{$src_model}')";
		$rs		= $db->Execute($sql);
		$exists	= $rs->RecordCount();
	}
	
	

//***
//	Create Tabel
	if($exists == 0){
		echo'<h4 class="warning" align="center" style="color: red;">Data not available</h4>';
	}
	else{
		//***
		//	header
			echo'<table id="dt_partno" align="center">';
			echo'<thead>';
				echo'<th>NO</th>';
				echo'<th>LINE</th>';
				echo'<th>POINT&nbsp;</th>';
				echo'<th>PART NO</th>';
				echo'<th>MODEL NAME</th>';
				echo'<th>JOB NO.</th>';
				echo'<th>PROCESS</th>';
				echo'<th>JOBDATE</th>';
				echo'<th>START<br>SERIAL</th>';
				echo'<th>LOT SIZE</th>';
				echo'<th>PICKING</th>';
				echo'<th>INSTALL</th>';
			echo'</thead>';

		//***
		//	body
			echo'<tbody>';

			$no = 0;
			while(!$rs->EOF){
				$no++;
				$jobline       = isset($rs->fields['0']) ? $rs->fields['0'] : "";
				$point2        = isset($rs->fields['1']) ? $rs->fields['1'] : "";
				$partno		   	 = isset($rs->fields['2']) ? $rs->fields['2'] : "";
				$jobmodelname  = isset($rs->fields['3']) ? $rs->fields['3'] : "";
				$jobno		     = isset($rs->fields['4']) ? $rs->fields['4'] : "";
				$pwbnm	       = isset($rs->fields['5']) ? $rs->fields['5'] : "";
				$process       = isset($rs->fields['6']) ? $rs->fields['6'] : "";
				$jobpwbno      = isset($rs->fields['7']) ? $rs->fields['7'] : "";
				$jobdate       = date_format(date_create($rs->fields['8']), 'd M Y');
				$jobtime       = date_format(date_create($rs->fields['9']), 'H:i');
				$jobstartserial= isset($rs->fields['10']) ? $rs->fields['10'] : "";
				$joblotsize    = isset($rs->fields['11']) ? $rs->fields['11'] : "";
				$sts_picking   = isset($rs->fields['12']) ? $rs->fields['12'] : "";
				$sts_install   = isset($rs->fields['13']) ? $rs->fields['13'] : "";
				$point         = round($point2,2);

				//***
				//	date with no format
					$jdate = $rs->fields['8'];

				//***
				//	join pwb name + process
					if(trim($pwbnm) == "" && trim($process) == ""){ $process = "-"; }
					elseif(trim($pwbnm) == "" && trim($process) != ""){ $process = $process; }
					elseif(trim($pwbnm) != "" && trim($process) == ""){ $process = $pwbnm; }
					elseif(trim($pwbnm) != "" && trim($process) != ""){ $process = $pwbnm.' / '.$process; }

				//***
				//	convert status to string
					if($sts_picking == 1){$sts_picking = '<font class="process">PROCESS</font>';}
					elseif($sts_picking == 2){$sts_picking = '<font class="clear">CLEAR</font>';}
					elseif($sts_picking == 3){$sts_picking = '<font class="passed">PASSED</font>';}
					elseif($sts_picking == 4){$sts_picking = '<font class="unclear">UNCLEAR</font>';}
					elseif($sts_picking == 5){$sts_picking = '<font class="unclear">UNCLEAR</font>';}

					if($sts_install == 1){$sts_install = '<font class="process">PROCESS</font>';}
					elseif($sts_install == 2){$sts_install = '<font class="clear">CLEAR</font>';}
					elseif($sts_install == 3){$sts_install = '<font class="passed">PASSED</font>';}
					elseif($sts_install == 4){$sts_install = '<font class="unclear">UNCLEAR</font>';}
					elseif($sts_install == 5){$sts_install = '<font class="unclear">UNCLEAR</font>';}
/*
					if($sts_checked == 1){$sts_checked = '<font class="process">PROCESS</font>';}
					elseif($sts_checked == 2){$sts_checked = '<font class="clear">CLEAR</font>';}
					elseif($sts_checked == 3){$sts_checked = '<font class="passed">PASSED</font>';}
					elseif($sts_checked == 4){$sts_checked = '<font class="unclear">UNCLEAR</font>';}
					elseif($sts_checked == 5){$sts_checked = '<font class="unclear">UNCLEAR</font>';}
*/
				//***
				//	row
					echo'<tr>';
						echo'<td data-content="NO">'.$no.'.</td>';
						echo'<td data-content="LINE">'.trim($jobline).'</td>';
						echo'<td data-content="POINT">'.trim($point).'</td>';
						echo'<td data-content="PART NO">'.trim($partno).'</td>';
						echo'<td data-content="MODEL NAME">'.trim($jobmodelname).'</td>';
						echo'<td data-content="JOB NO.">'.trim($jobno).'</td>';
						echo'<td data-content="PROCESS">'.trim($process).'</td>';
						echo'<td data-content="JOBDATE">'.$jobdate.'<br>('.$jobtime.')</td>';
						echo'<td data-content="START SERIAL">'.$jobstartserial.'</td>';
						echo'<td data-content="LOT SIZE">'.$joblotsize.'</td>';
						echo'<td data-content="PICKING">'.$sts_picking.'</td>';
						echo'<td data-content="INSTALL">'.$sts_install.'</td>';
					//	echo'<td data-content="CHECKED">'.$sts_checked.'</td>';
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
<script type="text/javascript">
	$(document).ready(function(){
		//color based on menu click
		if(	smt == "partno"){
			//remove
			$("#dt_partno").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_partno").addClass("partnoClick-table");
		}
		return false;
	});
</script>
