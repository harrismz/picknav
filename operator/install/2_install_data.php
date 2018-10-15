<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
	var picknav_nik = '<?=$picknav_nik?>';
	var jobno_install, model_install, serial_install, pwbname_install, process_install, jdate_install, total_zfeed_install;
	var jobno_ins, zfeed_ins, model_ins, serial_ins, pwbname_ins, process_ins, jdate_ins, feeder_no;
	
	$(document).ready(function(){
        if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
        $('#tbl_installdata').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_install_data.php', {
			src_sdate_install : $('[name=""]').val(),
			src_edate_install : $('[name=""]').val(),
			src_jobno_install : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_installdata').html(result).show();
		});
		return false;
	});
	function dismismodal(){ $('.modal').modal('hide'); }
	
	function on_refresh_installdata(){
		$('#tbl_installdata').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_install_data.php', {
			src_sdate_install : $('[name=""]').val(),
			src_edate_install : $('[name=""]').val(),
			src_jobno_install : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_installdata').html(result).show();
		});
		return false;     
	}
	function on_src_installdata() {
		if(document.getElementById("show-src-install").style.display == "block"){
            document.getElementById("show-src-install").style.display = "none";
        }
		else{
            document.getElementById("show-src-install").style.display = "block";
		}
	}
    function search_install(){
        var sdate_install = document.getElementById("src_sdate_install");
		var edate_install = document.getElementById("src_edate_install");
		var jobno_install = document.getElementById("src_jobno_install");

        if(sdate_install.value != "" && edate_install.value==""){
            alert('Masukan Tanggal "End Date"');
            edate_install.focus();
        }
        else if(sdate_install.value == "" && edate_install.value!=""){
            alert('Masukan Tanggal "Start Date"');
            sdate_install.focus();
        }
        else if(sdate_install.value > edate_install.value){
            alert('Tanggal Akhir lebih besar dari Tanggal Awal !');
            sdate_install.focus();
        }
        else{
            $('#tbl_installdata').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

            $.post('get/install/2_get_install_data.php', {
                src_sdate_install : $('[name=src_sdate_install]').val(),
                src_edate_install : $('[name=src_edate_install]').val(),
                src_jobno_install : $('[name=src_jobno_install]').val()
            },
            function(result) {
                $('#tbl_installdata').html(result).show();
            });
            document.getElementById("show-src-install").style.display = "none";
        }
        return false;
    }
	function popupInstall(x){
		jobno_install  = document.getElementById("jobno_install"+x).value;
		model_install  = document.getElementById("model_install"+x).value;
		serial_install = document.getElementById("serial_install"+x).value;
		pwbname_install= document.getElementById("pwbname_install"+x).value;
		process_install = document.getElementById("process_install"+x).value;
		jdate_install  = document.getElementById("jdate_install"+x).value;

        $("#ModalInstallSelect").on("show", function() {    
            $("#ModalInstallSelect a.btn").on("click", function(e) {
                $("#ModalInstallSelect").modal('hide');     
            });
        });
        
        $("#ModalInstallSelect").on("hide", function() {   $("#ModalInstallSelect a.btn").off("click"); });
        $("#ModalInstallSelect").on("hidden", function() { $("#ModalInstallSelect").remove(); });
        $("#ModalInstallSelect").modal({                    
          "backdrop"  : "static",
          "keyboard"  : true,
          "show"      : true                     
        });
        
        $('#title_tmp').html('JOBNO : ' + jobno_install);
        $('#title_tmp').css('text-align', 'center');
        $('#title_tmp').css('font-size', '14px');
        $('#title_tmp').css('font-weight', 'bold');
        $('#isi_tmp').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/install/2_get_installdata_selectjob.php', {jobno_install : jobno_install, model_install:model_install, serial_install:serial_install, pwbname_install:pwbname_install, proces_install:process_install, jdate_install:jdate_install},
        function(result) { $('#isi_tmp').html(result).show(); });
    }
	function checkAll_install(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = true;
				}
			}
		} 
		else {
			for (var i = 0; i < checkboxes.length; i++) {
				console.log(i)
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}
	//function selectjob_install(){						(( SELECT JOB WITH CHECKBOX ))
	//	var table_ins 		= document.getElementById("dt_zfeed_install");
	//	var chk_arr_ins 	=  document.getElementsByName("item[]");
	//	var chklength_ins 	= chk_arr_ins.length;
	//	var i_ins = 0;
	//	var a_ins = '';
	//	var total_zfeed_ins = 0;
	//	var cb_ins = "";
	//	for(i_ins=0; i_ins<chklength_ins; i_ins++)
	//	{
	//		if (chk_arr_ins[i_ins].checked) {
	//			cb_ins 	= a_ins + '' + chk_arr_ins[i_ins].value;
	//			a_ins 	= a_ins + '' + chk_arr_ins[i_ins].value + '|';
	//			total_zfeed_ins++;
	//		}
	//	}
	//	//alert(total_zfeed_ins);
	//	if(total_zfeed_ins >> 0){
	//		jobno_ins  = document.getElementById("jobno_install_slct").value;
	//		zfeed_ins  = cb_ins;
	//		model_ins  = document.getElementById("model_install_slct").value;
	//		serial_ins = document.getElementById("serial_install_slct").value;
	//		pwbname_ins= document.getElementById("pwbname_install_slct").value;
	//		process_ins = document.getElementById("process_install_slct").value;
	//		jdate_ins  = document.getElementById("jdate_install_slct").value;
	//		
	//		$("#ModalInstallDetail").on("show", function() {    
	//			$("#ModalInstallDetail a.btn").on("click", function(e) {
	//				$("#ModalInstallDetail").modal('hide');     
	//			});
	//		});
	//		
	//		$("#ModalInstallDetail").on("hide", function() {   $("#ModalInstallDetail a.btn").off("click"); });
	//		$("#ModalInstallDetail").on("hidden", function() { $("#ModalInstallDetail").remove(); });
	//		$("#ModalInstallDetail").modal({                    
	//		  "backdrop"  : "static",
	//		  "keyboard"  : true,
	//		  "show"      : true                     
	//		});
	//		
	//		$('#title_tmp2').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed_ins + '&nbsp;</font><br>JOBNO : ' + jobno_ins);
	//		$('#title_tmp2').css('text-align', 'center');
	//		$('#title_tmp2').css('font-size', '14px');
	//		$('#title_tmp2').css('font-weight', 'bold');
	//		$('#isi_tmp2').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
	//		$.post('operator/2_get_installdata_detail.php', {
	//			jobno_ins:jobno_ins, zfeed_ins:zfeed_ins, model_ins:model_ins, serial_ins:serial_ins, pwbname_ins:pwbname_ins,
	//			process_ins:process_ins, jdate_ins:jdate_ins, total_ins:total_zfeed_ins
	//		},
	//		function(result) { $('#isi_tmp2').html(result).show(); });
	//	}
	//	else{
	//		alert("Checked Z-FEEDER to Installation Part !");
	//	}
	//}
	function selectjob_install(no){
		jobno_ins  = document.getElementById("jobno_install_slct"+no).value;
		zfeed_ins  = document.getElementById("zfeeder_install_slct"+no).value;
		model_ins  = document.getElementById("model_install_slct"+no).value;
		serial_ins = document.getElementById("serial_install_slct"+no).value;
		pwbname_ins= document.getElementById("pwbname_install_slct"+no).value;
		process_ins= document.getElementById("process_install_slct"+no).value;
		jdate_ins  = document.getElementById("jdate_install_slct"+no).value;
		feeder_no  = no;
		
		$("#ModalInstallDetail").on("show", function() {    
			$("#ModalInstallDetail a.btn").on("click", function(e) {
				$("#ModalInstallDetail").modal('hide');     
			});
		});
		
		$("#ModalInstallDetail").on("hide", function() {   $("#ModalInstallDetail a.btn").off("click"); });
		$("#ModalInstallDetail").on("hidden", function() { $("#ModalInstallDetail").remove(); });
		$("#ModalInstallDetail").modal({                    
		  "backdrop"  : "static",
		  "keyboard"  : true,
		  "show"      : true                     
		});
		
		$('#title_tmp2').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed_ins + '&nbsp;</font><br>JOBNO : ' + jobno_ins);
		$('#title_tmp2').css('text-align', 'center');
		$('#title_tmp2').css('font-size', '14px');
		$('#title_tmp2').css('font-weight', 'bold');
		$('#isi_tmp2').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_installdata_detail.php', {
			jobno_ins:jobno_ins, zfeed_ins:zfeed_ins, model_ins:model_ins, serial_ins:serial_ins, pwbname_ins:pwbname_ins,
			process_ins:process_ins, jdate_ins:jdate_ins
		},
		function(result) { $('#isi_tmp2').html(result).show(); });
	}
	function startInstall(){
        var width = $(window).width();
		zfeed_spc_ins = zfeed_ins.split(' ').join('+');
        zfeed_pgr_ins = zfeed_spc_ins.split('#').join('::');
        if(confirm("Apakah Anda yangkin untuk memulai Install Part ini ?") == true){
			$.post('resp/install/start_install.php',{
					jobno_ins	: jobno_ins, 
					zfeed_ins	: zfeed_pgr_ins,
					nik_ins		: picknav_nik,
					jdate_ins	: jdate_ins,
					feederno	: feeder_no
				}
			);
		}	
		
		//if(width < 963 ){
		//	$.post('resp/install/start_install.php', {jobno_ins: jobno_ins, zfeed_ins:zfeed_pgr_ins, nik_ins : picknav_nik, jdate_ins : jdate_ins}, function(data, status) {
		//	//alert(data+"----"+status);
		//		if(status == "success"){
		//			window.location.assign("/picknav/dashboard.php?operator=2_smartInstall&nik="+picknav_nik+"&jobno="+jobno_ins+"&zfeed="+zfeed_pgr_ins+"&row="+feeder_no+"&model="+model_ins+"&serial="+serial_ins+"&pwbnm="+pwbname_ins+"&process="+process_ins+"&jdate="+jdate_ins);}
		//		else{
		//			alert('Data not found !');
		//		}
		//	});
		//}else{
		//	$.post('resp/install/start_install.php', {jobno_ins : jobno_ins, zfeed_ins:zfeed_pgr_ins, nik_ins : picknav_nik, jdate_ins : jdate_ins}, function(data, status) {
		//		//alert(data+"----"+status);
		//		if(status == "success"){
		//			window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&nik="+picknav_nik+"&jobno="+jobno_ins+"&zfeed="+zfeed_pgr_ins+"&row="+feeder_no+"&model="+model_ins+"&serial="+serial_ins+"&pwbnm="+pwbname_ins+"&process="+process_ins+"&jdate="+jdate_ins);
		//		}
		//		else{
		//			alert('Data not found !');
		//		}
		//	});
		//}
		$.post('resp/install/start_install.php', {
			jobno_ins : jobno_ins,
			zfeed_ins:zfeed_pgr_ins,
			nik_ins : picknav_nik,
			jdate_ins : jdate_ins,
			feederno : feeder_no
			},
			function(data, status) {
				if(status == "success"){
					//var mystr = ;
					////Splitting it with : as the separator
					//var myarr = mystr.split(":");
					////Then read the values from the array where 0 is the first
					//var myvar = myarr[0] + ":" + myarr[1];
					
					var request_uri = location.pathname + location.search;
					var myarr = request_uri.split("/");
					var myvar = myarr[1];
					window.location.assign("/"+myvar+"/dashboard.php?operator=2_smartInstallDesk&jobno="+jobno_ins+"&row="+feeder_no+"&model="+model_ins+"&serial="+serial_ins+"&pwbnm="+pwbname_ins+"&process="+process_ins+"&jdate="+jdate_ins);
				}
				else{
					alert('Data tidak ditemukan !');
				}
			}
		);
		
        
    }
	function enterjobno(event){
		var x = event.which || event.keyCode;
		if(x == 13) { search_install(); }
		$("#src_jobno_install").focus();
		return false; 
	}
</script>
<!-- modal select job -->
<div class="modal fade" id="ModalInstallSelect" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header modalstyle-header">
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<!--<button type="button" class="btn modalstyle-button" onclick="selectjob_install()">Select ZFeeder</button>-->
			</div>
		</div>
	</div>
</div>
<!--- modal detail job -->
<div class="modal fade" id="ModalInstallDetail" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header modalstyle-header">
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp2" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp2" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<button type="button" class="btn modalstyle-button" onclick="startInstall()">Start Installation</button>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<section id="content">
	<!-- search operator install -->
	<div id="show-src-install" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_sdate_install">Start Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_sdate_install" name="src_sdate_install" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date"/>
					<label class="control-label search-label-2" for="src_jobno_install">Job No</label>
					<input type="text" class="form-control search-input-2" id="src_jobno_install" name="src_jobno_install" onBlur="this.value=this.value.toUpperCase()" placeholder="Job No." maxlength="36"
					onkeypress="enterjobno(event)" autofocus />
				</td>
			</tr>
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_edate_install">End Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_edate_install" name="src_edate_install" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
					<button type="button" class="btn btn-default search-button-2" id="src_install" onclick="search_install()">
						<span class="glyphicon glyphicon-search"></span>
						SEARCH
					</button>
				</td>
			</tr>
		</table>
	</div>
	<!-- table loading list -->
	<div id="tbl_installdata" class="table table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</section>