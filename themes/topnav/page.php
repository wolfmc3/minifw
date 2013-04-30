<?php
use framework\app;
/**
 * Template pagina html
 *
 * Template necessario per le pagine standard
 *
 *
 */

?>
<!DOCTYPE html>
<html
	lang="it">
<!-- URI:<?php echo app::Controller()->uri; ?> -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
	<?= $this->title() ?>
</title>
<?php $this->css(); ?>
<?php $this->scripts(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo app::root() ?>css/navtop.css" media="screen">
</head>
<body>
<div id="wrap">
	<div id="menu" class="navbar navbar-static-top navbar-inverse">
		<div class='navbar-inner' id='navbar-inner'>
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php echo app::Controller()->Module("applink"); ?>
				<div class="nav-collapse collapse pull-left">
					<?php echo app::Controller()->Module("menu"); ?>
				</div>
				<div class="nav-collapse collapse pull-right">
					<?php echo app::Controller()->Module("logincontrol"); ?>
				</div>
				</div>
		</div>
	</div>
	<div class="container" style="padding-top: 18px">
		<?php echo $this->results; ?>
		<div style="height: 100px;"></div>
	</div>
</div>
	<div class="footer muted" style="">
	<?php echo app::Controller()->Module("footer"); ?>
	</div>
	<?php echo app::Controller()->Module("sysmsg"); ?>
	</body>
</html>

