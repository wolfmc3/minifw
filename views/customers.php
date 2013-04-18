<?php
namespace views;
use framework\db\dbpage;
class customers extends dbpage {
//TABELLA
protected $table = 'customers';

//CHIAVE PRIMARIA
protected $idkey = 'customerNumber';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'customerNumber' =>   array(
    'name' => 'Codice cliente',    'ontable' => 1,    'inputtype' => 'readonly',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
  'customerName' =>   array(
    'name' => 'Ragione sociale',    'ontable' => 1,    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'contactLastName' =>   array(
    'name' => 'Cognome',    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'contactFirstName' =>   array(
    'name' => 'Nome',    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'phone' =>   array(
    'name' => 'Telefono',    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'addressLine1' =>   array(
    'name' => 'Indirizzo',    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'addressLine2' =>   array(
    'name' => 'Indirizzo 2',    'inputtype' => 'text',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
  'city' =>   array(
    'name' => 'Città',    'ontable' => 1,    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'state' =>   array(
    'name' => 'Stato',    'ontable' => 1,    'inputtype' => 'text',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
  'postalCode' =>   array(
    'name' => 'Codice postale',    'inputtype' => 'text',    'regexpr' => '^[0-9]{3,15}$',    'datatype' => 'varchar',    'len' => 15,    'null' => 1,  ),
  'country' =>   array(
    'name' => 'Nazione',    'ontable' => 1,    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  '!employees/salesRepEmployeeNumber' =>   array(
    		'name' => 'Commerciale', 'ontable'=>1,  ),
    
  'salesRepEmployeeNumber' =>   array(
    'name' => 'Venditore',    'ontable' => 0,    'inputtype' => 'text','relation'=>"employees",    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 1,  ),
  'creditLimit' =>   array(
    'name' => 'Limite credito',    'inputtype' => 'currency',    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 1,  ),
  '={creditLimit}/2/' =>   array(
    'name' => 'Scoperto',  ),
  '/orders/table/customerNumber/customerNumber' =>   array(
    'name' => 'Ordini', 'ontable'=>1,  ),
  '/payments/table/customerNumber/customerNumber' =>   array(
    'name' => 'Pagamenti','ontable'=>1,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'customerName';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'Clienti';
}
}