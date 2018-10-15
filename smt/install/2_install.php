<script type="text/javascript" src="../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
    var n =  new Date();
	var y = n.getFullYear();
	var m = n.getMonth() + 1;
	var d = n.getDate();
	if (m < 10){ m = '0'+m; }
	else {m=m;}
	var s = y+'-'+m+'-'+d;
	
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
	var sdt   = getUrlVars()["s"];
	var edt   = getUrlVars()["e"];
	//alert(sdt+''+edt);
	
	$(document).ready(function(){
        if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
        
		//alert(getUrlVars());
		
        $("#src_sdate_instl").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_edate_instl").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_modnm_instl").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_lotsz_instl").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_jobno_instl").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		
		$("#src_sdate_instl").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_edate_instl").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_modnm_instl").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_lotsz_instl").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_jobno_instl").focusout(function(){ $(this).css("background-color", "#fff"); });
		
		var linelayout = '';
		linelayout = '<option value="" disabled selected>-- Select Line Layout --</option>';
		$("#lnlayout").html(linelayout);
		
		if(sdt==null && edt == null){
			document.getElementById("src_sdate_instl").value = s;
			document.getElementById("src_edate_instl").value = s;
		}
		else{
			document.getElementById("src_sdate_instl").value = sdt;
			document.getElementById("src_edate_instl").value = edt;
		}
        
		$('#tbl_install').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/install/2_get_install_admin.php', {
            src_sdate_instl 	: $('[name=src_sdate_instl]').val(),
            src_edate_instl 	: $('[name=src_edate_instl]').val(),
            src_model_instl 	: "",
            src_lotsize_instl 	: "",
            src_jobno_instl	 	: ""
        },
        function(result) {
            $('#tbl_install').html(result).show();
        });
		
        document.getElementById("show-src-install").style.display = "block";
        return false; 
        
	});
	function on_refresh(){
		
		if(sdt==null && edt == null){
			document.getElementById("src_sdate_instl").value = s;
			document.getElementById("src_edate_instl").value = s;
		}
		else{
			document.getElementById("src_sdate_instl").value = sdt;
			document.getElementById("src_edate_instl").value = edt;
		}
		
		$('#tbl_install').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/install/2_get_install_admin.php', {
           src_sdate_instl : $('[name=src_sdate_instl]').val(),
           src_edate_instl : $('[name=src_edate_instl]').val(),
           src_model_instl : "",
           src_lotsize_instl: "",
           src_jobno_instl	 : ""
        },
        function(result) {
            $('#tbl_install').html(result).show();
        });
        document.getElementById("src_jobno_instl").value = "";
        document.getElementById("src_lotsz_instl").value = "";
        document.getElementById("src_modnm_instl").value = "";
        document.getElementById("show-src-install").style.display = "none";
        return false;     
	}
	function on_search() {
		if(document.getElementById("show-src-install").style.display == "block"){
			document.getElementById("date_search").style.display = "none";
            document.getElementById("model_search").style.display = "none";
			document.getElementById("show-src-install").style.display = "none";
        }
		else if(document.getElementById("show-src-install").style.display == "none"){
			document.getElementById("date_search").style.display = "block";
            document.getElementById("model_search").style.display = "block";
			document.getElementById("show-src-install").style.display = "block";
		}
		return false;
	}
    function search_install(){
        var sdate_instl = document.getElementById("src_sdate_instl");
		var edate_instl = document.getElementById("src_edate_instl");
		var model_instl = document.getElementById("modelname_instl");
		var lotsize_instl = document.getElementById("src_lotsz_instl");
		var jobno_instl = document.getElementById("src_jobno_instl");
		
		if(sdate_instl.value == "" && edate_instl.value == "" && model_instl.value == "" && lotsize_instl.value == "" && jobno_instl.value == ""){
			alert('Input the search category !');
			jobno_instl.focus();
		}
		else if(sdate_instl.value != "" && edate_instl.value==""){
			alert('End Production Date must be fill !');
			edate_instl.focus();
		}
		else if(sdate_instl.value == "" && edate_instl.value != ""){
			alert('Start Production Date must be fill !');
			sdate_instl.focus();
		}
		else if(sdate_instl.value > edate_instl.value){
			alert('From Date larger than End Date / To Date !');
			sdate_instl.focus();
		}
		else{
			$('#tbl_install').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

			$.post('get/install/2_get_install_admin.php', {
				src_sdate_instl : $('[name=src_sdate_instl]').val(),
				src_edate_instl : $('[name=src_edate_instl]').val(),
                src_model_instl : $('[name=modelnm_instl]').val(),
                src_lotsize_instl: $('[name=lotsz_instl]').val(),
				src_jobno_instl	 :	 $('[name=src_jobno_instl]').val()
			},
			function(result) {
				$('#tbl_install').html(result).show();
			});
			document.getElementById("show-src-install").style.display = "none";
		}
		return false;
	}
	function installDetail(x){
        var jobno = document.getElementById("jobno"+x).value;
        var model = document.getElementById("model"+x).value;
        var serial = document.getElementById("serial"+x).value;
       
        $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
            $("#myModal a.btn").on("click", function(e) {
                $("#myModal").modal('hide');     // dismiss the dialog
            });
        });
        
        $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
            $("#myModal a.btn").off("click");
        });
        
        $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
            $("#myModal").remove();
        });
        
        $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
          "backdrop"  : "static",
          "keyboard"  : true,
          "show"      : true                     // ensure the modal is shown immediately
        });
        
        $('#title_tmp').html('<center>JOBNO : ' + jobno + '<br> Model : ' + model + ' | Serial : ' + serial + "</center>");
        $('#isi_tmp').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/install/2_get_detailInstall.php', {jobno : jobno},
        function(result) { $('#isi_tmp').html(result).show(); });
		$.post('get/install/2_get_detail_zfeeder.php', {jobno : jobno, model:model, serial:serial},
        function(result) { $('#isi_detail_feeder').html(result).show(); });
		return false;
    }
    function passJobno(x){
        var jobno = document.getElementById("passJ"+x).value;
        var model = document.getElementById("passM"+x).value;
        var serial = document.getElementById("passS"+x).value;
        var jdate = document.getElementById("passJD"+x).value;
        var sdate = $('[name=src_sdate_instl]').val();
		var edate = $('[name=src_edate_instl]').val();
		
		//alert (jobno + model + serial +'<><>'+ sdate + edate);
        
        if(confirm("Are you sure to Passing this Job No ?") == true){
           // alert (jobno +'$$'+ model +'$$'+  serial +'$$'+ jdate);
            var data = {"jobno":jobno, "model": model, "serial": serial, "jdate": jdate};
            $.ajax({
                url : "dashboard.php?resp=resp_passed",
                type: "POST",
                data: data,
                success: function(data, status, xhr){
                    //alert('success');
                    window.location.assign("/picknav/dashboard.php?smt=2_install&s="+sdate+"&e="+edate);
                },
                failure : function(data, status, xhr){
                    alert(data);
                    //window.open('dashboard.php?smt=smt_picknav&info=error',"_self");
                }
            });
        }
        else{
            alert('Cancel ?');
        }
		return false;
    }
    function unpass_ins(x){
		var jobno = document.getElementById("jobno"+x).value;
        var jdate = document.getElementById("jdate"+x).value;
        var sdate = $('[name=src_sdate]').val();
		var edate = $('[name=src_edate]').val();
        //alert(x+'-'+jobno+'-'+jdate);
        if(confirm("Are you sure to UNDO PASS this Job No ?") == true){
            var data = {"jobno":jobno, "jdate": jdate};
            $.ajax({
                url : "dashboard.php?resp=resp_unpass_ins",
                type: "POST",
                data: data,
				success: function(data,status){
					//alert(data);
					alert( "Undo Pass Success." );
					if (status=='success'){
						window.location.assign("/picknav/dashboard.php?smt=2_install&s="+sdate+"&e="+edate);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(XMLHttpRequest+'-'+textStatus+'-'+errorThrown);
				}
            });
        }
		return false;
    }
	function unfinish(x){
        var jobno = document.getElementById("jobno"+x).value;
        var jdate = document.getElementById("jdate"+x).value;
        var sdate = $('[name=src_sdate_instl]').val();
		var edate = $('[name=src_sdate_instl]').val();
        
        if(confirm("Are you sure to Unfinishing this Job No ?") == true){
            var data = {"jobno":jobno, "jdate": jdate};
            $.ajax({
                url : "dashboard.php?resp=resp_unfinish_install",
                type: "POST",
                data: data,
				success: function(data,status){
					//alert(data);
					alert( "Data Unfinished." );
					if (status=='success'){
						window.location.assign("/picknav/dashboard.php?smt=2_install&s="+sdate+"&e="+edate);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(XMLHttpRequest+'-'+textStatus+'-'+errorThrown);
				}
            });
        }
		return false;
    }
	function unfinish_zfeed(x){
        var jobno_detailzfeed = document.getElementById("jobno_detailzfeed"+x).value;
        var zfeed_detailzfeed = document.getElementById("zfeed_detailzfeed"+x).value;
        var jdate_detailzfeed = document.getElementById("jdate_detailzfeed"+x).value;
        var sdate = $('[name=src_sdate_instl]').val();
		var edate = $('[name=src_sdate_instl]').val();
		
        if(confirm("Are you sure to Unfinishing this Z-Feeder ?") == true){
		//alert (jobno_detailzfeed+''+zfeed_detailzfeed+''+jdate_detailzfeed);
            var data = {"jobno":jobno_detailzfeed, "jdate": jdate_detailzfeed, "zfeed": zfeed_detailzfeed};
            $.ajax({
                url : "dashboard.php?resp=resp_unfinish_install",
                type: "POST",
                data: data,
                success: function(data, status){
					alert( "Data Unfinished." );
					window.location.assign("/picknav/dashboard.php?smt=2_install&s="+sdate+"&e="+edate);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(XMLHttpRequest+'-'+textStatus+'-'+errorThrown);
				}
			});
        }
		return false;
    }
	function enterjobno(event){
		var x = event.which || event.keyCode;
		if(x == 13) { search_install(); }
		$("#src_jobno_install").focus();
		return false; 
	}


</script>
<!-- modal -->
<div class="modal fade" id="myModal" role="dialog" style="border: solid yellow 2px !important;">
	<div class="modal-dialog modal-lg">
		 Modal Content
		<div class="modal-content">
			<div class="modal-header modalstyle-header" style="border-radius: 5px 5px 0 0">
				<button type="button" class="modalstyle-close" data-dismiss="modal">&times;</button>
				<h4 id="title_tmp" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div class="modalstyle-title col-xs-12 col-sm-12 col-md-12 col-lg-12">Z - F E E D E R</div>
				<div id="isi_detail_feeder" class="table table-responsive"></div>
				<div class="modalstyle-title col-xs-12 col-sm-12 col-md-12 col-lg-12">D E T A I L&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I N S T A L L</div>
				<div id="isi_tmp" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer"></div>
		</div>
	</div>
</div>
<!-- end modal -->
<div id="content">
	<div id="show-src-install" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="date_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label" for="src_jobno_instl">Job No</label>
			<input type="text" class="form-control search-input" id="src_jobno_instl" name="src_jobno_instl" onBlur="this.value=this.value.toUpperCase()" placeholder="Job No"  maxlength="36"
			onkeypress="enterjobno(event)" autofocus />
			<label class="control-label  search-label" for="modelnm_instl">Model Name</label>
			<input type="text" class="form-control search-input" id="modelnm_instl" name="modelnm_instl" onBlur="this.value=this.value.toUpperCase()" placeholder="Model Name" />
			<label class="control-label  search-label" for="lotsz_instl">Lot Size</label>
			<input type="text" class="form-control search-input" id="lotsz_instl" name="lotsz_instl" onBlur="this.value=this.value.toUpperCase()" placeholder="Lot Size" />
			</div>
		<div id="model_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label" for="src_sdate_instl">Start Date</label>
			<input type="date" class="form-control search-input dt" id="src_sdate_instl" name="src_sdate_instl" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date" value="" />
			<label class="control-label search-label" for="src_edate_instl">End Date</label>
			<input type="date" class="form-control search-input dt" id="src_edate_instl" name="src_edate_instl" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
			<button type="button" class="btn btn-default search-button" id="src_model" onclick="search_install()">
				<span class="glyphicon glyphicon-search"></span>
				SEARCH
			</button>
		</div>
	</div>
	<div id="tbl_install" class="table table-responsive"></div>
</div>
