<?php
/**
 *
 * minisite.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace views;
use framework\db\dbpage;
/**
 *
 * View minisite
 *
 * Demo per minisito
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 */
class minisite extends dbpage {
	/**
	 * @var string Nome tabella sul database
	 */
	protected $table = 'contents';
	/**
	 *
	 * @var string Nome database (config)
	 */
	protected $database = 'minifwsite';

	/**
	 * @var string Titolo della pagina
	 */
	protected $title = "Mini Sito";
	/**
	 *
	 * @var string Azione predefinita tabella
	 */
	protected $defaultTableAction = "item";

	/**
	 * @var string Chiave primaria tabella
	 */
	protected $idkey = 'name';
	/**
	 *
	 * @var boolean Utilizza i template per visualizzare i dati
	 */
	protected $customTable = TRUE;

	/**
	 * @var array Definizione colonne
	 */
	protected $columns = array(
			'title' =>   array(
					'name' => 'Titolo',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 120,    'null' => 0,  ),
			'content' =>   array(
					'name' => 'content',    'inputtype' => 'html',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'text',    'len' => 0,    'null' => 0,  ),
			'name' =>   array(
					'name' => 'name',    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 50,    'null' => 0,  ),
	);

	/**
	 * @var string Campo che descrive il record
	*/
	protected $DescriptionKeys = 'title';

}