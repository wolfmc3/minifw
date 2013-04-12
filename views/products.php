<?php
namespace views;
use framework\db\dbcontent;
class products extends dbcontent {
//TABELLA
protected $table = 'products';

//CHIAVE PRIMARIA
protected $idkey = 'productCode';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'productCode' =>   array(
    'name' => 'Codice',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
  'productName' =>   array(
    'name' => 'Nome',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 70,    'null' => 0,  ),
  'productLine' =>   array(
    'name' => 'Linea',    'ontable' => 1,    'inputtype' => 'text',    'relation' => 'productLines',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'productScale' =>   array(
    'name' => 'Scala',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
  'productVendor' =>   array(
    'name' => 'Produttore',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'productDescription' =>   array(
    'name' => 'Descrizione',    'inputtype' => 'longtext',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'text',    'len' => 0,    'null' => 0,  ),
  'quantityInStock' =>   array(
    'name' => 'Giacenza',    'ontable' => 1,    'inputtype' => 'numeric',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'smallint',    'len' => 6,    'null' => 0,  ),
  'buyPrice' =>   array(
    'name' => 'Acquisto',    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
  'MSRP' =>   array(
    'name' => 'Listino',    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
  '?productLines/productLine' =>   array(
    'name' => 'Linea Prodotto',    'ontable' => 1,  ),
  '/orderdetails/table/productCode/productCode' =>   array(
    'name' => 'Ordini',    'ontable' => 1,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'productName';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return 'Prodotti';
}
}