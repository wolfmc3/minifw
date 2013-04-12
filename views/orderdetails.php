<?php
namespace views;
use framework\db\dbcontent;
class orderdetails extends dbcontent {
//TABELLA
protected $table = 'orderdetails';

//CHIAVE PRIMARIA
protected $idkey = 'orderNumber,productCode';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'orderLineNumber' =>   array(
    'name' => 'Linea',    'ontable' => 1,    'inputtype' => 'numeric',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'smallint',    'len' => 6,    'null' => 0,  ),
  'orderNumber' =>   array(
    'name' => 'Ordine',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
  'productCode' =>   array(
    'name' => 'Codice',    'ontable' => 1,    'inputtype' => 'text',    'relation' => 'products',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
  'quantityOrdered' =>   array(
    'name' => 'Quantità',    'ontable' => 1,    'inputtype' => 'numeric',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
  'priceEach' =>   array(
    'name' => 'Prezzo',    'ontable' => 1,    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
  '={quantityOrdered}*{priceEach}/' =>   array(
    'name' => 'Importo',    'ontable' => 1,  ),
  '?products/productCode' =>   array(
    'name' => 'Prodotto',    'ontable' => 1,  ),
  '?orders/orderNumber' =>   array(
    'name' => 'Ordine',    'ontable' => 1,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'orderNumber,productCode';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'Dettagli ordine';
}
}