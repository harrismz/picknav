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
		
        $("#src_sdate").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_edate").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#modelname").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#lotsize").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		$("#src_jobno").focusin(function(){ $(this).css("background-color", "#e7e5d6"); });
		
		$("#src_sdate").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_edate").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#modelname").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#lotsize").focusout(function(){ $(this).css("background-color", "#fff"); });
		$("#src_jobno").focusout(function(){ $(this).css("background-color", "#fff"); });
		
		var linelayout = '';
		linelayout = '<option value="" disabled selected>-- Select Line Layout --</option>';
		$("#lnlayout").html(linelayout);
		
		if(sdt==null && edt == null){
			document.getElementById("src_sdate").value = s;
			document.getElementById("src_edate").value = s;
		}
		else{
			document.getElementById("src_sdate").value = sdt;
			document.getElementById("src_edate").value = edt;
		}
        
		$('#tbl_joblist').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/picking/get_joblist.php', {
            src_sdate : $('[name=src_sdate]').val(),
            src_edate : $('[name=src_edate]').val(),
            src_model : "",
            src_lotsize : "",
            src_jobno : ""
        },
        function(result) {
            $('#tbl_joblist').html(result).show();
        });
		
        document.getElementById("show-src-joblist").style.display = "block";
        return false; 
        
	});
	function on_refresh(){
		
		if(sdt==null && edt == null){
			document.getElementById("src_sdate").value = s;
			document.getElementById("src_edate").value = s;
		}
		else{
			document.getElementById("src_sdate").value = sdt;
			document.getElementById("src_edate").value = edt;
		}
		
		$('#tbl_joblist').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/picking/get_joblist.php', {
            src_sdate : $('[name=src_sdate]').val(),
            src_edate : $('[name=src_edate]').val(),
            src_model : "",
            src_lotsize : "",
            src_jobno : ""
        },
        function(result) {
            $('#tbl_joblist').html(result).show();
        });
        document.getElementById("src_jobno").value = "";
        document.getElementById("lotsize").value = "";
        document.getElementById("modelname").value = "";
        document.getElementById("show-src-joblist").style.display = "none";
        return false;     
	}
	function on_search() {
		if(document.getElementById("show-src-joblist").style.display == "block"){
			document.getElementById("date_search").style.display = "none";
            document.getElementById("model_search").style.display = "none";
			document.getElementById("show-src-joblist").style.display = "none";
        }
		else if(document.getElementById("show-src-joblist").style.display == "none"){
			document.getElementById("date_search").style.display = "block";
            document.getElementById("model_search").style.display = "block";
			document.getElementById("show-src-joblist").style.display = "block";
		}
		return false;
	}
    function search_joblist(){
        var sdate = document.getElementById("src_sdate");
		var edate = document.getElementById("src_edate");
		var model = document.getElementById("modelname");
		var lotsize = document.getElementById("lotsize");
		var src_jobno = document.getElementById("src_jobno");
		
		if(sdate.value == "" && edate.value == "" && model.value == "" && lotsize.value == "" && src_jobno.value == ""){
			alert('Input the search category !');
			src_jobno.focus();
		}
		else if(sdate.value != "" && edate.value==""){
			alert('End Production Date must be fill !');
			edate.focus();
		}
		else if(sdate.value == "" && edate.value != ""){
			alert('Start Production Date must be fill !');
			sdate.focus();
		}
		else if(sdate.value > edate.value){
			alert('From Date larger than End Date / To Date !');
			sdate.focus();
		}
		else{
			$('#tbl_joblist').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

			$.post('get/picking/get_joblist.php', {
				src_sdate : $('[name=src_sdate]').val(),
				src_edate : $('[name=src_edate]').val(),
                src_model : $('[name=modelname]').val(),
                src_lotsize : $('[name=lotsize]').val(),
				src_jobno : $('[name=src_jobno]').val()
			},
			function(result) {
				$('#tbl_joblist').html(result).show();
			});
			document.getElementById("show-src-joblist").style.display = "none";
		}
		return false;
	}
	function popupJobDetail(x){
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
        $.post('get/picking/get_detailSmartPicking.php', {jobno : jobno},
        function(result) { $('#isi_tmp').html(result).show(); });
		$.post('get/picking/get_detail_zfeeder.php', {jobno : jobno, model:model, serial:serial},
        function(result) { $('#isi_detail_feeder').html(result).show(); });
		return false;
    }
    function passJobno(x){
        var jobno = document.getElementById("passJ"+x).value;
        var model = document.getElementById("passM"+x).value;
        var serial = document.getElementById("passS"+x).value;
        var sdate = $('[name=src_sdate]').val();
		var edate = $('[name=src_edate]').val();
		
		//alert (jobno + model + serial +'<><>'+ sdate + edate);
        
        if(confirm("Are you sure to Passing this Job No ?") == true){
            //alert (jobno + model + serial);
            var data = {"jobno":jobno, "model": model, "serial": serial};
            $.ajax({
                url : "dashboard.php?resp=resp_passjobno",
                type: "POST",
                data: data,
                success: function(data, status, xhr){
                    //alert('success');
                    window.location.assign("/picknav/dashboard.php?smt=smt_picknav&s="+sdate+"&e="+edate);
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
    function unfinish(x){
        var jobno = document.getElementById("jobno"+x).value;
        var jdate = document.getElementById("jdate"+x).value;
        var sdate = $('[name=src_sdate]').val();
		var edate = $('[name=src_edate]').val();
        
        if(confirm("Are you sure to Unfinishing this Job No ?") == true){
            var data = {"jobno":jobno, "jdate": jdate};
            $.ajax({
                url : "dashboard.php?resp=resp_unfinish",
                type: "POST",
                data: data,
				success: function(data,status){
					//alert(data);
					alert( "Data Unfinished." );
					if (status=='success'){
						window.location.assign("/picknav/dashboard.php?smt=smt_picknav&s="+sdate+"&e="+edate);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(XMLHttpRequest+'-'+textStatus+'-'+errorThrown);
				}
            });
        }
		return false;
    }
	function unpass(x){
		var jobno = document.getElementById("jobno"+x).value;
        var jdate = document.getElementById("jdate"+x).value;
        var sdate = $('[name=src_sdate]').val();
		var edate = $('[name=src_edate]').val();
        //alert(x+'-'+jobno+'-'+jdate);
        if(confirm("Are you sure to UNDO PASS this Job No ?") == true){
            var data = {"jobno":jobno, "jdate": jdate};
            $.ajax({
                url : "dashboard.php?resp=resp_unpass",
                type: "POST",
                data: data,
				success: function(data,status){
					//alert(data);
					alert( "Undo Pass Success." );
					if (status=='success'){
						window.location.assign("/picknav/dashboard.php?smt=smt_picknav&s="+sdate+"&e="+edate);
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
        var sdate = $('[name=src_sdate]').val();
		var edate = $('[name=src_edate]').val();
		
		//alert (jobno_detailzfeed+''+zfeed_detailzfeed+''+jdate_detailzfeed);
        if(confirm("Are you sure to Unfinishing this Z-Feeder ?") == true){
            var data = {"jobno":jobno_detailzfeed, "jdate": jdate_detailzfeed, "zfeed": zfeed_detailzfeed};
            $.ajax({
                url : "dashboard.php?resp=resp_unfinish",
                type: "POST",
                data: data,
                success: function(msg){
					//alert( "Data Unfinish: " + msg );
					window.location.assign("/picknav/dashboard.php?smt=smt_picknav&s="+sdate+"&e="+edate);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest+'-'+textStatus+'-'+errorThrown);
				}
			});
        }
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
				<div class="modalstyle-title col-xs-12 col-sm-12 col-md-12 col-lg-12">D E T A I L&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P I C K I N G</div>
				<div id="isi_tmp" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer"></div>
		</div>
	</div>
</div>
<!-- end modal -->
<div id="content">
	<div id="show-src-joblist" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="date_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label" for="src_jobno">Job No</label>
			<input type="text" class="form-control search-input" id="src_jobno" name="src_jobno" onBlur="this.value=this.value.toUpperCase()" placeholder="Job No"/>
			<label class="control-label  search-label" for="modelname">Model Name</label>
			<input type="text" class="form-control search-input" id="modelname" name="modelname" onBlur="this.value=this.value.toUpperCase()" placeholder="Model Name" />
			<label class="control-label  search-label" for="lotsize">Lot Size</label>
			<input type="text" class="form-control search-input" id="lotsize" name="lotsize" onBlur="this.value=this.value.toUpperCase()" placeholder="Lot Size" />
			</div>
		<div id="model_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label" for="src_sdate">Start Date</label>
			<input type="date" class="form-control search-input dt" id="src_sdate" name="src_sdate" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date" value="" />
			<label class="control-label search-label" for="src_edate">End Date</label>
			<input type="date" class="form-control search-input dt" id="src_edate" name="src_edate" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
			<button type="button" class="btn btn-default search-button" id="src_model" onclick="search_joblist()">
				<span class="glyphicon glyphicon-search"></span>
				SEARCH
			</button>
		</div>
	</div>
	<div id="tbl_joblist" class="table table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</div>
