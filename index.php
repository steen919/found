<?php
	if(!defined('WB_URL')) {
		header('Location: ../index.php');
		exit(0);
	}
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="sv"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="sv"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="sv"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="sv">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8" />

		<!-- Set the viewport width to device width for mobile -->
		<meta name="viewport" content="width=device-width" />

		<title><?php echo WEBSITE_TITLE; ?> - <?php echo PAGE_TITLE; ?></title>

		<!-- Included CSS Files -->
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/globals.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/typography.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/grid.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/ui.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/buttons.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/tabs.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/navbar.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/forms.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/orbit.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/foundation-style/reveal.css">
		<link rel="stylesheet" href="<?php echo TEMPLATE_DIR; ?>/stylesheets/app.css">

		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/modernizr.foundation.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/jquery.min.js"></script>
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>
	<body>
		<div style="visibility:hidden;display:none;">
			<?php 
				if(file_exists(WB_PATH.'/modules/expcount/counter.php')) {
					include(WB_PATH.'/modules/expcount/counter.php'); 
				} 
			?>
		</div>
	
		<div class="row" id="head">
			<div class="twelve columns">
				<header>
					<h1><?php echo WEBSITE_DESCRIPTION; ?></h1>														
				</header>	
			</div>		
		</div>
		<div class="row">
			<div class="twelve columns">
				<div id="menu">
					<?php show_menu2(
						$aMenu          = 0,
					    $aStart         = SM2_ROOT,
					    $aMaxLevel      = SM2_START,
					    $aOptions       = SM2_TRIM|SM2_PRETTY,
					    $aItemOpen      = '[li][a]| [menu_title] |</a>',
					    $aItemClose     = '</li>',
					    $aMenuOpen      = '[ul]',
					    $aMenuClose     = '</ul>',
					    $aTopItemOpen   = false,
					    $aTopMenuOpen   = false); ?>
				</div>
				<hr />
				<div style="font-size:8pt;margin:5px;color:grey;">
					<?php show_breadcrumbs(); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="ten columns">				
				<!-- content starts here -->
				<div class="entry">
					<!-- edit link here if admin -->
					<?php  
						if (FRONTEND_LOGIN == 'enabled' AND is_numeric($wb->get_session('USER_ID'))) {
							// Get permissons
							if ($page_id) { 
								$this_page = $page_id; 
							} else { 
								$this_page = $wb->default_page_id; 
							}
							$database = new database();
							$results = $database->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '$this_page'");
							$results_array = $results->fetchRow();
							$old_admin_groups = explode(',', $results_array['admin_groups']);
							$old_admin_users = explode(',', $results_array['admin_users']);
							$this_user = $wb->get_session('GROUP_ID');
							if (is_numeric(array_search($this_user, $old_admin_groups)) ) {
								if ($page_id) { 
									$pid = $page_id; 
								} else { 
									$pid = $wb->default_page_id; 
								}							
					?>
							<a href="<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $pid; ?>" target="admin">
								<img align="right" src="<?php echo ADMIN_URL ?>/images/modify_16.png" alt="<?php echo $HEADING['MODIFY_PAGE']; ?>" />
							</a>
					<?php
							} 
						} 
					?>  
					
					<?php page_content(); ?>
					
					<!-- Content ends here -->
				</div>
			</div>
			<div id="sidebar" class="two columns">
				<div class="panel">
					<div id="sidebar-feed" style="text-align:center;margin-bottom: 10px;">
						 <?php ShowFeed(); ?> <span style="color:#222630;">&nbsp; Nyheter</span><br />
					</div>
					<div id="sidebar-menu">
						<?php show_menu2(1, SM2_CURR+1, SM2_CURR+1); ?>
					</div>					
					<div id="sidebar-bottom" style="margin-top: 10px;">
						<br />
						<img src="<?php echo TEMPLATE_DIR; ?>/images/friluftsliv1.png" alt="Friluftsliv" />	
						<br />
						<img src="<?php echo TEMPLATE_DIR; ?>/images/nybyggetscout.png" />		
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="twelve columns">
				<hr />
			</div>
		</div>		
		<div class="row" id="foot">
			<div class="twelve columns centered ">
				<footer>					
					<p id="adress">
					  info@nybyggarscout.se &nbsp;|&nbsp; Ryttargårdskyrkan &nbsp;|&nbsp; 
					  Djurgårdsgatan 97 &nbsp;|&nbsp; 582 29 Linköping 
					</p>
					<p style="font-size:small;text-align: center;color: rgb(153, 153, 153);">[[SiteModified]]</p>
					<?php page_footer(); ?>
					<?php if(is_numeric($wb->get_session('USER_ID'))) { ?>
					<p style="font-size:small;text-align: center;color: rgb(153, 153, 153);"><a href="<?php echo LOGOUT_URL; ?>">Logga ut</a></p>
					<?php } else { ?>
					<p style="font-size:small;text-align: center;color: rgb(153, 153, 153);"><a href="http://www.nybyggarscout.se/account/login.php">Logga in</a></p>
					<?php } ?>					
				</footer>	
			</div>	
		</div>	
		
	
				
		<!-- Included JS Files -->
		
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/jquery.reveal.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/jquery.orbit-1.4.0.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/jquery.customforms.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/jquery.placeholder.min.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/foundation/jquery.tooltips.js"></script>
		<script src="<?php echo TEMPLATE_DIR; ?>/javascripts/app.js"></script>
		
		<script type="text/javascript">
		    $(window).load(function() {
		         $('#featured').orbit({
		              bullets: true
		         });
		     });
		</script>		

	</body>
</html>
