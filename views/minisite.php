<?php
namespace views;
use framework\db\dbpage;
class minisite extends dbpage {
//TABELLA
protected $table = 'contents';
protected $database = 'minifwsite';

protected $title = "Mini Sito";
protected $defaultTableAction = "item";

//CHIAVE PRIMARIA
protected $idkey = 'name';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

protected $customTable = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'title' =>   array(
    'name' => 'Titolo',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 120,    'null' => 0,  ),
  'content' =>   array(
    'name' => 'content',    'inputtype' => 'html',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'text',    'len' => 0,    'null' => 0,  ),
  'name' =>   array(
    'name' => 'name',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'title';
				 	
}