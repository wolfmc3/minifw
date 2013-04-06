<?php 
use framework\db\dbcontent;
class content extends dbcontent {
	protected $title = "Sedi";
	protected $table = "offices";
	protected $columnnames = array (
			'city' => 'Città',
			'phone' => 'Telefono',
			'addressLine1' => 'Indirizzo 1',
			'addressLine2' => 'Indirizzo 2',
			'state' => 'Stato',
			'country' => 'Nazione',
			'postalCode' => 'Codice postale',
			'territory' => 'Territorio',
	);
	
	
	protected $idkey = "officeCode";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'city' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'phone' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'addressLine1' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'addressLine2' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => true,
					'ontable' => true,
			),
			'state' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => true,
					'ontable' => true,
			),
			'country' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'postalCode' =>
			array (
					'datatype' => 'varchar',
					'len' => '15',
					'null' => false,
					'ontable' => true,
			),
			'territory' =>
			array (
					'datatype' => 'varchar',
					'len' => '10',
					'null' => false,
					'ontable' => true,
			),
	);
	
}