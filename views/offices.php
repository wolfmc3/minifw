<?php
/**
 *
 * offices.php
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * View offices
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 */
class offices extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'offices';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'officeCode';

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'officeCode' =>   array(
					'name' => 'Codice',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
			'city' =>   array(
					'name' => 'Città',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'phone' =>   array(
					'name' => 'Telefono',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'addressLine1' =>   array(
					'name' => 'Indirizzo 1',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'addressLine2' =>   array(
					'name' => 'Indirizzo 2',    'inputtype' => 'text',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
					'state' =>   array(
					'name' => 'Stato',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 1,  ),
					'country' =>   array(
					'name' => 'Nazione',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
					'postalCode' =>   array(
					'name' => 'Codice postale',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
					'territory' =>   array(
					'name' => 'Area',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
					'/employees/table/officeCode/officeCode/' =>   array(
					'name' => 'Dipendenti',    'ontable' => 1,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'officeCode,city';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Sedi";
}