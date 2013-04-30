<?php
/**
 *
 * admin_pdoauth_groups.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;
use framework\db\dbpage;

/**
 *
 * admin_pdoauth_groups
 *
 * Pagina per la gestione dei gruppi per il modulo sicurezza pdoauth
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 * @see \framework\security\modules\pdoauth
 *
 */
class admin_pdoauth_groups extends dbpage {
	/**
	 *
	 * @var string Tabella
	 */
	protected $table = 'groups';
	/**
	 *
	 * @var string Database
	 */
	protected $database = 'pdoauth';

	/**
	 *
	 * @var string Chiave primaria
	 */
	protected $idkey = 'group';

	/**
	 *
	 * @var array Impostazioni colonne
	 */
	protected $columns = array(
			'group' =>   array(
					'name' => 'group',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 12,    'null' => 0,  ),
			'name' =>   array(
					'name' => 'name',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 15,    'null' => 0,  ),
	);

	/**
	 *
	 * @var string Campo descrizione
	*/
	protected $DescriptionKeys = 'group';
	/**
	 *
	 * @var string Titolo Pagina
	 */
	protected $title = 'PdoAuth Gruppi';
}