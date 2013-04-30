<?php
/**
 *
 * orders.php
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * orders
 *
 * Visualizza la tabella di database ordini
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class orders extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'orders';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'orderNumber';


	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'orderNumber' =>   array(
					'name' => 'Numero ordine',    'ontable' => 1,    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
			'orderDate' =>   array(
					'name' => 'Data ordine',    'ontable' => 1,    'inputtype' => 'date',    'required' => 1,    'regexpr' => '',    'datatype' => 'datetime',    'len' => 0,    'null' => 0,  ),
			'requiredDate' =>   array(
					'name' => 'Data richiesta',    'ontable' => 1,    'inputtype' => 'date',    'required' => 1,    'regexpr' => '',    'datatype' => 'datetime',    'len' => 0,    'null' => 0,  ),
			'shippedDate' =>   array(
					'name' => 'Data spedizione',    'ontable' => 1,    'inputtype' => 'datetime',    'regexpr' => '',    'datatype' => 'datetime',    'len' => 0,    'null' => 1,  ),
			'status' =>   array(
					'name' => 'Stato',    'ontable' => 1,    'inputtype' => 'text',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
					'comments' =>   array(
					'name' => 'Commenti',    'ontable' => 1,    'inputtype' => 'longtext',    'regexpr' => '',    'datatype' => 'text',    'len' => 0,    'null' => 1,  ),
					'customerNumber' =>   array(
					'name' => 'Cliente',    'ontable' => 1,    'inputtype' => 'text',  'relation'=>"customers",  'required' => 1,    'regexpr' => '',    'datatype' => 'int',    'len' => 11,    'null' => 0,  ),
					'?customers/customerNumber' =>   array(
					'name' => 'Cliente',    'ontable' => 1,  ),
					'/orderdetails/table/orderNumber/orderNumber' =>   array(
					'name' => 'Dettagli',    'ontable' => 1,  ),
					'+orderdetails/table/orderNumber/orderNumber' =>   array(
					'name' => 'Dettagli',    'ontable' => 1,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'orderNumber,orderDate';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Ordini";
}