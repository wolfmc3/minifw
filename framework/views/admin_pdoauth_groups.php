<?php
namespace framework\views;
use framework\db\dbpage;
class admin_pdoauth_groups extends dbpage {
//TABELLA
protected $table = 'groups';

protected $database = 'pdoauth';

//CHIAVE PRIMARIA
protected $idkey = 'group';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'group' =>   array(
    'name' => 'group',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 12,    'null' => 0,  ),
  'name' =>   array(
    'name' => 'name',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'group';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'PdoAuth Gruppi';
}
}