<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    var nik = getUrlVars()["nik"];
    var jobno = getUrlVars()["jobno"];
    var zfeed2 = getUrlVars()["zfeed"];
	var zfeed1 = zfeed2.split('+').join(' ');
	var zfeed = zfeed1.split('::').join('#');
	var zfeed_ttile = zfeed.split('|').join(' <font color="#008080">)(</font> ');
    var model = getUrlVars()["model"];
    var serial = getUrlVars()["serial"];
    var pwbnm2 = getUrlVars()["pwbnm"];
    var pwbnm = pwbnm2.split('%20').join(' ');
	var proces = getUrlVars()["proces"];
    var jdate = getUrlVars()["jdate"];

    $(document).ready(function(){
		//alert(zfeed1);
		
       $('#tbl_smpdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/picking/get_smartPickingDesk.php', {
			nik : nik,
            jobno : jobno,
            zfeed : zfeed2
		},
		function(result) {
			$('#tbl_smpdesk').html(result).show();
		});
        document.getElementById("zfeed_header").innerHTML = "<b><font color='#008080'>Z-FEEDER</font><br><br><font color='#008080'>(</font>"+zfeed_ttile+"<font color='#008080'>)</font></b>";
        document.getElementById("jobno_header").innerHTML = "<b><font color='#008080'>JOB NO</font><br>"+jobno+"</b>";
        document.getElementById("model_header").innerHTML = "<b><font color='#008080'>MODEL : </font>"+model+"</b>";
        document.getElementById("serial_header").innerHTML = "<b><font color='#008080'>SERIAL : </font>"+serial+"</b>";
        document.getElementById("pwbnm_header").innerHTML = "<b><font color='#008080'>PWB NAME : </font>"+pwbnm+"</b>";
        document.getElementById("proces_header").innerHTML = "<b><font color='#008080'>PROCESS : </font>"+proces+"</b>";
        return false;  
    
        /*$(document).on('click','#proces_header', function(e){
            //var jobnoRow = $(this).find("td").first().text();
            alert ("a");
        });*/
    });
    
    
    function on_refresh_parlist(){
        $('#tbl_smpdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/picking/get_smartPickingDesk.php', {
			snik : nik,
            jobno : jobno,
            zfeed : zfeed2
		},
		function(result) {
			$('#tbl_smpdesk').html(result).show();
		});
		return false;    
	}
    function on_finishing_prepare(){
		
		var uncheck = document.getElementById("uncheck").value;
		var totlimit = document.getElementById("chk_limit").value;
        
		if(confirm("You have\n\nUnchecklist data : "+ uncheck +" Part\nLimit data : "+ totlimit +" Part\n\nAre you sure to finish this Loading List ?") == true){
            //alert(nik + jobno);
            $.post('resp/picking/finishing_prepare.php', {jobno : jobno, zfeed : zfeed2, nik : nik, jdate:jdate}, 
			function(data, status) {
                //alert(status+'This OLL has been finished. ');
                //alert(data, status);
				if (status == 'success'){
					window.location.assign("/picknav/dashboard.php?operator=loading_list");
				}
            });
        }
        return false;    
	}
    function on_smartpick(){
        //alert('ok onsmart');
        window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+nik+"&jobno="+jobno+"&zfeed="+zfeed2+"&row=0&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&proces="+proces+"&jdate="+jdate);
	}
    
    
</script>
<div id="content">
	<div class="panel-picknav">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border : solid #fa8f46 2px;">
			<h4 id="zfeed_header" align="center"></h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border : solid #fa8f46 2px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h4 id="jobno_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="model_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="serial_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="pwbnm_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="proces_header" align="center"></h4></div>
		</div>
		&nbsp;
	</div>
	<div id="tbl_smpdesk" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</div>
