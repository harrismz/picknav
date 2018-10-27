<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
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
    });
</script>
<?php

//call session
$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
$picknav_nik    = isset($_POST['nik'])   ? $_POST['nik']  : '';
$get_jobno      = isset($_POST['jobno']) ? $_POST['jobno'] : '';
$feederno1      = isset($_POST['feederno']) ? $_POST['feederno'] : '0';

/*if($feederno1>=1){
	$feederno    = intval($feederno1) - intval(1);
}
else{
	$feederno    = 0;
}*/

$feederno = intval($feederno1)-intval(1);
	if($feederno <= 0){
		$feederno = 0;
	}

$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');

///$get_zfeed4  = isset($_POST['zfeed']) ? $_POST['zfeed']	: '';
///$get_zfeed3		= str_replace("+"," ",$get_zfeed4);
///$get_zfeed2		= str_replace("::","#",$get_zfeed3);
///$get_zfeed      = explode("|",$get_zfeed2);
///$zfeeder_total  = count($get_zfeed);
///$zfeeder_zfd = "";
///
///for($i=0; $i<$zfeeder_total; $i++){
///	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."'";
///	$zfeeder_zfd 			= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."' or";
///}



$sql_zfeed = "select first 1 skip {$feederno}
				distinct zno_ins 
				from diff_zfeeder_install2('{$get_jobno}')
				group by zno_ins";
//				where sts_install = 1
$rs_zfeed = $db->Execute($sql_zfeed);
$zfeed_ins = $rs_zfeed->fields[0];
$rs_zfeed->Close();

$sql 	= "select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			 install, ket, zfd_name, zfd_no, zfd_tray,
			 install_nik, install_name, install_date, install_time
            from pn_install('{$get_jobno}')
            where zfeeder containing '{$zfeed_ins}'
            order by install_date||install_time desc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

$sql_uncheck_install = "select count(*)
						from pn_install('{$get_jobno}')
						where zfeeder containing '{$zfeed_ins}'
						and (install is null or install = '')
						and (partnumber <> null or partnumber <> '')";
$rs_uncheck_install	= $db->Execute($sql_uncheck_install);
$rs_uncheck_install->Close();
$tot_uncheck_install = trim($rs_uncheck_install->fields[0]);

$sql_sts 	= "select distinct sts_install
				from diff_zfeeder_install2('{$get_jobno}')
				where zfeeder containing '{$zfeed_ins}'";
$rs_sts		= $db->Execute($sql_sts);
$sts	= $rs_sts->fields[0];
if 		($sts == '1'){ $stsinstal = '<font style="color: yellow; background-color: red"><b>STATUS : PROCESS</b></font>'; }
else if ($sts == '2'){ $stsinstal = '<font style="color: green;"><b>STATUS : CLEAR</b></font>'; }
else if ($sts == '3'){ $stsinstal = '<font style="color: red;"><b>STATUS : PASSED</b></font>'; }
else if ($sts == '4'){ $stsinstal = '<font style="color: red;"><b>STATUS : UNCLEAR</b></font><br>&nbsp;<br><font style="color: navy;">Please Call Administator,<br>If you want to start this Z-Feeder.</font>'; }
else if ($sts == '5'){ $stsinstal = '<font style="color: red;">STATUS : UNCLEAR</b></font><br>&nbsp;<br><font style="color: navy;">Please Call Administator,<br>&nbsp;<br>If you want to start this Z-Feeder.</font>'; }

if($exist == 0){
		echo'<input type="hidden" id="uncheck" value="'.$tot_uncheck_install.'" />';
    ?>
        <h4 class="warning" align="center" id="info"><?=$stsinstal?></h4>
    <?php
}
else{
	echo'<input type="hidden" id="info" value="" />';
	echo'<input type="hidden" id="uncheck" value="'.$tot_uncheck_install.'" />';
    //echo'<table id="dt_installdesk" align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<table id="dt_installdesk" align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<thead>';
        echo'<th>NO</th>';
        //echo'<th>ADDRS</th>';
        echo'<th>Z-FEEDER</th>';
        echo'<th>POL</th>';
        echo'<th>POS</th>';
        echo'<th>W / FS</th>';
        echo'<th>P / SP</th>';
        echo'<th>PART NUMBER</th>';
        echo'<th>ADDRS</th>';
        echo'<th>DEMAND</th>';
        //echo'<th>LOOSE REEL</th>';
        //echo'<th>FULL REEL</th>';
        echo'<th>INSTALL</th>';
        echo'<th>KET</th>';
    echo'</thead>';
    echo'<tbody>';
    $no = 0;
    while(!$rs->EOF){
        $no++;
		$zfeeder = trim($rs->fields['0']);
		$pol     = trim($rs->fields['1']);
		$pos_val = trim($rs->fields['2']);
		$pos1_val= trim($rs->fields['3']);
        if($pos_val == "" and $pos1_val == ""){
            $pos = '';
        }
        elseif($pos_val != "" and $pos1_val == ""){
            $pos = $pos_val;
        }
        elseif($pos_val == "" and $pos1_val != ""){
            $pos = $pos1_val;
        }
        elseif($pos_val != "" and $pos1_val != ""){
            $pos = $pos_val."(".$pos1_val.")";
        }
		$w_fs             = trim($rs->fields['4']);
		$p_sp             = trim($rs->fields['5']);
		$addrs            = trim($rs->fields['6']);
		$partnumber       = $rs->fields['7'];
		$point            = trim($rs->fields['8']);
		$demand           = trim($rs->fields['9']);
		$install          = $rs->fields['10'];
		$ket              = trim($rs->fields['11']);
		$zfd_name         = trim($rs->fields['12']);
		$zfd_no           = trim($rs->fields['13']);
		$zfd_tray         = trim($rs->fields['14']);
		$install_nik      = trim($rs->fields['15']);
		$install_name     = trim($rs->fields['16']);
		$install_date     = trim($rs->fields['17']);
		$install_time     = trim($rs->fields['18']);
		$zfd_join         = $zfd_name.'-'.$zfd_no.' #'.$zfd_tray;
		
	    if($install != ""){
             echo'<tr style="background-color:#d3f8d3">';
                echo'<td data-content="NO">'.$no.'.</td>';
                echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
                echo'<td data-content="POL">'.$pol.'</td>';
                echo'<td data-content="POS">'.$pos.'</td>';
                echo'<td data-content="W / FS">'.$w_fs.'</td>';
                echo'<td data-content="P / SP">'.$p_sp.'</td>';
                echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
                echo'<td data-content="ADDRS">'.$addrs.'</td>';
                echo'<td data-content="DEMAND">'.$demand.'</td>';
                
                    if($install === "OK"){
                        echo'<td data-content="INSTALL" style="color:  #009688;"><b>'.$install.'</b>';
						echo'<i id="cancl_install" class="fa fa-window-close fa-lg pull-right" style="color: gray;" onclick="cancelInstall('.$no.')"></i>';
						echo'<input type="hidden" name="partno_cancel'.$no.'" id="partno_cancel'.$no.'" value="'.$partnumber.'" />
						<input type="hidden" name="zfeeder_cancel'.$no.'" id="zfeeder_cancel'.$no.'" value="'.$zfeeder.'" />
						<input type="hidden" name="pos_cancel'.$no.'" id="pos_cancel'.$no.'" value="'.$pos_val.'" />';
						echo'</td>';
					}
                    else{
                        echo'<td data-content="INSTALL" style="color: red;"><b>--</b></td>';
                    }
                echo'<td data-content="KET">'.$ket.'</td>';
            echo'</tr>';
        }
		elseif(trim($partnumber) == ""){
             echo'<tr style="background-color:#455a64; color: #fff;">';
                echo'<td data-content="NO">'.$no.'.</td>';
                echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
                echo'<td data-content="POL">'.$pol.'</td>';
                echo'<td data-content="POS">'.$pos.'</td>';
                echo'<td data-content="W / FS">'.$w_fs.'</td>';
                echo'<td data-content="P / SP">'.$p_sp.'</td>';
                echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
                echo'<td data-content="ADDRS">'.$addrs.'</td>';
                echo'<td data-content="DEMAND">'.$demand.'</td>';
                
                    if($install === "OK"){
                        echo'<td data-content="INSTALL" style="color:  #009688;"><b>'.$install.'</b>';
						echo'<i id="cancl_install" class="fa fa-ban fa-lg pull-right" style="color: red;" onclick="cancelInstall('.$no.')"></i>';
						echo'<input type="hidden" name="partno_cancel'.$no.'" id="partno_cancel'.$no.'" value="'.$partnumber.'" />
						<input type="hidden" name="zfeeder_cancel'.$no.'" id="zfeeder_cancel'.$no.'" value="'.$zfeeder.'" />
						<input type="hidden" name="pos_cancel'.$no.'" id="pos_cancel'.$no.'" value="'.$pos_val.'" />';
						echo'</td>';
					}
                    else{
                        echo'<td data-content="INSTALL" style="color: red;"><b>--</b></td>';
                    }
                echo'<td data-content="KET">'.$ket.'</td>';
            echo'</tr>';
        }
        else{
            echo'<tr style="color:red">';
                echo'<td data-content="NO">'.$no.'.</td>';
                echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
                echo'<td data-content="POL">'.$pol.'</td>';
                echo'<td data-content="POS">'.$pos.'</td>';
                echo'<td data-content="W / FS">'.$w_fs.'</td>';
                echo'<td data-content="P / SP">'.$p_sp.'</td>';
                echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
                echo'<td data-content="POINT">'.$addrs.'</td>';
                echo'<td data-content="DEMAND">'.$demand.'</td>';
				echo'<td data-content="INSTALL" style="color: green; font-size: 20px;"><b>'.$install.'</b></td>';
				echo'<td data-content="KET">'.$ket.'</td>';
            echo'</tr>';
        }
       $rs->MoveNext();
    }
    echo'</tbody>';
    echo'</table>';
}

$rs->Close();
$db->Close();
$db=null;
?>