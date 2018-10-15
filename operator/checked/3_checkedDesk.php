<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<div id="content">
	<div id="panel-checked" class="panel-picknav">
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
			<button class="btn-previous-zfd" onclick="prev_chkd()">
				<i class="fa fa-arrow-left fa-lg"></i>
				<br><br>PREV
				<br><font style="font-size:12px !important;">Z-FEEDER</font>
			</button>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="border : solid #fa8f46 2px;">
			<h4 id="zfeed_header" align="center"></h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="border : solid #fa8f46 2px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h4 id="jobno_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="model_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="serial_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="pwbnm_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="proces_header" align="center"></h4></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
			<button class="btn-previous-zfd" onclick="next_chkd()">
				<i class="fa fa-arrow-right fa-lg"></i>
					<br><br>NEXT
					<br><font style="font-size:12px !important;">Z-FEEDER</font>
			</button>
        </div>
		
		&nbsp;
	</div>
	<div id="scan_partnumber" class="col-xs-12 col-sm-12 col-md-12">
		<label id="label-scnpartno-chk" class="col-xs-4 col-sm-4 col-md-4">PART NUMBER</label>
		<input type="text" id="input-scnpartno-chk" name="input-scnpartno-chk" maxlength="15" onBlur="this.value=this.value.toUpperCase()" onkeypress="scanpartnoChk_chkd(event)" autofocus />
		<label id="label-scnpartno" name="label-scnpartno"  class="col-xs-12 col-sm-12 col-md-12"></label>
		<input type="text" id="seq_part"/>
	</div>
	<div  id="tbl_scanpartno_chkd" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
	<div id="tbl_checkeddesk" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</div>
<div class="col-lg-12">
<?php
	date_default_timezone_set('Asia/Jakarta');
	//include database connection
	include "../adodb/con_part_im.php";
	$jobno_chkd = isset($_GET['jobno']) ? $_GET['jobno'] : "";
	$fdno_chkd1 = isset($_GET['row']) ? $_GET['row'] : "0";
	$fdno_chkd = intval($fdno_chkd1)-1;
	if($fdno_chkd <= 0){
		$fdno_chkd = 0;
	}
	$sql_tot_chkd = "select count ( distinct zno ) 
					from checked_slctjob('{$jobno_chkd}')";
	$rs_tot_chkd = $db->Execute($sql_tot_chkd);
	$zfd_tot_chkd = $rs_tot_chkd->fields[0];
	$rs_tot_chkd->Close();
	
	$sql_zfeed_chkd = "select first 1 skip {$fdno_chkd} distinct zno 
					from checked_slctjob('{$jobno_chkd}')
					group by zno";
	$rs_zfeed_chkd = $db->Execute($sql_zfeed_chkd);
	$zfeed_chkd = $rs_zfeed_chkd->fields[0];
	$rs_zfeed_chkd->Close();
	
	$sql_totpart 	= "select count(*)
						from pn_checked('{$jobno_chkd}')
						where zfeeder containing '{$zfeed_chkd}'";
	$rs_totpart		= $db->Execute($sql_totpart);
	$totpart		= trim($rs_totpart->fields[0]);

	$db->Close();
	$db=null;
?>
</div>
<script type="text/javascript">
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
	}
	var nik_chkd        = getUrlVars()["nik"];
	var jobno_chkd      = getUrlVars()["jobno"];
	var model_chkd      = getUrlVars()["model"];
	var serial_chkd     = getUrlVars()["serial"];
	var pwbnm_chkd2     = getUrlVars()["pwbnm"];
	var pwbnm_chkd      = pwbnm_chkd2.split('%20').join(' ');
	var process_chkd    = getUrlVars()["process"];
	var jdate_chkd      = getUrlVars()["jdate"];
	//var seq_part      	= getUrlVars()["seq"];
	
	var rows_chkd  		= getUrlVars()["row"];
	var zfeed_chkd    	= "<?php echo $zfeed_chkd;?>";
	var zfd_tot_chkd 	= <?php echo $zfd_tot_chkd;?>;
	var tot_part	 	= <?php echo $totpart;?>;
    var zfd_tot_chkd1 	= parseInt(zfd_tot_chkd);
	var seq_part	= $('#seq_part').val();

    $(document).ready(function(){
		
		$('#tbl_checkeddesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/checked/3_get_smartChkDesk.php', {
			nik_chkd : nik_chkd,
            jobno_chkd : jobno_chkd,
            feederno_chkd : rows_chkd
		},
		function(result) {
			$('#tbl_checkeddesk').html(result).show();
		});
        //document.getElementById("zfeed_header").innerHTML = "<b><font color='#008080'>Z-FEEDER</font><br><br><font color='#008080'>(</font>"+zfeed_title+"<font color='#008080'>)</font></b>";
        document.getElementById("zfeed_header").innerHTML = "<b><font color='#008080'>Z-FEEDER</font><br><br><font style='font-size: 40px;'>"+zfeed_chkd+"</font></b>";
        document.getElementById("jobno_header").innerHTML = "<b><font color='#008080'>JOB NO</font><br>"+jobno_chkd+"</b>";
        document.getElementById("model_header").innerHTML = "<b><font color='#008080'>MODEL : </font>"+model_chkd+"</b>";
        document.getElementById("serial_header").innerHTML = "<b><font color='#008080'>SERIAL : </font>"+serial_chkd+"</b>";
        document.getElementById("pwbnm_header").innerHTML = "<b><font color='#008080'>PWB NAME : </font>"+pwbnm_chkd+"</b>";
        document.getElementById("proces_header").innerHTML = "<b><font color='#008080'>PROCESS : </font>"+process_chkd+"</b>";
		if(seq_part==""){
			$('#seq_part').val("0");
		}
		else{$('#seq_part').val(seq_part);}
		
		$("#input-scnpartno-chk").focus();
		return false;
	});
    function on_refresh_checked(){
        $('#tbl_checkeddesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/checked/3_get_smartChkDesk.php', {
			nik_chkd : nik_chkd,
            jobno_chkd : jobno_chkd,
            feederno_chkd : rows_chkd
		},
		function(result) {
			$('#tbl_chkdesk').html(result).show();
		});
		//document.getElementById("panel-checked").style.display = "none";
		
		$("#input-scnpartno-chk").focus();
		return false;    
	}
    function on_finishing_checked(){
		
		var uncheck = document.getElementById("uncheck").value;
        
		if(confirm("You have not checked part : "+ uncheck +" Part\n\nAre you sure to finish this Checking Process ?\n\n") == true){
            //alert(nik + jobno);
            $.post('resp/checked/3_finishing_checked.php', {
				jobno_chkd : jobno_chkd, 
				nik_chkd : nik_chkd, 
				jdate_chkd:jdate_chkd,
				feederno_chkd : rows_chkd
			}, 
			function(data, status) {
				//alert('This Installation has been finished. ');
				//alert(data, status);
				if (status == 'success'){
					//window.location.assign("/picknav/dashboard.php?operator=2_install_data");
					
					next_chkd = parseInt(rows_chkd)+parseInt(1);
					if(next_chkd <= zfd_tot_chkd1){
						window.location.assign("/picknav/dashboard.php?operator=3_smartChkDesk&nik="+nik_chkd+"&jobno="+jobno_chkd+"&row="+next_chkd+"&count="+zfd_tot_chkd1+"&model="+model_chkd+"&serial="+serial_chkd+"&pwbnm="+pwbnm_chkd+"&process="+process_chkd+"&jdate="+jdate_chkd+"&seq="+seq_part+"&tot="+tot_part);
					}
					else if(next_chkd <= zfd_tot_chkd1){
						window.location.assign("/picknav/dashboard.php?operator=3_smartChkDesk&nik="+nik_chkd+"&jobno="+jobno_chkd+"&row=1&count="+zfd_tot_chkd1+"&model="+model_chkd+"&serial="+serial_chkd+"&pwbnm="+pwbnm_chkd+"&process="+process_chkd+"&jdate="+jdate_chkd+"&seq="+seq_part+"&tot="+tot_part);
					}
					return false;    
				}
			});
            //window.location.assign("/picknav/dashboard.php?operator=2_install_data");
        }
			return false;    
	}
    function scanpartnoChk_chkd(event){
		var x 		= event.which || event.keyCode;
		var sprtno_chkd = $('#input-scnpartno-chk');
		var sprtno_chkd2 = $('#label-scnpartno');
		
		if(x == 13) {
			sprtno_chkd2.val(sprtno_chkd.val());
			document.getElementById("label-scnpartno").innerHTML = sprtno_chkd.val();
			sprtno_chkd.val("");
			sprtno_chkd.focus();
			
			var scncount = (sprtno_chkd2.val().length)+1;
			
			//random color
			var colors = ['#3f51b5','#2196f3','#e91e63','#9c27b0','#263238','#ff3d00'];
			var random_color = colors[Math.floor(Math.random() * colors.length)];
			$('#label-scnpartno').css('color', random_color);
			$('#label-scnpartno').css('border-bottom', '3px solid '+random_color);
			
			if(scncount >= 15) {
				var seq_part2	= $('#seq_part').val();
				$('#tbl_scanpartno_chkd').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/checked/3_get_scanChk.php', {
					nik_chkd : nik_chkd,
					jobno_chkd : jobno_chkd,
					feederno_chkd : rows_chkd,
					scanpartno_chkd : sprtno_chkd2.val(),
					seq : seq_part2
				},
				function(result) {
					$('#tbl_scanpartno_chkd').html(result).show();
				});
				//alert(seq_part2);
				var data = {	jdate_chkd:jdate_chkd,
								jobno_chkd:jobno_chkd,
								partnumber_chkd:sprtno_chkd2.val(),
								feederno_chkd:rows_chkd,
								seq : seq_part2
							};
				$.ajax({
					url : "dashboard.php?resp=resp_chkins_checked&action=saveChecked",
					type: "POST",
					data: data,
					success: function(data, status, xhr){
						//alert(data,status,xhr);
						$('#tbl_checkeddesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
						$.post('get/checked/3_get_smartChkDesk.php', {
							nik_chkd : nik_chkd,
							jobno_chkd : jobno_chkd,
							feederno_chkd : rows_chkd
						},
						function(result) {
								$('#tbl_checkeddesk').html(result).show();
						});
						var seq_next = parseInt(seq_part2)+1;
						$("#seq_part").val(seq_next);
					},
					failure : function(data, status, xhr){
							alert(data,status,xhr);
					}
				});
			}
			else{
				$('#tbl_scanpartno_chkd').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">PART SALAH</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/PART_SALAH.mp3" type="audio/mp3"></audio>');
			}
		}
		$("#input-scnpartno-chk").focus();
		return false; 
	}
    function cancelChecked(x){
		partno_cancel = document.getElementById("partno_cancel"+x).value;
		zfeeder_cancel= document.getElementById("zfeeder_cancel"+x).value;
		pos_cancel    = document.getElementById("pos_cancel"+x).value;
		
		var data = {jobno_chkd:jobno_chkd,partnumber_chkd:partno_cancel,zfeeder_chkd:zfeeder_cancel,pos_chkd:pos_cancel,jdate_chkd:jdate_chkd};
		$.ajax({
			url : "dashboard.php?resp=resp_chkins_checked&action=cancelChecked",
			type: "POST",
			data: data,
			success: function(data, status, xhr){
				//alert(data, status, xhr);
				$('#tbl_checkeddesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/install/3_get_smartChkDesk.php', {
					nik_chkd : nik_chkd,
					jobno_chkd : jobno_chkd,
					feederno_chkd : rows_chkd
				},
				function(result) {
					$('#tbl_checkeddesk').html(result).show();
				});
			},
			failure : function(data, status, xhr){
					alert(data,status,xhr);
			}
		});
		
		$("#input-scnpartno-chk").focus();
		return false;
	}
    function on_panel_checked() {
		if(document.getElementById("panel-checked").style.display == "block"){
            document.getElementById("panel-checked").style.display = "none";
        }
		else{
            document.getElementById("panel-checked").style.display = "block";
		}
		$("#input-scnpartno-chk").focus();
		return false;
	}
	function prev_chkd(){
        if (rows_chkd == 1){
            alert('This is FIRST RECORD !');
        }
        else{
            prev = parseInt(rows_chkd)-parseInt(1);
            
			$.post('resp/checked/start_checked.php', {
				jobno_chkd  : jobno_chkd,
				nik_chkd    : nik_chkd,
				jdate_chkd  : jdate_chkd,
				feederno   : prev
				},
				function(data, status) {
					if(status == "success"){
						window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&jobno="+jobno_chkd+"&row="+prev_chkd+"&count="+zfd_tot_chkd1+"&model="+model_chkd+"&serial="+serial_chkd+"&pwbnm="+pwbnm_chkd2+"&process="+process_chkd+"&jdate="+jdate_chkd+"&seq=0&tot="+tot_part);
					}
					else{
						alert('Data not found !');
					}
				}
			);
		}
		$("#input-scnpartno-chk").focus();
		return false;
    }
	function next_chkd(){
        if (rows_chkd == zfd_tot_chkd1){
            alert('This is LAST RECORD !');
        }
        else{
            next = parseInt(rows_chkd)+parseInt(1);
			
			$.post('resp/checked/start_checked.php', {
				jobno_chkd  : jobno_chkd,
				nik_chkd    : nik_chkd,
				jdate_chkd  : jdate_chkd,
				feederno   : next
				},
				function(data, status) {
					if(status == "success"){
						window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&jobno="+jobno_chkd+"&row="+next+"&count="+zfd_tot_chkd1+"&model="+model_chkd+"&serial="+serial_chkd+"&pwbnm="+pwbnm_chkd2+"&process="+process_chkd+"&jdate="+jdate_chkd+"&seq=0&tot="+tot_part);
					}
					else{
						alert('Data not found !');
					}
				}
			);
		 }
		$("#input-scnpartno-chk").focus();
		return false;
    }
</script>
