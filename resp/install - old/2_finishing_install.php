<?php
//start session
ob_start();
session_start();
ob_end_clean();

//set time and call db
date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

//call data
$picknav_nik       = isset($_SESSION['picknav_nik'])   ? $_SESSION['picknav_nik'] : '';
$picknav_pic       = isset($_SESSION['picknav_pic'])   ? $_SESSION['picknav_pic'] : '';
$picknav_levelno   = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno             = isset($_POST['jobno'])           ? $_POST['jobno']             : '';
$jdate             = isset($_POST['jdate'])           ? $_POST['jdate']             : '';
$feederno1          = isset($_POST['feederno'])        ? $_POST['feederno']          : '';
$feederno          = intval($feederno1)-intval(1);

//set variable
$date				= date('Y-m-d');	$time		= date('H:i:s');



$sql_zfeed = "select first 1 skip {$feederno}
				distinct zno_ins 
				from diff_zfeeder_install2('{$jobno}')
				group by zno_ins";
$rs_zfeed = $db->Execute($sql_zfeed);
$zfeed = $rs_zfeed->fields[0];
$rs_zfeed->Close();


/***
**	update JOBDETAIL TABLE
***/ 

///for($i=0; $i<$zfeeder_total; $i++){

	$sql_chk_jobdetail_1   	= "select * from jobdetail 
								where jobno = '{$jobno}' 
									and zfeeder containing '{$zfeed}'
									and sts_install = 1 
									and sts_ins_nik = '{$picknav_nik}'
									and jobdate = '{$jdate}'";
									
	$rs_chk_jobdetail_1    	= $db->Execute($sql_chk_jobdetail_1);
	$jobdetail_sts_1  		= $rs_chk_jobdetail_1->RecordCount();
	$rs_chk_jobdetail_1->Close();
	
	if(!empty($jobdetail_sts_1)){
		//cek unpicking
		$sql_unpicking_1 	= "select distinct count(*) from pn_install('{$jobno}')
								where zfeeder containing '{$zfeed}'
									and (partnumber <> null or partnumber <> '')
									and install is null";
									
		$rs_unpicking_1	 	= $db->Execute($sql_unpicking_1);
		$tot_unpicking_1 	= trim($rs_unpicking_1->fields[0]);
		$rs_unpicking_1->Close();
		
		if ($tot_unpicking_1 == "0"){
			//update data yang masih proses menjadi finish ( status = 1 jadi 2 )
			$sql_updsts_3	= "update jobdetail set 
									sts_install = '2',
									sts_ins_endnik = '{$picknav_nik}',
									sts_ins_endname = '{$picknav_pic}',
									sts_ins_enddate = '{$date}',
									sts_ins_endtime = '{$time}'
								where jobno = '{$jobno}'
									and zfeeder containing '{$zfeed}'
									and jobdate = '{$jdate}'";
									
			$rs_updsts_3 	= $db->Execute($sql_updsts_3);
			$rs_updsts_3->Close();
		
		}
		else{
			//update data yang masih proses menjadi finish ( status = 1 jadi 2 )
			$sql_updsts_4 	= "update jobdetail set 
									sts_install = '4', 
									sts_ins_endnik = '{$picknav_nik}',
									sts_ins_endname = '{$picknav_pic}', 
									sts_ins_enddate = '{$date}',
									sts_ins_endtime = '{$time}' 
								where jobno = '{$jobno}'
									and zfeeder containing '{$zfeed}'
									and jobdate = '{$jdate}'";
									
			$rs_updsts_4 	= $db->Execute($sql_updsts_4);
			$rs_updsts_4->Close();
		}
	}
///}

/***
**	update JOBHEADERINFO TABLE
***/

///if ($i===$zfeeder_total){
	
	// cek data yg status 1 dan null 
	$sql_fnsh_jobheader 		= "select count(*) from jobdetail 
									where jobno= '{$jobno}' 
										and jobdate = '{$jdate}' 
										and (sts_install = '1' or sts_install is null)
										and (partnumber <> null or partnumber <> '')
										and (install is null or install = '')";
										
	$rs_fnsh_jobheader      	= $db->Execute($sql_fnsh_jobheader);
	$exist_fnsh_jobheader   	= $rs_fnsh_jobheader->fields[0];
	$rs_fnsh_jobheader->Close();

	if($exist_fnsh_jobheader  >= 1){
		//update sts_opstart = 5 
		$sql_fnsh_jobheader_2 = "update jobheaderinfo set 
									sts_install = '5',
									sts_ins_enik = '{$picknav_nik}',
									sts_ins_ename = '{$picknav_pic}', 
									sts_ins_edate = '{$date}', 
									sts_ins_etime = '{$time}'
								where jobno = '{$jobno}'
									and jobdate = '{$jdate}'";
									
		$rs_fnsh_jobheader_2 = $db->Execute($sql_fnsh_jobheader_2);
		$rs_fnsh_jobheader_2->Close();
		
	}
	elseif($exist_fnsh_jobheader == 0){
		// cek data yg status 4
		$sql_fnsh_jobheader_3 		= "select count(*) from jobdetail
										where jobno= '{$jobno}' 
											and jobdate = '{$jdate}'
											and (sts_install = '4')";
											
		$rs_fnsh_jobheader_3      = $db->Execute($sql_fnsh_jobheader_3);
		$exist_fnsh_jobheader_3   = $rs_fnsh_jobheader_3->fields[0];
		$rs_fnsh_jobheader_3->Close();
		
		if($exist_fnsh_jobheader_3  >= 1){
			//update sts_opstart = 4 
			$sql_fnsh_jobheader_2 = "update jobheaderinfo set 
										sts_install = '4', 
										sts_ins_enik = '{$picknav_nik}',
										sts_ins_ename = '{$picknav_pic}',
										sts_ins_edate = '{$date}', 
										sts_ins_etime = '{$time}'
									where jobno = '{$jobno}'
										and jobdate = '{$jdate}'";

			$rs_fnsh_jobheader_2 = $db->Execute($sql_fnsh_jobheader_2);
			$rs_fnsh_jobheader_2->Close();
			
		}
		elseif($exist_fnsh_jobheader_3 == 0){
			//update sts_opstart = 2
			$sql_fnsh_jobheader_1 = "update jobheaderinfo set 
										sts_install = '2', 
										sts_ins_enik = '{$picknav_nik}',
										sts_ins_ename = '{$picknav_pic}',
										sts_ins_edate = '{$date}', 
										sts_ins_etime = '{$time}'
									where jobno = '{$jobno}' 
										and jobdate = '{$jdate}'";
			$rs_fnsh_jobheader_1 = $db->Execute($sql_fnsh_jobheader_1);
			$rs_fnsh_jobheader_1->Close();
		}
	}
///}


$db->Close();
$db=null;
