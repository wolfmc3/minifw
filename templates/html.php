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
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE><?= $this->title() ?></TITLE>
<?php $this->scripts(); ?>
</HEAD>
<BODY>
<div id="view">
<div id="menu" >
<?php echo $this->menu(); ?>
</div>
<div id="contents">
<?php echo $this->results; ?>
</div>
</div>
</BODY>
</HTML>

