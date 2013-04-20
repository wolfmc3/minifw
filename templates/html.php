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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
<!-- URI:<?php echo framework\app::Controller()->uri; ?> -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->title() ?></title>
<?php $this->scripts(); ?>
</head>
<body>
<div id="view">
<div id="menu" >
<?php echo $this->menu(); ?>
</div>
<?php echo app::Controller()->messages(); ?>
<div id="contents">
<?php echo $this->results; ?>
</div>
</div>
</body>
</html>

