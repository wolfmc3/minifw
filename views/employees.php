<?php
/**
 *
 * employees.php
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * View employees
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class employees extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'employees';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'employeeNumber';

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'employeeNumber' =>   array(
					'name' => 'Matricola',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
			'lastName' =>   array(
					'name' => 'Cognome',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'firstName' =>   array(
					'name' => 'Nome',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'extension' =>   array(
					'name' => 'Interno',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
			'email' =>   array(
			'name' => 'Email',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 100,    'null' => 0,  ),
			'officeCode' =>   array(
			'name' => 'Ufficio',    'inputtype' => 'text',    'relation' => 'offices',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 10,    'null' => 0,  ),
			'reportsTo' =>   array(
			'name' => 'Responsabile',    'ontable' => 1,    'inputtype' => 'text',    'relation' => 'employees',    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 1,  ),
			'jobTitle' =>   array(
			'name' => 'Mansione',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'!offices/officeCode/' =>   array(
			'name' => 'Ufficio',    'ontable' => 1,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'lastName,firstName,jobTitle';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Dipendenti";
}