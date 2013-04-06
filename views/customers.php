<?php 
use framework\db\dbcontent;
class content extends dbcontent {
	protected $table = "customers";
	protected $columnnames = array (
			'customerName' => 'Ragione sociale',
			'contactLastName' => 'Cognome',
			'contactFirstName' => 'Nome',
			'phone' => 'Telefono',
			'addressLine1' => 'Indirizzo 1',
			'addressLine2' => 'Indirizzo 2',
			'city' => 'Città',
			'state' => 'Stato',
			'postalCode' => 'CAP',
			'country' => 'Nazione',
			'salesRepEmployeeNumber' => 'Codice Venditore',
			'creditLimit' => 'Limite credito',
	);
	
	
	protected $idkey = "customerNumber";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'customerName' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'contactLastName' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => false,
			),
			'contactFirstName' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => false,
			),
			'phone' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => false,
			),
			'addressLine1' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => false,
			),
			'addressLine2' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => true,
					'ontable' => false,
			),
			'city' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'state' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => true,
					'ontable' => true,
			),
			'postalCode' =>
			array (
			'datatype' => 'varchar',
			'len' => '15',
			'null' => true,
			'ontable' => false,
			),
			'country' =>
			array (
			'datatype' => 'varchar',
			'len' => '50',
			'null' => false,
			'ontable' => true,
			),
			'salesRepEmployeeNumber' =>
			array (
			'datatype' => 'int',
			'len' => '11',
			'null' => true,
			'ontable' => false,
			),
			'creditLimit' =>
			array (
			'datatype' => 'double',
			'len' => false,
			'null' => true,
			'ontable' => false,
			),
	);
	
	function title() {
		return "Clienti";
	}
	
}