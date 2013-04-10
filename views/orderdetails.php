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

	//LISTA COLONNE
	protected $columnnames = array (
			'orderNumber' => 'Colonna orderNumber',
			'productCode' => 'Colonna productCode',
			'quantityOrdered' => 'Colonna quantityOrdered',
			'priceEach' => 'Colonna priceEach',
			'orderLineNumber' => 'Colonna orderLineNumber',
			'?orders/orderNumber' => 'Colonna ?orders/orderNumber',
			'?products/productCode' => 'Colonna ?products/productCode',
	);

	//CAMPO DESCRIZIONE
	protected $shortFields = 'productCode';

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
			'productCode' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'text',
					'regexpr' => '',
					'datatype' => 'varchar',
					'len' => '15',
					'null' => 'false',
			),
			'quantityOrdered' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'numeric',
					'regexpr' => '',
					'datatype' => 'int',
					'len' => '11',
					'null' => 'false',
			),
			'priceEach' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'currency',
					'regexpr' => '',
					'datatype' => 'double',
					'len' => '0',
					'null' => 'false',
			),
			'orderLineNumber' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'numeric',
					'regexpr' => '',
					'datatype' => 'smallint',
					'len' => '6',
					'null' => 'false',
			),
	);

	//TITOLO VISUALIZZATO NEL BROWSER
	function title() {
		return 'orderdetails';
	}
}