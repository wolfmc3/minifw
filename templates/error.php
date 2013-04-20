<?php
/**
 * Template pagina non trovata
 * 
 * Template necessario per notificare le pagine non trovate
 *  
 */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php $this->Title() ?></title>
<?php $this->scripts(); ?>
</head>
<body>
<div id="view">
<div id="menu" >
<?php echo $this->menu(); ?>
</div>
<div id="contents">
  <p><b><?php echo $this->obj; ?></b> Errore: <?php echo $this->Title(); ?></p>
  <h3>La pagina richiesta non &egrave; disponibile</h3>
</div>
</div>
</body>
</html>

