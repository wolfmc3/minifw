<?php
namespace views;
use framework\db\dbpage;
class productlines extends dbpage {
//TABELLA
protected $table = 'productlines';

//CHIAVE PRIMARIA
protected $idkey = 'productLine';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'productLine' =>   array(
    'name' => 'productLine',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'textDescription' =>   array(
    'name' => 'textDescription',    'ontable' => 1,    'inputtype' => 'longtext',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 4000,    'null' => 1,  ),
  'htmlDescription' =>   array(
    'name' => 'htmlDescription',    'ontable' => 1,    'inputtype' => 'longtext',    'relation' => '',    'regexpr' => '',    'datatype' => 'mediumtext',    'len' => 0,    'null' => 1,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'productLine';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
protected $title = "Linee prodotti";
}