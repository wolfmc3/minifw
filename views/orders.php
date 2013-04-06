<?php 
use framework\db\dbcontent;
class content extends dbcontent {
	protected $title = "Ordini";
	protected $table = "orders";
	protected $columnnames = array (
			'orderNumber' => 'Colonna orderNumber',
			'orderDate' => 'Colonna orderDate',
			'requiredDate' => 'Colonna requiredDate',
			'shippedDate' => 'Colonna shippedDate',
			'status' => 'Colonna status',
			'comments' => 'Colonna comments',
			'?customerNumber/customers/customerNumber/customerName' => 'Colonna customerNumber',
	);
	
	
	protected $idkey = "orderNumber";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'orderNumber' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => false,
					'ontable' => true,
			),
			'orderDate' =>
			array (
					'datatype' => 'datetime',
					'len' => '0',
					'null' => false,
					'ontable' => true,
			),
			'requiredDate' =>
			array (
					'datatype' => 'datetime',
					'len' => '0',
					'null' => false,
					'ontable' => true,
			),
			'shippedDate' =>
			array (
					'datatype' => 'datetime',
					'len' => '0',
					'null' => true,
					'ontable' => true,
			),
			'status' =>
			array (
					'datatype' => 'varchar',
					'len' => '15',
					'null' => false,
					'ontable' => true,
			),
			'comments' =>
			array (
					'datatype' => 'text',
					'len' => '0',
					'null' => true,
					'ontable' => false,
			),
			'customerNumber' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => false,
					'ontable' => true,
			),
	);
	
}