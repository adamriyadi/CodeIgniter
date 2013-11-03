	<?$CI = get_instance();?>
	<div class="apps_title" style="background:url('<?=base_url();?>resources/images/banner_fade.png');">
		<div class="apps_title_banner"><img src="<?=base_url();?>resources/images/banner2.png" /></div>
		<!--<div class="apps_title_logo">
		<img src="<?=base_url();?>resources/images/surveyor-indonesia.png" align="absmiddle" height="21" /></div>-->
		<div class="apps_title_text"><?=$CI->config->item("apps_title");?></div>
	</div>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
          <a class="navbar-brand" href="<?=base_url();?>">Sistem Monitoring QQ Batubara PLNBB</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right">
			<?if (!$session->userdata("logged_in")) { ?>
				<li><a data-toggle="modal" href="#loginDialog" id="loginLink"><span class="glyphicon glyphicon-user"></span>&nbsp;Sign in</a></li>
			<? } else{ ?>
				<li style="padding-top:10px;padding-right:10px;padding-left:15px;padding-bottom:10px;font-weight:bold;">Logged in as <?=$session->userdata("username");?></li>
				<li><a href="#" id="logoutLink"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a></li>
			<? }?>
          </ul>
		  <!--MENUS-->
          <ul class="nav navbar-nav navbar-left">
            <li><a href="<?=base_url();?>"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</a></a></li>
			<?if (!$session->userdata("logged_in")) { ?>
				<li><a href="#">Contact Us</a></li>
			<? } else { ?>
				<li><a href="#">My Workspace</a></li>
			<? }?>
          </ul>
		  <!--MENUS-->
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>

	<? if ($is_home == "1") { ?>
		<div id="myCarousel" class="carousel slide">
		  <!-- Indicators -->
			<ol class="carousel-indicators">
			  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			  <li data-target="#myCarousel" data-slide-to="1"></li>
			  <li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
			  <div class="item active">
				<a href="#">
					<div class="fill" style="background-image:url('<?=base_url();?>resources/images/backhead_2.png');"></div>
				</a>
			  </div>
			  <div class="item">
				<a href="#">
					<div class="fill" style="background-image:url('<?=base_url();?>resources/images/backhead_2.png"></div>
				</a>
			  </div>
			  <div class="item">
				<a href="#">
					<div class="fill" style="background-image:url('<?=base_url();?>resources/images/backhead_2.png"></div>
				</a>
			  </div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			  <span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
			  <span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	<? } ?>

	<div class="modal fade" id="loginDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog my-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close white" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Sign in</h4>
		  </div>
		  <div class="modal-body" style="width:100%;">
			  <div class="container well" style="width:100%;">
					<div class="alert alert-danger" id="login_error" style="display:none;">
						 <button type="button" class="close" aria-hidden="true" id="loginErrorDissmiss">&times;</button>
						 <span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span><span id="error_message"></span>
					</div>
					<div class="input-title">
					  Username
					</div>
					<div class="input-group" style="width:100%">
					  <input type="text" class="form-control input" placeholder="Username" id="Username">
					</div>
					<div class="input-title">
					  Password
					</div>
					<div class="input-group" style="width:100%">
					  <input type="password" class="form-control input" placeholder="Password" id="Password">
					</div>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="loginBtn">Sign in</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	