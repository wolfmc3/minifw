<?php 
namespace views;

use framework\db\dbcontent;
class payments extends dbcontent {
	protected $title = "Pagamenti";
	protected $table = "payments";
	
	protected $columnnames = array (
			'?customers/customerNumber' => 'Cliente',
			'checkNumber' => 'ID pagamento',
			'paymentDate' => 'Data',
			'amount' => 'Importo',
	);
	
	
	protected $idkey = "checkNumber";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'customerNumber' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => false,
					'ontable' => true,
			),
			'checkNumber' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'paymentDate' =>
			array (
					'datatype' => 'datetime',
					'len' => '0',
					'null' => false,
					'ontable' => true,
			),
			'amount' =>
			array (
					'datatype' => 'double',
					'len' => '0',
					'null' => false,
					'ontable' => true,
			),
	);
	
}