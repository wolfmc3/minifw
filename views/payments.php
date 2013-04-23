<?php
namespace views;
use framework\db\dbpage;
class payments extends dbpage {
//TABELLA
protected $table = 'payments';

//CHIAVE PRIMARIA
protected $idkey = 'customerNumber,checkNumber';

//PERMESSI
protected $addRecord = TRUE;
protected $editRecord = TRUE;
protected $deleteRecord = TRUE;
protected $viewRecord = TRUE;

//LISTA COLONNE e IMPOSTAZIONI
protected $columns = array(
  'customerNumber' =>   array(
    'name' => 'Cliente',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
  'checkNumber' =>   array(
    'name' => 'Numero',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
  'paymentDate' =>   array(
    'name' => 'Data',    'ontable' => 1,    'inputtype' => 'date',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'datetime',    'len' => 0,    'null' => 0,  ),
  'amount' =>   array(
    'name' => 'Importo',    'ontable' => 1,    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
);
	
//CAMPO DESCRIZIONE
protected $DescriptionKeys = 'checkNumber';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
protected $title = "Pagamenti";
}