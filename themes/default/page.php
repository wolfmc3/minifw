<?php 
use framework\app;
?>
<!DOCTYPE HTML>
<html>
<head>
<title>
	<?= $this->title() ?>
</title>
<?php $this->scripts(); ?>

</head>

<body>
<?php echo str_replace("p>", "b>", app::Controller()->Module("menu")) ?>
<?php echo app::Controller()->Module("sysmsg") ?>
<?php echo $this->results ?>
<hr>
<?php echo app::Controller()->Module("themeswitch") ?>
</body>
</html>