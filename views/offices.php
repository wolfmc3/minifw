<?php
namespace views;
use framework\db\dbcontent;
class offices extends dbcontent {
//TABELLA
protected $table = 'offices';

//CHIAVE PRIMARIA
protected $idkey = 'officeCode';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'officeCode' =>   array(
    'name' => 'Codice',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
  'city' =>   array(
    'name' => 'Città',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'phone' =>   array(
    'name' => 'Telefono',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'addressLine1' =>   array(
    'name' => 'Indirizzo 1',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'addressLine2' =>   array(
    'name' => 'Indirizzo 2',    'inputtype' => 'text',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
  'state' =>   array(
    'name' => 'Stato',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
  'country' =>   array(
    'name' => 'Nazione',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'postalCode' =>   array(
    'name' => 'Codice postale',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
  'territory' =>   array(
    'name' => 'Area',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
  '/employees/table/officeCode/officeCode/' =>   array(
    'name' => 'Dipendenti',    'ontable' => 1,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'officeCode,city';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'Sedi';
}
}