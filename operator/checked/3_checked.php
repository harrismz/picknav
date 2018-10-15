<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
	var picknav_nik = '<?=$picknav_nik?>';
	//var jobno_checked, model_checked, serial_checked, pwbname_checked, process_checked, jdate_checked, total_zfeed_checked;
	var jobno_chk, zfeed_chk, model_chk, serial_chk, pwbname_chk, process_chk, jdate_chk, feeder_no;
	
	$(document).ready(function(){
        if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
        $('#tbl_checked').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/checked/3_get_checked.php', {
			src_sdate_chk : $('[name=""]').val(),
			src_edate_chk : $('[name=""]').val(),
			src_jobno_chk : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_checked').html(result).show();
		});
		return false;
	});
	function dismismodal(){ $('.modal').modal('hide'); }
	
	function on_refresh_checked(){
		$('#tbl_checked').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/checked/3_get_checked.php', {
			src_sdate_chk : $('[name=""]').val(),
			src_edate_chk : $('[name=""]').val(),
			src_jobno_chk : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_checked').html(result).show();
		});
		return false;     
	}
	function on_src_checked() {
		if(document.getElementById("show-src-checked").style.display == "block"){
            document.getElementById("show-src-checked").style.display = "none";
        }
		else{
            document.getElementById("show-src-checked").style.display = "block";
		}
	}
    function search_chk(){
        var sdate_chk = document.getElementById("src_sdate_chk");
		var edate_chk = document.getElementById("src_edate_chk");
		var jobno_chk = document.getElementById("src_jobno_chk");

        if(sdate_chk.value != "" && edate_chk.value==""){
            alert('End Date must be fill !');
            edate_chk.focus();
        }
        else if(sdate_chk.value == "" && edate_chk.value!=""){
            alert('Start Production Date must be fill !');
            sdate_chk.focus();
        }
        else if(sdate_chk.value > edate_chk.value){
            alert('From Date larger than End Date / To Date !');
            sdate_chk.focus();
        }
        else{
            $('#tbl_checked').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

            $.post('get/checked/3_get_checked.php', {
                src_sdate_chk : $('[name=src_sdate_chk]').val(),
                src_edate_chk : $('[name=src_edate_chk]').val(),
                src_jobno_chk : $('[name=src_jobno_chk]').val()
            },
            function(result) {
                $('#tbl_checked').html(result).show();
            });
            document.getElementById("show-src-checked").style.display = "none";
        }
        return false;
    }
	function popupChecked(x){
		jobno_chk  = document.getElementById("jobno_chk"+x).value;
		model_chk  = document.getElementById("model_chk"+x).value;
		serial_chk = document.getElementById("serial_chk"+x).value;
		pwbname_chk= document.getElementById("pwbname_chk"+x).value;
		process_chk = document.getElementById("process_chk"+x).value;
		jdate_chk  = document.getElementById("jdate_chk"+x).value;

        $("#ModalCheckedSelect").on("show", function() {    
            $("#ModalCheckedSelect a.btn").on("click", function(e) {
                $("#ModalCheckedSelect").modal('hide');     
            });
        });
        
        $("#ModalCheckedSelect").on("hide", function() {   $("#ModalCheckedSelect a.btn").off("click"); });
        $("#ModalCheckedSelect").on("hidden", function() { $("#ModalCheckedSelect").remove(); });
        $("#ModalCheckedSelect").modal({                    
          "backdrop"  : "static",
          "keyboard"  : true,
          "show"      : true                     
        });
        
        $('#title_tmp').html('JOBNO : ' + jobno_chk);
        $('#title_tmp').css('text-align', 'center');
        $('#title_tmp').css('font-size', '14px');
        $('#title_tmp').css('font-weight', 'bold');
        $('#isi_tmp').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/checked/3_get_chkSlctJob.php', {jobno_chk : jobno_chk, model_chk:model_chk, serial_chk:serial_chk, pwbname_chk:pwbname_chk, proces_chk:process_chk, jdate_chk:jdate_chk},
        function(result) { $('#isi_tmp').html(result).show(); });
    }
	function checkAll_checked(ele) {
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
	function selectjob_checked(no){
		jobno_chk  = document.getElementById("jobno_checked_slct"+no).value;
		zfeed_chk  = document.getElementById("zfeeder_checked_slct"+no).value;
		model_chk  = document.getElementById("model_checked_slct"+no).value;
		serial_chk = document.getElementById("serial_checked_slct"+no).value;
		pwbname_chk= document.getElementById("pwbname_checked_slct"+no).value;
		process_chk= document.getElementById("process_checked_slct"+no).value;
		jdate_chk  = document.getElementById("jdate_checked_slct"+no).value;
		feeder_no  = no;
		
		$("#ModalCheckedDetail").on("show", function() {    
			$("#ModalCheckedDetail a.btn").on("click", function(e) {
				$("#ModalCheckedDetail").modal('hide');     
			});
		});
		
		$("#ModalCheckedDetail").on("hide", function() {   $("#ModalCheckedDetail a.btn").off("click"); });
		$("#ModalCheckedDetail").on("hidden", function() { $("#ModalCheckedDetail").remove(); });
		$("#ModalCheckedDetail").modal({                    
		  "backdrop"  : "static",
		  "keyboard"  : true,
		  "show"      : true                     
		});
		
		$('#title_tmp2').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed_chk + '&nbsp;</font><br>JOBNO : ' + jobno_chk);
		$('#title_tmp2').css('text-align', 'center');
		$('#title_tmp2').css('font-size', '14px');
		$('#title_tmp2').css('font-weight', 'bold');
		$('#isi_tmp2').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/checked/3_get_chkDetail.php', {
			jobno_chk:jobno_chk, zfeed_chk:zfeed_chk, model_chk:model_chk, serial_chk:serial_chk, 
			pwbname_chk:pwbname_chk, process_chk:process_chk, jdate_chk:jdate_chk
		},
		function(result) { $('#isi_tmp2').html(result).show(); });
	}
	function startChecked(){
        var width = $(window).width();
		zfeed_spc_chk = zfeed_chk.split(' ').join('+');
        zfeed_pgr_chk = zfeed_spc_chk.split('#').join('::');
        if(confirm("Are you sure to Start this Installation ?") == true){
			$.post('resp/checked/start_checked.php', {
				jobno_chk : jobno_chk,
				zfeed_chk:zfeed_pgr_chk,
				nik_chk : picknav_nik,
				jdate_chk : jdate_chk,
				feederno : feeder_no
			},
			function(data, status) {
				//alert(data+''+status);
				if(status == "success"){
					window.location.assign("/picknav/dashboard.php?operator=3_checkedDesk&jobno="+jobno_chk+"&row="+feeder_no+"&model="+model_chk+"&serial="+serial_chk+"&pwbnm="+pwbname_chk+"&process="+process_chk+"&jdate="+jdate_chk+"&seq=0");
				}
				else{
					alert('Data not found !');
				}
			});
			return false
		}
		else{return false}
	}
</script>
<!-- modal select job -->
<div class="modal fade" id="ModalCheckedSelect" role="dialog">
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
				<!--<button type="button" class="btn modalstyle-button" onclick="selectjob_checked()">Select ZFeeder</button>-->
			</div>
		</div>
	</div>
</div>
<!--- modal detail job -->
<div class="modal fade" id="ModalCheckedDetail" role="dialog">
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
				<button type="button" class="btn modalstyle-button" onclick="startChecked()">Start Installation</button>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<section id="content">
	<!-- search operator checked -->
	<div id="show-src-checked" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_sdate_chk">Start Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_sdate_chk" name="src_sdate_chk" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date"/>
					<label class="control-label search-label-2" for="src_jobno_chk">Job No</label>
					<input type="text" class="form-control search-input-2" id="src_jobno_chk" name="src_jobno_chk" onBlur="this.value=this.value.toUpperCase()" placeholder="Job No."/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_edate_chk">End Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_edate_chk" name="src_edate_chk" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
					<button type="button" class="btn btn-default search-button-2" id="search_chk" onclick="search_chk()">
						<span class="glyphicon glyphicon-search"></span>
						SEARCH
					</button>
				</td>
			</tr>
		</table>
	</div>
	<!-- table loading list -->
	<div id="tbl_checked" class="table table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</section>