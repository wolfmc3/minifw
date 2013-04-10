<?php
namespace views;
use framework\db\dbcontent;
use framework\db\viewdesign;
class customers extends viewdesign {
	//TABELLA
	protected $table = 'customers';

	//CHIAVE PRIMARIA
	protected $idkey = 'customerNumber';

	//PERMESSI
	protected $addRecord = TRUE;
	protected $editRecord = TRUE;
	protected $deleteRecord = TRUE;
	protected $viewRecord = TRUE;

	//LISTA COLONNE
	protected $columnnames = array (
			'customerNumber' => 'Codice cliente',
			'customerName' => 'Ragione sociale',
			'contactLastName' => 'Cognome',
			'contactFirstName' => 'Nome',
			'phone' => 'Telefono',
			'addressLine1' => 'Indirizzo 1',
			'addressLine2' => 'Indirizzo 2',
			'city' => 'Città',
			'state' => 'Stato',
			'postalCode' => 'Codice postale',
			'country' => 'Nazione',
			'salesRepEmployeeNumber' => 'Venditore',
			'creditLimit' => 'Limite credito',
			'/orders/table/customerNumber/customerNumber' => 'Ordini',
			'/payments/table/customerNumber/customerNumber' => 'Pagamenti',
	);

	//CAMPO DESCRIZIONE
	protected $shortFields = 'customerNumber';

	//IMPOSTAZIONI
	protected $columnsettings = array (
			'customerNumber' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'readonly',
					'regexpr' => '',
					'datatype' => 'int',
					'len' => '11',
					'null' => 'false',
			),
			'customerName' =>
			array (
					'ontable' => 'false',
					'inputtype' => 'text',
					'regexpr' => '',
					'datatype' => 'varchar',
					'len' => '50',
					'null' => 'false',
			),
			'contactLastName' =>
			array (
					'ontable' => 'false',
					'inputtype' => 'text',
					'regexpr' => '',
					'datatype' => 'varchar',
					'len' => '50',
					'null' => 'false',
			),
			'contactFirstName' =>
			array (
					'ontable' => 'true',
					'inputtype' => 'text',
					'regexpr' => '',
					'datatype' => 'varchar',
					'len' => '50',
					'null' => 'false',
			),
			'phone' =>
			array (
					'ontable' => 'false',
					'inputtype' => 'text',
					'regexpr' => '^[0-9\-\s\,\.]*$',
					'datatype' => 'varchar',
					'len' => '50',
					'null' => 'false',
			),
			'addressLine1' =>
			array (
			'ontable' => 'false',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'varchar',
			'len' => '50',
			'null' => 'false',
			),
			'addressLine2' =>
			array (
			'ontable' => 'false',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'varchar',
			'len' => '50',
			'null' => 'true',
			),
			'city' =>
			array (
			'ontable' => 'true',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'varchar',
			'len' => '50',
			'null' => 'false',
			),
			'state' =>
			array (
			'ontable' => 'true',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'varchar',
			'len' => '50',
			'null' => 'true',
			),
			'postalCode' =>
			array (
			'ontable' => 'true',
			'inputtype' => 'text',
			'regexpr' => '^[0-9]{5,15}$',
			'datatype' => 'varchar',
			'len' => '15',
			'null' => 'true',
			),
			'country' =>
			array (
			'ontable' => 'true',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'varchar',
			'len' => '50',
			'null' => 'false',
			),
			'salesRepEmployeeNumber' =>
			array (
			'ontable' => 'true',
			'inputtype' => 'text',
			'regexpr' => '',
			'datatype' => 'int',
			'len' => '11',
			'null' => 'true',
			),
			'creditLimit' =>
			array (
			'ontable' => 'false',
			'inputtype' => 'currency',
			'regexpr' => '',
			'datatype' => 'double',
			'len' => '0',
			'null' => 'true',
			),
	);

	//TITOLO VISUALIZZATO NEL BROWSER
	function title() {
		return 'customers';
	}
}