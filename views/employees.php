<?php 
namespace views;
use framework\db\dbcontent;
class employees extends dbcontent {
	protected $title = "Dipendenti";
	
	protected $table = "employees";
	
	protected $columnnames = array (
			'employeeNumber' => 'Matricola',
			'lastName' => 'Cognome',
			'firstName' => 'Nome',
			'extension' => 'Interno',
			'email' => 'Email',
			'?offices/officeCode' => 'Sede',
			'+employees/table/reportsTo' => 'Responsabile',
			'jobTitle' => 'Mansione',
	);
	
	
	protected $idkey = "employeeNumber";
	
	protected $shortFields = "lastName";
	
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'lastName' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'firstName' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'extension' =>
			array (
					'datatype' => 'varchar',
					'len' => '10',
					'null' => false,
					'ontable' => true,
			),
			'email' =>
			array (
					'datatype' => 'varchar',
					'len' => '100',
					'null' => false,
					'ontable' => true,
			),
			'officeCode' =>
			array (
					'datatype' => 'varchar',
					'len' => '10',
					'null' => false,
					'ontable' => true,
			),
			'reportsTo' =>
			array (
					'datatype' => 'int',
					'len' => '11',
					'null' => true,
					'ontable' => true,
			),
			'jobTitle' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
	);
	
}