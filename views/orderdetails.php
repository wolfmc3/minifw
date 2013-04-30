<?php
/**
 *
 * orderdetails.php
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * View orderdetails
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class orderdetails extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'orderdetails';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'orderNumber,productCode';

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'orderLineNumber' =>   array(
					'name' => 'Linea',    'ontable' => 1,    'inputtype' => 'numeric',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'smallint',    'len' => 6,    'null' => 0,  ),
			'orderNumber' =>   array(
					'name' => 'Ordine',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
			'productCode' =>   array(
					'name' => 'Codice',    'ontable' => 1,    'inputtype' => 'text',    'relation' => 'products',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
			'quantityOrdered' =>   array(
					'name' => 'Quantità',    'ontable' => 1,    'inputtype' => 'numeric',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
					'priceEach' =>   array(
					'name' => 'Prezzo',    'ontable' => 1,    'inputtype' => 'currency',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'double',    'len' => 0,    'null' => 0,  ),
					'={quantityOrdered}*{priceEach}/' =>   array(
					'name' => 'Importo',    'ontable' => 1,  ),
					'?products/productCode' =>   array(
					'name' => 'Prodotto',    'ontable' => 1,  ),
					'?orders/orderNumber' =>   array(
					'name' => 'Ordine',    'ontable' => 1,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'orderNumber,productCode';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Dettagli ordini";
}