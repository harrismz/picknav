<?php
	$sdt = date("Y-m-d");
	$edt = date("Y-m-d");
?>
<div class="nav-side-menu">
    <div id="brand">
		<img width="150" src="asset/img/jvclogo.png" />
	</div>
	<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <?php if($picknav_levelno == 2){ ?>
				 <li id="userMenu">
					<a href="dashboard.php?smt=home">
						<!--<i class="fa fa-user fa-lg pull-right"></i>-->
						<i class="fa fa-home fa-lg pull-right"></i>
						&nbsp;&nbsp;
						<?php echo 'HOME ( '.$picknav_nik.' )'; ?>
					</a>
				</li>
				<li id="partnoMenu">
					<a href="dashboard.php?smt=partno">
						<i class="fa fa-search fa-lg pull-right"></i>
						&nbsp;&nbsp;PART NO.
					</a>
				</li>
				<li id="pickingMenu">
					<a href="dashboard.php?smt=smt_picknav&s=<?=$sdt?>&e=<?=$edt?>">
						<i class="fa fa-cart-arrow-down fa-lg pull-right"></i>
						&nbsp;&nbsp;PICKING
					</a>
				</li>
				<li id="installMenu">
					<a href="dashboard.php?smt=2_install&s=<?=$sdt?>&e=<?=$edt?>">
						<i class="fa fa-cogs fa-lg pull-right"></i>
						&nbsp;&nbsp;INSTALL
					</a>
				</li>
				<li id="checkedMenu">
					<a href="dashboard.php?smt=maintenance">
						<i class="fa fa-check-square-o fa-lg pull-right"></i>
						&nbsp;&nbsp;CHECKED
					</a>
				</li>
				<li id="replaceMenu">
					<a href="dashboard.php?smt=commingsoon">
						<i class="fa fa-exchange fa-lg pull-right"></i>
						&nbsp;&nbsp;REPLACE
					</a>
				</li>
				<li id="limitMenu">
					<a href="dashboard.php?smt=limit">
						<i class="fa fa-minus-square-o fa-lg pull-right"></i>
						&nbsp;&nbsp;LIMIT
					</a>
				</li>
				<li id="viewMenu">
					<a href="dashboard.php?smt=view_oll">
						<i class="fa fa-binoculars fa-lg pull-right"></i>
						&nbsp;&nbsp;VIEWER
					</a>
				</li> 
            <?php }elseif($picknav_levelno == 3){ ?>
                 <li id="userMenu">
					<a href="dashboard.php?operator=home">
						<!--<i class="fa fa-user fa-lg pull-right"></i>-->
						<i class="fa fa-home fa-lg pull-right"></i>
						&nbsp;&nbsp;
						<?php echo 'HOME ( '.$picknav_nik.' )'; ?>
					</a>
				</li>
				<li id="pickingMenu">
					<a href="dashboard.php?operator=loading_list">
						<i class="fa fa-cart-arrow-down fa-lg pull-right"></i>
						&nbsp;&nbsp;PICKING
					</a>
				</li> 
				<li id="installMenu">
					<a href="dashboard.php?operator=2_install_data">
						<i class="fa fa-cogs fa-lg pull-right"></i>
						&nbsp;&nbsp;INSTALL
					</a>
				</li> 
				<!--<li id="checkedMenu">
					<a href="dashboard.php?operator=3_checked">
						<i class="fa fa-check-square-o fa-lg pull-right"></i>
						&nbsp;&nbsp;CHECKED
					</a>
				</li> 
				<li id="replaceMenu">
					<a href="dashboard.php?operator=commingsoon">
						<i class="fa fa-exchange fa-lg pull-right"></i>
						&nbsp;&nbsp;REPLACE
					</a>
				</li> -->
				<li id="viewMenu">
					<a href="dashboard.php?operator=view_oll">
						<i class="fa fa-binoculars fa-lg pull-right"></i>
						&nbsp;&nbsp;VIEWER
					</a>
				</li> 
				<li id="criticalMenu">
					<a href="dashboard.php?operator=critical_data">
						<i class="fa fa-exclamation-triangle fa-lg pull-right"></i>
						&nbsp;&nbsp;CRITICAL
					</a>
				</li> 
            
			<?php }elseif($picknav_levelno == 4){ ?>
            
				<li id="limitMenu">
					<a href="dashboard.php?operator=commingsoon">
						<i class="fa fa-minus-square-o fa-lg pull-right"></i>
						&nbsp;&nbsp;;LIMIT
					</a>
				</li> 
            
			<?php }
				else{
					echo'';
				}
			?>
            
			<li id="helpMenu">
				<a href="asset/wi/WI_PICKNAV.pdf" target="_blank">
					<i class="fa fa-question fa-lg pull-right"></i>
					&nbsp;&nbsp;HELP
				</a>
			</li>
            <li id="logoutMenu">
				<a href="aksilogin.php?action=logout">
					<i class="fa fa-power-off fa-lg pull-right"></i>
					&nbsp;&nbsp;Log Out
				</a>
			</li>
		</ul>
    </div>
</div>
  