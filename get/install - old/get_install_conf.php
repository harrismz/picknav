<?php
//start session
ob_start();
session_start();
ob_end_clean();
date_default_timezone_set('Asia/Jakarta');

//	include database connection
	include "../../../adodb/con_part_im.php";

//	call session
	$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
	$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
	$picknav_nik    = isset($_POST['nik'])   ? $_POST['nik']  : '';
	$jobno      	= isset($_POST['jobno']) ? $_POST['jobno'] : '';
	$zfeed     		= isset($_POST['zfeed']) ? $_POST['zfeed'] : '';
	$jdate     		= isset($_POST['jdate']) ? $_POST['jdate'] : '';
	
	$sql_minpos = "select distinct zfd from pn_install('{$jobno}')
					where zfd_no = (
						select MIN (distinct zfd_no)
						from pn_install('{$jobno}') 
						where zfeeder containing '{$zfeed}')
					and zfeeder containing '{$zfeed}'";
	$rs_minpos = $db->Execute($sql_minpos);
	$minpos = $rs_minpos->fields[0];
	$rs_minpos->Close();
	
	$sql_maxpos = "select distinct zfd from pn_install('{$jobno}')
					where zfd_no = (
						select MAX (distinct zfd_no)
						from pn_install('{$jobno}') 
						where zfeeder containing '{$zfeed}')
					and zfeeder containing '{$zfeed}'";
	$rs_maxpos = $db->Execute($sql_maxpos);
	$maxpos = $rs_maxpos->fields[0];
	$rs_maxpos->Close();
	
	$sql_check = "select confstart, confend from confinstall 
					where jobdate = '{$jdate}'
					and jobno = '{$jobno}'
					and zfd = '{$zfeed}'";
	$rs_check = $db->Execute($sql_check);
	$checkstart = $rs_check->fields[0];
	$checkend = $rs_check->fields[1];
	$rs_minpos->Close();
	
	echo'<table align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<tr>
				<td> START POSITION </td>
				<td> '.$minpos.' </td>
				<td>';
					if($checkstart == ""){
						echo'<button id="btn-ins-conf1" class="btn-detail"  onclick="insConf(1)">OK</button>';
					}
					else{
						echo'<i class="fa fa-check fa-lg" />';
					}
			echo'</td>
			</tr>
			<tr>
				<td> END POSITION </td>
				<td> '.$maxpos.' </td>
				<td>';
					if($checkend == ""){
						echo'<button id="btn-ins-conf1" class="btn-detail"  onclick="insConf(2)">OK</button>';
					}
					else{
						echo'<i class="fa fa-check fa-lg" />';
					}
			echo'</td>
			</tr>
		</table>';
$db->Close();
$db=null;
?>