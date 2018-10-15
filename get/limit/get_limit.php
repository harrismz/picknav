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
//	No Input
	if(empty($src_sdate) && empty($src_edate) && empty($src_model) && empty($src_partno) && empty($src_jobno)){		
		//echo '<br>---no input--<br><br>';
		$where2 = "where a.jobdate='{$date2}'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model
	elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && empty($src_partno) && empty($src_jobno)){	   
		//echo '<br>---Model--<br><br>';
		$where2 = "where a.jobmodelname like '$src_model%' 
					and a.jobdate>='{$date1}' 
					and a.jobdate<='{$date2}'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model + date
	elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && empty($src_partno) && empty($src_jobno)){    
		//echo '<br>---Model + date--<br><br>';
		$where2 = "where a.jobmodelname like '$src_model%' 
					and a.jobdate>='$src_sdate'
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Partno
	elseif(empty($src_sdate) && empty($src_edate) && empty($src_model) && $src_partno != "" && empty($src_jobno)){    
		//echo '<br>---Partno--<br><br>';
		$where2 = "where d.partnumber containing '$src_partno' 
					and a.jobdate>='{$date1}' 
					and a.jobdate<='{$date2}'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
//***
//	Partno + Date
	elseif($src_sdate != "" && $src_edate != "" && empty($src_model) && $src_partno != "" && empty($src_jobno)){    
		//echo '<br>---Partno + Date--<br><br>';
		$where2 = "where d.partnumber containing '$src_partno' 
					and a.jobdate>='$src_sdate' 
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
	
//***
//	Jobno
	elseif(empty($src_sdate) && empty($src_edate) && empty($src_model) && empty($src_partno) && $src_jobno != ""){    
		//echo '<br>---Jobno--<br><br>';
		$where2 = "where c.jobno = '$src_jobno' 
					and a.jobdate>='{$date1}' 
					and a.jobdate<='{$date2}'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Jobno + Date
	elseif($src_sdate != "" && $src_edate != "" && empty($src_model) && empty($src_partno) && $src_jobno != ""){    
		//echo '<br>---Jobno + Date--<br><br>';
		$where2 = "where c.jobno = '$src_jobno' 
					and a.jobdate>='$src_sdate' 
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model + Partno	
	elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_partno != "" && empty($src_jobno)){    
		//echo '<br>---Model + Partno--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
					and d.partnumber containing '$src_partno' 
					and a.jobdate>='{$date2}' 
					and a.jobdate<='{$date}'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model + Partno + Date
	elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_partno != "" && empty($src_jobno)){    
		//echo '<br>---Model + Partno + Date--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
					and  d.partnumber containing '$src_partno' 
					and  a.jobdate>='$src_sdate' 
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model + Jobno
	elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && empty($src_partno) && $src_jobno != ""){    
		//echo '<br>---Model + Jobno--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
						and c.jobno = '$src_jobno'
						and a.jobdate>='{$date2}' 
						and a.jobdate<='{$date}'
						and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
	
//***
//	Model + Jobno + Date
	elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && empty($src_partno) && $src_jobno != ""){    
		//echo '<br>---Model + Jobno + Date--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
					and c.jobno = '$src_jobno'
					and a.jobdate>='$src_sdate'
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Partno + Jobno
	elseif(empty($src_sdate) && empty($src_edate) && empty($src_model)  && $src_partno != "" && $src_jobno != ""){    
		//echo '<br>---Partno + Jobno--<br><br>';
		$where2 = "where  c.jobno like '$src_jobno%' 
						and d.partnumber containing '$src_partno' 
						and a.jobdate>='{$date2}' 
						and a.jobdate<='{$date}'
						and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
	
//***
//	Partno + Jobno + Date
	elseif($src_sdate != "" && $src_edate != "" && empty($src_model)  && $src_partno != "" && $src_jobno != ""){    
		//echo '<br>---Partno + Jobno + Date--<br><br>';
		$where2 = "where  c.jobno like '$src_jobno%' 
					and  d.partnumber containing '$src_partno' 
					and  a.jobdate>='$src_sdate'
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
	
//***
//	Model + Partno + Jobno	
	elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_partno != "" && $src_jobno != ""){    
		//echo '<br>---Model + Partno + Jobno--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
						and d.partnumber containing '$src_partno'
						and c.jobno = '$src_jobno'
						and a.jobdate>='{$date2}'
						and a.jobdate<='{$date}'
						and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}

//***
//	Model + Partno + Jobno + Date
	elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_partno != "" && $src_jobno != ""){    
		//echo '<br>---Model + Partno + Jobno + Date--<br><br>';
		$where2 = "where  a.jobmodelname like '$src_model%' 
						and d.partnumber containing '$src_partno'
						and c.jobno = '$src_jobno'
						and a.jobdate>='$src_sdate'
						and  a.jobdate<='$src_edate'
						and partnumber <> ''
						and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
	}
	
//***
//	Date Only
	else{ 
		//echo '<br>---Date Only--<br><br>';
		$where2 = "where a.jobdate>='$src_sdate' 
					and  a.jobdate<='$src_edate'
					and partnumber <> ''
					and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')
					and (a.sts_install is null 
						or a.sts_install = '1' 
						or a.sts_install = '3' 
						or a.sts_install = '4' 
						or a.sts_install = '5')";
	}
	
//***
//	Query

	$sql 	= "select distinct a.jobline, c.jobno, d.zfeeder, a.jobmodelname, d.partnumber, d.loose_reel, 
					d.full_reel, b.pwb_name, b.process, a.jobpwbno, a.jobdate, a.jobtime, a.sts_opstart,
					a.sts_install, a.sts_checked
				from jobheaderinfo a
					left join jobmodel b on a.jobno=b.jobno
					left join joblist c on a.jobno=c.jobno
					left join jobdetail d on a.jobno=d.jobno
				$where2 
					order by a.jobline, (a.jobdate||a.jobtime) desc";
	$rs		= $db->Execute($sql);
	$exists	= $rs->RecordCount();

//***
//	Create Tabel
	if($exists == 0){
		echo'<h4 class="warning" align="center" style="color: red;">Data not available</h4>';
	}
	else{
		//***
		//	header
			echo'<table id="dt_limit" align="center">';
			echo'<thead>';
				echo'<th>NO</th>';
				echo'<th>LINE</th>';
				echo'<th>JOB NO</th>';
				echo'<th>Z-FEEDER</th>';
				echo'<th>MODEL NAME</th>';
				echo'<th>PART NO</th>';
				echo'<th>LOOSE REEL</th>';
				echo'<th>FULL REEL</th>';
				echo'<th>PROCESS</th>';
				echo'<th hidden="true">PWB NO</th>';
				echo'<th>JOBDATE</th>';
				echo'<th>PICKING</th>';
				echo'<th>INSTALL</th>';
				echo'<th>CHECKED</th>';
			echo'</thead>';
        
		//***
		//	body
			echo'<tbody>';
		
			$no = 0;
			while(!$rs->EOF){
				$no++;
				$jobline       = isset($rs->fields['0']) ? $rs->fields['0'] : "";
				$jobno		   = isset($rs->fields['1']) ? $rs->fields['1'] : "";
				$zfeeder       = isset($rs->fields['2']) ? $rs->fields['2'] : "";
				$jobmodelname  = isset($rs->fields['3']) ? $rs->fields['3'] : "";
				$partno		   = isset($rs->fields['4']) ? $rs->fields['4'] : "";
				$loose		   = isset($rs->fields['5']) ? $rs->fields['5'] : "";
				$full		   = isset($rs->fields['6']) ? $rs->fields['6'] : "";
				$pwbnm	       = isset($rs->fields['7']) ? $rs->fields['7'] : "";
				$process       = isset($rs->fields['8']) ? $rs->fields['8'] : "";
				$jobpwbno      = isset($rs->fields['9']) ? $rs->fields['9'] : "";
				$jobdate       = date_format(date_create($rs->fields['10']), 'd M Y');
				$jobtime       = date_format(date_create($rs->fields['11']), 'H:i');
				$sts_picking   = isset($rs->fields['12']) ? $rs->fields['12'] : "";
				$sts_install   = isset($rs->fields['13']) ? $rs->fields['13'] : "";
				$sts_checked   = isset($rs->fields['14']) ? $rs->fields['14'] : "";
				
				//***
				//	date with no format
					$jdate = $rs->fields['10'];
				
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
					
					if($sts_checked == 1){$sts_checked = '<font class="process">PROCESS</font>';}
					elseif($sts_checked == 2){$sts_checked = '<font class="clear">CLEAR</font>';}
					elseif($sts_checked == 3){$sts_checked = '<font class="passed">PASSED</font>';}
					elseif($sts_checked == 4){$sts_checked = '<font class="unclear">UNCLEAR</font>';}
					elseif($sts_checked == 5){$sts_checked = '<font class="unclear">UNCLEAR</font>';}
				
				//***
				//	row
					echo'<tr>'; 
						echo'<td data-content="NO">'.$no.'.</td>';
						echo'<td data-content="LINE">'.trim($jobline).'</td>';
						echo'<td data-content="JOB NO">'.trim($jobno).'</td>';
						echo'<td data-content="Z-FEEDER">'.trim($zfeeder).'</td>';
						echo'<td data-content="MODEL NAME">'.trim($jobmodelname).'</td>';
						echo'<td data-content="PART NO">'.trim($partno).'</td>';
						echo'<td data-content="LOOSE REEL">'.trim($loose).'</td>';
						echo'<td data-content="FULL REEL">'.trim($full).'</td>';
						echo'<td data-content="PROCESS">'.trim($process).'</td>';
						echo'<td data-content="PWB NO" hidden="true">'.trim($jobpwbno).'</td>';
						echo'<td data-content="JOBDATE">'.$jobdate.'<br>('.$jobtime.')</td>';
						echo'<td data-content="PICKING">'.$sts_picking.'</td>';
						echo'<td data-content="INSTALL">'.$sts_install.'</td>';
						echo'<td data-content="CHECKED">'.$sts_checked.'</td>';
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
		if(	smt == "limit"){
			//remove
			$("#dt_limit").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_limit").addClass("limitClick-table");
		}
		return false;
	});
</script>