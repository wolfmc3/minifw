<?php
namespace views;
use framework\db\dbcontent;
class orders extends dbcontent {
//TABELLA
protected $table = 'orders';

//CHIAVE PRIMARIA
protected $idkey = 'orderNumber';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE
protected $columnnames = array (
  'orderNumber' => 'Numero',
  'orderDate' => 'Data ordine',
  'requiredDate' => 'Data richiesta',
  'shippedDate' => 'Data spedizione',
  'status' => 'Stato',
  'comments' => 'Commenti',
  'customerNumber' => 'Cliente',
  '?customers/customerNumber' => 'Cliente',
  '/orderdetails/table/orderNumber/orderNumber' => 'Dettagli',
  '+orderdetails/table/orderNumber/orderNumber' => 'Dettagli',
);
	
//CAMPO DESCRIZIONE
protected $shortFields = 'orderDate';
		
//IMPOSTAZIONI
protected $columnsettings = array (
  'orderNumber' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'readonly',
    'regexpr' => '',
    'datatype' => 'int',
    'len' => '11',
    'null' => 'false',
  ),
  'orderDate' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'date',
    'regexpr' => '',
    'datatype' => 'datetime',
    'len' => '0',
    'null' => 'false',
  ),
  'requiredDate' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'date',
    'regexpr' => '',
    'datatype' => 'datetime',
    'len' => '0',
    'null' => 'false',
  ),
  'shippedDate' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'date',
    'regexpr' => '',
    'datatype' => 'datetime',
    'len' => '0',
    'null' => 'true',
  ),
  'status' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'text',
    'regexpr' => '',
    'datatype' => 'varchar',
    'len' => '15',
    'null' => 'false',
  ),
  'comments' => 
  array (
    'inputtype' => 'longtext',
    'regexpr' => '',
    'datatype' => 'text',
    'len' => '0',
    'null' => 'true',
  ),
  'customerNumber' => 
  array (
    'ontable' => 'true',
    'inputtype' => 'numeric',
    'regexpr' => '',
    'datatype' => 'int',
    'len' => '11',
    'null' => 'false',
  ),
);
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'Ordini';
}
}