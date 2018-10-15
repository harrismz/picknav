<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../adodb/con_part_im.php";
//call session
$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
$picknav_nik    = isset($_GET['nik'])   ? $_GET['nik']  : '';
$get_jobno      = isset($_GET['jobno']) ? $_GET['jobno'] : '';
$get_zfeed4     = isset($_GET['zfeed']) ? $_GET['zfeed'] : '';
$get_zfeed3		= str_replace("+"," ",$get_zfeed4);
$get_zfeed2		= str_replace("::","#",$get_zfeed3);
$get_zfeed      = explode("|",$get_zfeed2);
$zno_total	    = count($get_zfeed);
$zfeeder_total  = count($get_zfeed);
$row            = isset($_GET['row']) ? $_GET['row'] : '0';

$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');


$zno_feedergroup  = "";
$zno_zfd = "";
$zfeeder_feedergroup  = "";
$zfeeder_zfd = "";

for($i=0; $i<$zno_total; $i++){
	$zno_feedergroup 	= $zno_zfd. " zfd_name containing '".$get_zfeed[$i]."'";
	$zno_zfd 			= $zno_zfd. " zfd_name containing '".$get_zfeed[$i]."' or";
}
for($j=0; $j<$zfeeder_total; $j++){
	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfd_name containing '".$get_zfeed[$j]."'";
	$zfeeder_zfd 			= $zfeeder_zfd. " zfd_name containing '".$get_zfeed[$j]."' or";
}
    
$sql 	= "select first 1 skip {$row} ins_zfeeder, ins_pol, ins_pos, ins_pos1, ins_w_fs, ins_p_sp, ins_addrs,     
            ins_partnumber, ins_point, ins_demand, install, sts_install, ins_ket, ins_jobdate, ins_jobtime
            from smart_install('{$get_jobno}') where ({$zno_feedergroup})
            order by zfd_name, zfd_no asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

$sql3 	    = "SELECT COUNT(*) FROM smart_install('{$get_jobno}') where ({$zno_feedergroup})";
$rs3		= $db->Execute($sql3);
$totcount	= $rs3->fields['0'];

if($exist == 0){
    ?>
        <h4 class="warning" align="center" style="color: red;">No Joblist Data</h4>
    <?php
}
else{
    while(!$rs->EOF){
        $zfeeder    = $rs->fields['0'];
        $pol	    = isset($rs->fields['1']) ? $rs->fields['1'] : '<font style="color: red">NULL</font>';
        $pos_val    = $rs->fields['2'];
        $pos1_val    = $rs->fields['3'];
        $w_fs	    = isset($rs->fields['4']) ? $rs->fields['4'] : '<font style="color: red">NULL</font>';
        $p_sp	    = isset($rs->fields['5']) ? $rs->fields['5'] : '<font style="color: red">NULL</font>';
        $addrs	    = isset($rs->fields['6']) ? $rs->fields['6'] : '<font style="color: red">NULL</font>';
        $partnumber	= isset($rs->fields['7']) ? $rs->fields['7'] : '<font style="color: red">NULL</font>';
        $point	    = isset($rs->fields['8']) ? $rs->fields['8'] : '<font style="color: red">NULL</font>';
        $demand	    = isset($rs->fields['9']) ? $rs->fields['9'] : '<font style="color: red">NULL</font>';
        $demand2	= isset($rs->fields['9']) ? $rs->fields['9'] : '0';
        $install	= isset($rs->fields['10']) ? $rs->fields['10'] : '<font style="color: gray">-</font>';
        $sts_install= isset($rs->fields['11']) ? $rs->fields['11'] : '<font style="color: gray">-</font>';
        $ket	    = isset($rs->fields['12']) ? $rs->fields['12'] : '';
        $jobdate    = $rs->fields['13'];
        $jobtime    = $rs->fields['14'];
        
		if($pos_val == "" and $pos1_val == ""){ $pos = '<font style="color: red">NULL</font>'; }
        elseif($pos_val != "" and $pos1_val == ""){ $pos = $pos_val; }
        elseif($pos_val == "" and $pos1_val != ""){ $pos = $pos1_val; }
        elseif($pos_val != "" and $pos1_val != ""){  $pos = $pos_val."(".$pos1_val.")"; }
        
		$row_show = $row+1;
        
		echo'<div id="board">';
            echo'<table id="tbl_main">';
                 echo'<tr>';
                    echo'<td colspan="4" >';
                        echo'<table id="tbl_sp_header">';
                            echo'<tr>';
                                //echo'<td class="sp_hd_judul_ins" align="left">POL</td>';
                                //echo'<td class="sp_hd_judul_ins" align="left">POS</td>';
                                echo'<td class="sp_hd_judul_ins" align="left">W/FS</td>';
                                echo'<td class="sp_hd_judul_ins" align="left">P/SP</td>';
                                echo'<td class="sp_hd_judul_ins" align="left">Point</td>';
                                //echo'<td class="sp_hd_judul_ins" align="left">Demand</td>';
                                //echo'<td class="sp_hd_judul_ins" align="left">Baris</td>';
                                echo'<td class="sp_hd_judul_ins" align="left">Baris ke</td>';
                            echo'</tr>';
                            echo'<tr>';
                                //echo'<td class="sp_hd_isi" align="right">'.$pol.'</td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$pos.'</td>';
                                echo'<td class="sp_hd_isi" align="right">'.$w_fs.'</td>';
                                echo'<td class="sp_hd_isi" align="right">'.$p_sp.'</td>';
                                echo'<td class="sp_hd_isi" align="right">'.$point.'</td>';
                                //echo'<td class="sp_hd_isi" align="right" id="demand_val">'.$demand.'</td>';
                               // echo'<td class="sp_hd_isi" align="right">'.$row_show.'</td>';
                                echo'<td class="sp_hd_isi_row" align="center">';
                                   // echo'<input type="number" id="slct_row" name="slct_row" value="'.$row_show.'"/>';
                                    echo'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="width: 200px;">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="slct_row" name="slct_row" value="'.$row_show.'"/>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-danger slct_row" onclick="select_row()">
                                                        View ';
                                                        //<input type="file" id="upl_drw" name="upl_drw[]" style="display: none;" accept="image/*" multiple>
                                                    echo'</span>
                                                </label>
                                            </div>
                                        </div>';
                                echo'</td>';
                            echo'</tr>';
                        echo'</table>';
                    echo'</td>';
                echo'</tr>';
                echo'<tr id="judul_atas">';
                    echo'<td colspan="4">';
                        echo'<table id="tbl_sp_main">';
                            echo'<tr>';
                                echo'<td class="sp_judul_atas_blank_ins" align="right">&nbsp;</td>';
								echo'<td class="sp_judul_atas_pos" align="left">POS</td>';
                                echo'<td class="sp_judul_atas_feeder" >Z-FEEDER</td>';
								echo'<td class="sp_hd_judul_ins" align="left">Demand</td>';
                                
                            echo'</tr>';
							echo'<tr>';
								echo'<td class="sp_isi_blank_ins" align="right">&nbsp;</td>';
								echo'<td class="sp_isi_pos" align="right">'.$pos.'</td>';
                                echo'<td class="sp_isi_feeder" >'.$zfeeder.'</td>';
						        echo'<td class="sp_hd_isi" align="right" id="demand_val">'.$demand.'</td>';
                            echo'</tr>';
                        echo'</table>';
                    echo'</td>';
                echo'</tr>';
                echo'<tr>';
                    echo'<td>&nbsp;</td>';
                    echo'<td>';
                        echo'<table id="tbl_sp_main">';
                            echo'<tr>';
                                echo'<td class="sp_judul">PART NUMBER</td>';
                                echo'<td class="sp_judul" align="center" colspan="2">INSTALL</td>';
                            echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_isi_partname" rowspan="1">'.$partnumber.'</td>';
                                echo'<td class="sp_isi_reel">';
                                    if($install == 'OK'){
                                        echo'<b style="color:green;">'.$install.'</b>';
                                    }
                                    else{
                                        echo'<b style="color:gray;">--</b>';
                                    }
                                echo'</td>';
                            echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_judul" >KETERANGAN</td>';
                                echo'<td class="sp_isi" rowspan="2">';
                                        //echo '<select name="check_loose_reel" id="check_loose_reel" onchange="saveLooseReel('.$date2.','.$addrs.','.$zfeeder.','.$partnumber.')">
                                        echo '<select name="check_install" id="check_install" onchange="saveInstall(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\',\''.$demand2.'\')">
                                            <option value="-"> -Conf- </option>
                                            <option value="OK">OK</option>
                                        </select>';
		                       echo'</td>';
							echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_isi"><input type="text" id="ket" name="ket" value=\''.$ket.'\' onkeyup="saveKet(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\')" style="text-align: center;" /></td>';
                            echo'</tr>';
                        echo'</table>';
                    echo'</td>';
                    echo'<td>&nbsp;</td>';
                echo'</tr>';
                echo'<tr>';
                    echo'<td colspan="4" class="sp_footer">';
                        echo'<button class="btn-previous" onclick="prev_list()"><i class="fa fa-arrow-left fa-lg"></i>&nbsp;&nbsp;PREVIOUS</button>';
                        echo'<button class="btn-back" onclick="back_install()"><i class="fa fa-undo fa-lg"></i>&nbsp;&nbsp;HOME</button>';
                        echo'<button class="btn-partlist" onclick="show_install()"><i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;SHOW INSTALL LIST</button>';
                        echo'<button class="btn-next" onclick="next_list()"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;NEXT</button>';
                    echo'</td>';
                echo'</tr>';
            echo'</table>';
        echo'</div>';
        
        $rs->MoveNext();
    }
}
?>
<script type="text/javascript">
	/*$(document).ready = function(){
		document.getElementById("chk_loose_reel_rl").style.display = "none";
		document.getElementById("chk_loose_reel_qty").style.display = "none";
		document.getElementById("chk_full_reel_rl").style.display = "none";
		document.getElementById("chk_full_reel_qty").style.display = "none";
	}*/
	
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
	var nik   = getUrlVars()["nik"];
	var jobno = getUrlVars()["jobno"];
	var zfeed = getUrlVars()["zfeed"];
	var model = getUrlVars()["model"];
	var serial= getUrlVars()["serial"];
	var pwbnm = getUrlVars()["pwbnm"];
	var proces= getUrlVars()["proces"];
	var rows  = getUrlVars()["row"];
	var jdate = getUrlVars()["jdate"];
    var next, prev;
    var totcount = <?php echo $totcount;?>;
    var totcount1 = totcount-1;
    /*
	function urlvar(){
		$.post('operator/smartPicking.php',{nik:nik, jobno:jobno, zfeed:zfeed, model:model, serial:serial, pwbnm:pwbnm, proces:proces, jdate:jdate });
	}
*/	
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}    
    function next_list(){
        if (rows == totcount1){
            alert('This is LAST RECORD !');
        }
        else{
            next = parseInt(rows)+parseInt(1);
            window.location.assign("/picknav/dashboard.php?operator=2_smartInstall&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+next+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
    function prev_list(){
        if (rows == 0){
            alert('This is FIRST RECORD !');
        }
        else{
            prev = rows - 1;
            //alert(prev);
            window.location.assign("/picknav/dashboard.php?operator=2_smartInstall&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+prev+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
    function show_install(){
        window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+prev+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
    }
    function back_install(){
        window.location.assign("/picknav/dashboard.php?operator=2_install_data");
    }
	function saveInstall(dt,addrs,zfeeder,partnumber,demand2){
        //alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>

        if( levelno == '3'){
            var check_Install = $('select#check_install');
            var check_InstallVal = $('option:selected', check_Install).val();
			
			var data = {"check_install":check_InstallVal,
                        "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_chkins_install&action=saveInstall",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=2_smartInstall&info=error',"_self");
                }
            });
		}
        else { alert('Anda tidak diizinkan untuk mengedit kategori ini. Terima Kasih,'); }
		return false;
		
    }
	
    function saveKet(dt,addrs,zfeeder,partnumber){
       // alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>

        if(levelno==3){
            var ket = document.getElementById('ket').value;
            //alert(ket);
            var data = {"ket":ket,
                        "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_chkins_ket&action=saveket",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=2_smartInstall&info=error',"_self");
                }
            });
        }
        else { alert('Anda tidak diizinkan untuk mengedit kategori ini. Terima Kasih,'); }
		return false;
    }
    function select_row(){
        var slct_row = document.getElementById("slct_row").value;
        var slct_row_act = slct_row - 1;
        var slct;
        //alert (slct_row);
        if (slct_row_act == 0){
            alert('This is FIRST RECORD !');
        }
        else if (slct_row_act > totcount1){
            alert('This is LAST RECORD !');
        }
        else{
            slct = parseInt(slct_row_act);
            window.location.assign("/picknav/dashboard.php?operator=2_smartInstall&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+slct+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
</script>