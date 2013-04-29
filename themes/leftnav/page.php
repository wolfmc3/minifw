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
<html lang="it">
<!-- URI:<?php echo app::Controller()->uri; ?> -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
	<?= $this->title() ?>
</title>
<?php $this->css(); ?>
<?php $this->scripts(); ?>

<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
	<div class="container-fluid" style="margin-top: 20px;">
		<div class="row-fluid">
			<div class="span2">
				<div class="text-center">
					<a href="/mini_fw/">
						<img src="/mini_fw/img/icon.png/width/12" />
						<img src="/mini_fw/img/icon.png/width/24" />
						<img src="/mini_fw/img/icon.png/width/32" />
						<img src="/mini_fw/img/icon.png/width/24" />
						<img src="/mini_fw/img/icon.png/width/12" />
					</a>
					<hr />
				</div>
				<div class="well">
					<?php echo app::Controller()->Module("menu"); ?>
				</div>
				<div class="well text-center">
					<?php echo app::Controller()->Module("themeswitch"); ?>
					<?php echo app::Controller()->Module("logincontrol"); ?>
					<br>
					<br>
				</div>

			</div>
			<div class="span9">
				<div class="well">
					<?php echo $this->results; ?>
				</div>
			</div>
		</div>
		<div class="row-fluid"></div>
		<?php echo app::Controller()->Module("footer"); ?>
	</div>

	<?php echo app::Controller()->Module("sysmsg"); ?>
</body>
</html>

