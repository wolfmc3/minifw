<?php 
namespace views;
//use framework\db\dbcontent;
use framework\db\viewdesign;
class orderdetails extends viewdesign {
	protected $title = "Dettaglio ordini";
	protected $table = "orderdetails";
	protected $columnnames = array (
			'?orders/orderNumber' => 'Numero ordine',
			'?products/productCode' => 'Codice prodotto',
			'quantityOrdered' => 'Quantità',
			'priceEach' => 'Prezzo',
			'orderLineNumber' => 'Linea',
	);
		
	protected $idkey = "orderNumber,productCode";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'orderNumber' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => false,
					'ontable' => true,
			),
			'productCode' =>
			array (
					'datatype' => 'varchar',
					'len' => '15',
					'null' => false,
					'ontable' => true,
			),
			'quantityOrdered' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => false,
					'ontable' => true,
			),
			'priceEach' =>
			array (
					'datatype' => 'double',
					'len' => '0',
					'null' => false,
					'ontable' => true,
			),
			'orderLineNumber' =>
			array (
					'datatype' => 'smallint',
					'len' => '6',
					'null' => false,
					'ontable' => true,
			),
	);
	
}