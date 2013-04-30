<?php
/**
 *
 * productlines.php
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * View productlines
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class productlines extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'productlines';

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'productLine';

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'productLine' =>   array(
					'name' => 'productLine',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
			'textDescription' =>   array(
					'name' => 'textDescription',    'ontable' => 1,    'inputtype' => 'longtext',    'relation' => '',    'regexpr' => '',    'datatype' => 'varchar',    'len' => 4000,    'null' => 1,  ),
			'htmlDescription' =>   array(
					'name' => 'htmlDescription',    'ontable' => 1,    'inputtype' => 'html',    'relation' => '',    'regexpr' => '',    'datatype' => 'mediumtext',    'len' => 0,    'null' => 1,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'productLine';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Linee prodotti";
}