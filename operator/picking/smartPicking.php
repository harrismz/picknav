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
	$zno_feedergroup 	= $zno_zfd. " zno containing '".$get_zfeed[$i]."'";
	$zno_zfd 			= $zno_zfd. " zno containing '".$get_zfeed[$i]."' or";
}
for($j=0; $j<$zfeeder_total; $j++){
	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$j]."'";
	$zfeeder_zfd 			= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$j]."' or";
}
    

$sql 	= "select first 1 skip {$row} zfeeder, pol, pos, pos1, w_fs, p_sp, addrs,     
            partnumber, point, demand, loose_reel, full_reel, ket, jobdate, jobtime,
			loose_reel_rl, loose_reel_qty, full_reel_rl, full_reel_qty, sts_opstart
            from job_detail_view('{$get_jobno}') where ({$zno_feedergroup})
			and (partnumber <> '' or partnumber <> null) 
            order by addrs asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

$sql3 	    = "SELECT COUNT(*) FROM job_detail_view('{$get_jobno}') where ({$zno_feedergroup}) and (partnumber <> '' or partnumber <> null)";
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
        if($pos_val == "" and $pos1_val == ""){
            $pos = '<font style="color: red">NULL</font>';
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
		$w_fs          = isset($rs->fields['4']) ? $rs->fields['4'] : '<font style="color: red">NULL</font>';
		$p_sp          = isset($rs->fields['5']) ? $rs->fields['5'] : '<font style="color: red">NULL</font>';
		$addrs         = isset($rs->fields['6']) ? $rs->fields['6'] : '<font style="color: red">NULL</font>';
		$partnumber    = isset($rs->fields['7']) ? $rs->fields['7'] : '<font style="color: red">NULL</font>';
		$point         = isset($rs->fields['8']) ? $rs->fields['8'] : '<font style="color: red">NULL</font>';
		$demand        = isset($rs->fields['9']) ? $rs->fields['9'] : '<font style="color: red">NULL</font>';
		$demand2       = isset($rs->fields['9']) ? $rs->fields['9'] : '0';
		$loose_reel    = isset($rs->fields['10']) ? $rs->fields['10'] : '<font style="color: gray">-</font>';
		$full_reel     = isset($rs->fields['11']) ? $rs->fields['11'] : '<font style="color: gray">-</font>';
		$ket           = isset($rs->fields['12']) ? $rs->fields['12'] : '';
		$jobdate       = $rs->fields['13'];
		$jobtime       = $rs->fields['14'];
		$loose_reel_rl = trim($rs->fields['15']);
		$loose_reel_qty= trim($rs->fields['16']);
		$full_reel_rl  = trim($rs->fields['17']);
		$full_reel_qty = trim($rs->fields['18']);
        $row_show = $row+1;
        echo'<div id="board">';
            echo'<table id="tbl_main">';
                 echo'<tr>';
                    echo'<td colspan="4" >';
                        echo'<table id="tbl_sp_header">';
                            echo'<tr>';
                                echo'<td class="sp_hd_judul" align="left">Baris</td>';
                                //echo'<td class="sp_hd_judul" align="left">POL</td>';
                                //echo'<td class="sp_hd_judul" align="left">POS</td>';
                                //echo'<td class="sp_hd_judul" align="left">W/FS</td>';
                                //echo'<td class="sp_hd_judul" align="left">P/SP</td>';
                                //echo'<td class="sp_hd_judul" align="left">Point</td>';
                                echo'<td class="sp_hd_judul" align="left">Demand</td>';
                                echo'<td class="sp_hd_judul" align="left">Baris ke</td>';
                            echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_hd_isi" align="right"><font style="background-color: yellow; padding-left: 40px; padding-right: 40px; border-radius:50%; border:1px red solid;">'.$row_show.'</font></td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$pol.'</td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$pos.'</td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$w_fs.'</td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$p_sp.'</td>';
                                //echo'<td class="sp_hd_isi" align="right">'.$point.'</td>';
                                echo'<td class="sp_hd_isi" align="right" id="demand_val">'.$demand.'</td>';
                                echo'<td class="sp_hd_isi_row" align="right">';
                                   // echo'<input type="number" id="slct_row" name="slct_row" value="'.$row_show.'"/>';
                                    echo'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                echo'<td class="sp_judul_atas_addrs" >ADDRS</td>';
                                echo'<td class="sp_judul_atas_feeder" >Z-FEEDER</td>';
								echo'<td class="sp_judul_atas_pos" align="left">POS</td>';
								echo'<td class="sp_judul_atas_blank" align="left">&nbsp;</td>';
                            echo'</tr>';
							echo'<tr>';
                                echo'<td class="sp_isi_addrs" >'.$addrs.'</td>';
                                echo'<td class="sp_isi_feeder" >'.$zfeeder.'</td>';
								echo'<td class="sp_isi_pos" align="right">'.$pos.'</td>';
								echo'<td class="sp_isi_blank" align="left">&nbsp;</td>';
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
                                echo'<td class="sp_judul" align="center" colspan="2">LOOSE REEL</td>';
                                echo'<td class="sp_judul" align="center"><font class="chk_loose_reel_rl">REEL</font></td>';
                                echo'<td class="sp_judul" align="center"><font class="chk_loose_reel_qty">QTY</font></td>';
                            echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_isi_partname" rowspan="2">'.$partnumber.'</td>';
                                echo'<td id="loosereel" class="sp_isi_reel">';
                                    if($loose_reel == 'OK'){
                                        echo'<b style="color:green;">'.$loose_reel.'/R:'.$loose_reel_rl.'/Q:'.$loose_reel_qty.'</b>';
                                    }
                                    elseif($loose_reel == 'LIMIT'){
                                        echo'<b style="color:red;">'.$loose_reel.'/R:'.$loose_reel_rl.'/Q:'.$loose_reel_qty.'</b>';
                                    }else{
                                        echo'<b style="color:gray;">--</b>';
                                    }
                                echo'</td>';
                                echo'<td class="sp_isi">';
                                        //echo '<select name="check_loose_reel" id="check_loose_reel" onchange="saveLooseReel('.$date2.','.$addrs.','.$zfeeder.','.$partnumber.')">
                                        echo '<select name="check_loose_reel" id="check_loose_reel" onchange="saveLooseReel(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\',\''.$demand2.'\')">
                                            <option value="-"> -Conf- </option>
                                            <option value="OK">OK</option>
                                            <option value="LIMIT">LIMIT</option>
                                            <option value="DEL">.::DEL::.</option>
                                        </select>';
		                       echo'</td>';
								echo'<td class="sp_isi_chk">';
                                        echo '<input type="number" class="chk_loose_reel_rl" id="chk_loose_rl" onkeypress="return isNumberKey(event)" value="0" onkeyup="saveLooseReel_rl(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\')" />';
                                echo'</td>';
								echo'<td class="sp_isi_chk">';
                                       echo '<input type="number" class="chk_loose_reel_qty" id="chk_loose_qty" onkeypress="return isNumberKey(event)" value="0" onkeyup="saveLooseReel_qty(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\',\''.$demand2.'\')" />';
                                echo'</td>';
							echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_judul" align="center" colspan="2">FULL REEL</td>';
								echo'<td class="sp_judul" align="center"><font class="chk_full_reel_rl">REEL</font></td>';
                                echo'<td class="sp_judul chk_full_reel_qty" align="center"><font class="chk_full_reel_rl">QTY</font></td>';
                            echo'</tr>';
                            echo'<tr>';
                                echo'<td class="sp_judul" >KETERANGAN</td>';
                                echo'<td id="fullreel" class="sp_isi_reel" rowspan="2" >';
                                    if($full_reel == 'OK'){
                                        echo'<b style="color:green;">'.$full_reel.'/R:'.$full_reel_rl.'/Q:'.$full_reel_qty.'</b>';
                                    }
                                    elseif($full_reel == 'LIMIT'){
                                        echo'<b style="color:red;">'.$full_reel.'/R:'.$full_reel_rl.'/Q:'.$full_reel_qty.'</b>';
                                    }
                                    else{
                                        echo'<b style="color:gray;">--</b>';
                                    }
                                echo'</td>';
                                echo'<td class="sp_isi" rowspan="2" >';
                                        echo '<select name="check_full_reel" id="check_full_reel" onchange="saveFullReel(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\',\''.$demand2.'\')">
                                            <option value="-"> -Conf- </option>
                                            <option value="OK">OK</option>
                                            <option value="LIMIT">LIMIT</option>
                                            <option value="DEL">.::DEL::.</option>
                                        </select>';
                                echo'</td>';
								echo'<td class="sp_isi_chk" rowspan="2" >';
                                        echo '<input type="number" class="chk_full_reel_rl" id="chk_full_rl" onkeypress="return isNumberKey(event)" value="0" onkeyup="saveFullReel_rl(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\')" />';
                                echo'</td>';
								echo'<td class="sp_isi_chk" rowspan="2" >';
                                       echo '<input type="number" class="chk_full_reel_qty" id="chk_full_qty" onkeypress="return isNumberKey(event)" value="0" onkeyup="saveFullReel_qty(\''.$jobdate.'\',\''.$addrs.'\',\''.$zfeeder.'\',\''.$partnumber.'\',\''.$demand2.'\')" />';
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
                        echo'<button class="btn-back" onclick="back_prepare()"><i class="fa fa-undo fa-lg"></i>&nbsp;&nbsp;HOME</button>';
                        echo'<button class="btn-partlist" onclick="show_partlist()"><i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;SHOW PARTLIST</button>';
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
            window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+next+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
    function prev_list(){
        if (rows == 0){
            alert('This is FIRST RECORD !');
        }
        else{
            prev = rows - 1;
            //alert(prev);
            window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+prev+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
    function show_partlist(){
        window.location.assign("/picknav/dashboard.php?operator=smartPickingDesk&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+prev+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
    }
    function back_prepare(){
        window.location.assign("/picknav/dashboard.php?operator=loading_list");
    }
	function saveLooseReel(dt,addrs,zfeeder,partnumber,demand2){
        //alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>
		
        if( levelno == '3'){
            var check_LooseReelList = $('select#check_loose_reel');
            var check_LooseReelVal = $('option:selected', check_LooseReelList).val();
			//alert(check_LooseReelVal);
			
			if(check_LooseReelVal=='OK'){
				 //alert(check_LooseReelVal);
				$(".chk_loose_reel_rl").css("display", "block");
				$("#chk_loose_rl").val("1");
				$(".chk_loose_reel_qty").val("0");
				$(".chk_loose_reel_qty").css("display", "none");
				saveLooseReel_rl(dt,addrs,zfeeder,partnumber);
				saveLooseReel_qty(dt,addrs,zfeeder,partnumber,demand2);
				var ket_qty = "";
				var ket_qty2 = $("#ket").val();
				var n = ket_qty2.indexOf("BALANCE");
				if(n == "-1"){
					ket_qty = $("#ket").val();
					saveKet(dt,addrs,zfeeder,partnumber);
				}
				else{ 
					ket_qty = ket_qty2.substr(0, ket_qty2.indexOf('(BALANCE'));
					$("#ket").val(ket_qty);
					saveKet(dt,addrs,zfeeder,partnumber);
				}
			}
			else if(check_LooseReelVal=='LIMIT'){
				 //alert(check_LooseReelVal);
				$(".chk_loose_reel_rl").css("display", "block");
				$("#chk_loose_rl").val("1");
				$(".chk_loose_reel_qty").css("display", "block");
				$("#chk_loose_qty").val("0");
				saveLooseReel_rl(dt,addrs,zfeeder,partnumber);
				saveLooseReel_qty(dt,addrs,zfeeder,partnumber,demand2);
			}
			else{
				//alert('del');
				$("#chk_loose_rl").val("0");
				$("#chk_loose_qty").val("0");
				$(".chk_loose_reel_rl").css("display", "none");
				$(".chk_loose_reel_qty").css("display", "none");
				saveLooseReel_rl(dt,addrs,zfeeder,partnumber);
				saveLooseReel_qty(dt,addrs,zfeeder,partnumber,demand2);
				var ket_qty = "";
				var ket_qty2 = $("#ket").val();
				var n = ket_qty2.indexOf("BALANCE");
				if(n == "-1"){
					ket_qty = $("#ket").val();
					saveKet(dt,addrs,zfeeder,partnumber);
				}
				else{ 
					ket_qty = ket_qty2.substr(0, ket_qty2.indexOf('(BALANCE'));
					$("#ket").val(ket_qty);
					saveKet(dt,addrs,zfeeder,partnumber);
				}
				$("#loosereel").html("<b style='color:gray;'>--</b>");
			}
			
			var data = {"check_LooseReel":check_LooseReelVal,
                        "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_pickingCheck&action=saveloosereel",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=smartPicking&info=error',"_self");
                }
            });
		}
        else { alert('you can not modify this category. Thank you,'); }
    }
	function saveLooseReel_rl(dt,addrs,zfeeder,partnumber){
       // alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>

        if(levelno==3){
            var loosereel_val1 = document.getElementById('chk_loose_rl').value;
            var loosereel_val = parseInt(loosereel_val1);
            //alert(ket);
            var data = {"loosereel_val":loosereel_val, "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_pickingCheck&action=saveloose_rl",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=smartPicking&info=error',"_self");
                }
            });
        }
        else { alert('you can not modify this category. Thank you,'); }
    }
	function saveLooseReel_qty(dt,addrs,zfeeder,partnumber,demand2){
       // alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>
		
		//var ket_qty = $("#ket").val();
		var qty_limit = parseInt($("#chk_loose_qty").val());
		
		var ket_qty = "";
		var ket_qty2 = $("#ket").val();
		var n = ket_qty2.indexOf("BALANCE");
		
		if(n == "-1"){ ket_qty = $("#ket").val(); }
		else{ ket_qty = ket_qty2.substr(0, ket_qty2.indexOf('(BALANCE')); }
		
		if (parseInt(qty_limit) > parseInt(demand2)){
			alert("Over QTY !");
			$("#chk_loose_qty").val("0");
			return false;
		}else{
			var blc_demand = parseInt(demand2) - parseInt(qty_limit);
			$("#ket").val("");
			$("#ket").val(ket_qty.trim() + " (BALANCE : " + parseInt(blc_demand) + " Qty)");
			saveKet(dt,addrs,zfeeder,partnumber);
		
			//var blc_demand = demand2 - qty_limit;
			//ket_qty.text = (ket_qty.text + " BALANCE : " + blc_demand + " Qty");
			if(levelno==3){
				var looseqty_val1 = document.getElementById('chk_loose_qty').value;
				var looseqty_val = parseInt(looseqty_val1);
				//alert(looseqty_val);
				var data = {"looseqty_val":looseqty_val, "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber,"demand":demand2};
				$.ajax({
					url : "dashboard.php?resp=resp_pickingCheck&action=saveloose_qty",
					type: "POST",
					data: data,
					success: function(data, status, xhr){},
					failure : function(data, status, xhr){
							window.open('dashboard.php?operator=smartPicking&info=error',"_self");
					}
				});
			}
			else { alert('you can not modify this category. Thank you,'); }
		}
	}
    function saveFullReel(dt,addrs,zfeeder,partnumber,demand2){
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>

        if( levelno==3 ){
            var check_FullReelList = $('select#check_full_reel');
            var check_FullReelVal = $('option:selected', check_FullReelList).val();
			
			if(check_FullReelVal=='OK'){
				$(".chk_full_reel_rl").css("display", "block");
				$("#chk_full_rl").val("1");
				$("#chk_full_qty").val("0");
				$(".chk_full_reel_qty").css("display", "none");
				saveFullReel_rl(dt,addrs,zfeeder,partnumber);
				saveFullReel_qty(dt,addrs,zfeeder,partnumber,demand2);
				var ket_qty3 = "";
				var ket_qty4 = $("#ket").val();
				var n = ket_qty4.indexOf("BALANCE");
				if(n == "-1"){
					ket_qty3 = $("#ket").val();
					saveKet(dt,addrs,zfeeder,partnumber);
				}
				else{ 
					ket_qty3 = ket_qty4.substr(0, ket_qty4.indexOf('(BALANCE'));
					$("#ket").val(ket_qty3);
					saveKet(dt,addrs,zfeeder,partnumber);
				}
			}
			else if(check_FullReelVal=='LIMIT'){
				$(".chk_full_reel_rl").css("display", "block");
				$("#chk_full_rl").val("1");
				$(".chk_full_reel_qty").css("display", "block");
				$("#chk_full_qty").val("0");
				saveFullReel_rl(dt,addrs,zfeeder,partnumber);
				saveFullReel_qty(dt,addrs,zfeeder,partnumber,demand2);
			}
			else{
				$("#chk_full_rl").val("0");
				$(".chk_full_reel_rl").css("display", "none");
				$("#chk_full_qty").val("0");
				$(".chk_full_reel_qty").css("display", "none");
				$("#fullreel").html("<b style='color:gray;'>--</b>");
				saveFullReel_rl(dt,addrs,zfeeder,partnumber);
				saveFullReel_qty(dt,addrs,zfeeder,partnumber,demand2);
				
				var ket_qty3 = "";
				var ket_qty4 = $("#ket").val();
				var n = ket_qty4.indexOf("BALANCE");
				if(n == "-1"){
					ket_qty3 = $("#ket").val();
					saveKet(dt,addrs,zfeeder,partnumber);
				}
				else{ 
					ket_qty3 = ket_qty4.substr(0, ket_qty4.indexOf('(BALANCE'));
					$("#ket").val(ket_qty3);
					saveKet(dt,addrs,zfeeder,partnumber);
				}
			}
			
            var data = {"check_FullReel":check_FullReelVal,
                        "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_pickingCheck&action=savefullreel",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=smartPicking&info=error',"_self");
                }
            });
        }
        else { alert('you can not modify this category. Thank you,'); }
    }
	function saveFullReel_rl(dt,addrs,zfeeder,partnumber){
       // alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>

        if(levelno==3){
            var fullreel_val1 = document.getElementById('chk_full_rl').value;
            var fullreel_val = parseInt(fullreel_val1);
            //alert(ket);
            var data = {"fullreel_val":fullreel_val, "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber};
            $.ajax({
                url : "dashboard.php?resp=resp_pickingCheck&action=savefull_rl",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?operator=smartPicking&info=error',"_self");
                }
            });
        }
        else { alert('you can not modify this category. Thank you,'); }
    }
	function saveFullReel_qty(dt,addrs,zfeeder,partnumber,demand2){
       // alert(dt + addrs + zfeeder + partnumber);
        <?php $levelno = isset($_SESSION['picknav_levelno']) 	? $_SESSION['picknav_levelno'] 	: ''; ?>
        var levelno = <?php echo $levelno; ?>
		
		//var ket_qty = $("#ket").val();
		var qty_limit3 = parseInt($("#chk_full_qty").val());
		
		var ket_qty3 = "";
		var ket_qty4 = $("#ket").val();
		var n = ket_qty4.indexOf("BALANCE");
		
		if(n == "-1"){ ket_qty3 = $("#ket").val(); }
		else{ ket_qty3 = ket_qty4.substr(0, ket_qty4.indexOf('(BALANCE')); }
		
		if (parseInt(qty_limit3) > parseInt(demand2)){
			alert("Over QTY !");
			$("#chk_full_qty").val("0");
			return false;
		}else{
			var blc_demand3 = parseInt(demand2) - parseInt(qty_limit3);
			$("#ket").val("");
			$("#ket").val(ket_qty3.trim() + " (BALANCE : " + parseInt(blc_demand3) + " Qty)");
			saveKet(dt,addrs,zfeeder,partnumber);
		
			//var blc_demand = demand2 - qty_limit;
			//ket_qty.text = (ket_qty.text + " BALANCE : " + blc_demand + " Qty");
			if(levelno==3){
				var fullqty_val1 = document.getElementById('chk_full_qty').value;
				var fullqty_val = parseInt(fullqty_val1);
				//alert(ket);
				var data = {"fullqty_val":fullqty_val, "dt":dt,"jobno":jobno,"addrs":addrs,"zfeeder":zfeeder,"partnumber":partnumber,"demand":demand2};
				$.ajax({
					url : "dashboard.php?resp=resp_pickingCheck&action=savefull_qty",
					type: "POST",
					data: data,
					success: function(data, status, xhr){},
					failure : function(data, status, xhr){
							window.open('dashboard.php?operator=smartPicking&info=error',"_self");
					}
				});
			}
			else { alert('you can not modify this category. Thank you,'); }
		}
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
                url : "dashboard.php?resp=resp_pickingCheck&action=saveket",
                type: "POST",
                data: data,
                success: function(data, status, xhr){},
                failure : function(data, status, xhr){
                        window.open('dashboard.php?chk=chkreport_ins&info=error',"_self");
                }
            });
        }
        else { alert('you can not modify this category. Thank you,'); }
    }
    function select_row(){
        var slct_row = document.getElementById("slct_row").value;
        var slct_row_act = slct_row - 1;
        var slct;
        //alert (slct_row);
        if (slct_row_act < 0){
            alert('This is FIRST RECORD !');
        }
        else if (slct_row_act > totcount1){
            alert('This is LAST RECORD !');
        }
        else{
            slct = parseInt(slct_row_act);
            window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed+"&row="+slct+"&count="+totcount1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
        }
    }
</script>