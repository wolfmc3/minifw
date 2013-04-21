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
<html lang="it" >
<!-- URI:<?php echo framework\app::Controller()->uri; ?> -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $this->title() ?></title>
<?php $this->scripts(); ?>
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
<div id="menu" class="navbar navbar-static-top">
<?php echo $this->menu(); ?>
</div>
<div class="container">
<?php echo $this->results; ?>
</div>
<?php echo app::Controller()->messages(); ?>
</body>
</html>

