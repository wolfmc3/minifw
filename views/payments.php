<?php
/**
 *
 * payments.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */

namespace views;
use framework\db\dbpage;
/**
 *
 * View payments
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class payments extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'payments';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'customerNumber,checkNumber';

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'customerNumber' =>   array(
					'name' => 'Cliente',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
			'checkNumber' =>   array(
					'name' => 'Numero',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'paymentDate' =>   array(
					'name' => 'Data',    'ontable' => 1,    'inputtype' => 'date',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'datetime',    'len' => 0,    'null' => 0,  ),
			'amount' =>   array(
					'name' => 'Importo',    'ontable' => 1,    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'checkNumber';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Pagamenti";
}