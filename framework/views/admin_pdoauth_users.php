<?php
/**
 *
 * admin_pdoauth_users.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;
use framework\db\dbpage;
/**
 *
 * admin_pdoauth_users
 *
 * Pagina per la gestione degli utenti per il modulo sicurezza pdoauth
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 * @see \framework\security\modules\pdoauth
 *
 */

class admin_pdoauth_users extends dbpage {
	/**
	 *
	 * @var string Tabella
	 */
	protected $table = 'users';
	/**
	 *
	 * @var string Database
	 */
	protected $database = "pdoauth";

	/**
	 *
	 * @var string Chiave primaria
	 */
	protected $idkey = 'username';

	/**
	 *
	 * @var string[] Impostazioni colonne
	 */
	protected $columns = array(
			'name' =>   array(
					'name' => 'name',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'text',    'len' => 0,    'null' => 0,  ),
			'username' =>   array(
					'name' => 'username',    'ontable' => 1,    'inputtype' => 'readonly',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 20,    'null' => 0,  ),
			'password' =>   array(
					'name' => 'password',    'inputtype' => 'password',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 40,    'null' => 0,  ),
			'group' =>   array(
					'name' => 'group',    'ontable' => 1,    'inputtype' => 'text',    'relation' => '',    'required' => 1,    'regexpr' => '',    'datatype' => 'varchar',    'len' => 12,    'null' => 0,  ),
	);

	/**
	 *
	 * @var string Campo descrizione
	*/
	protected $DescriptionKeys = 'name';
	/**
	 *
	 * @var string Title
	 */
	protected $title = 'PdoAuth Utenti';
	/**
	 * Azione di pre-salvataggio
	 *
	 * Applica la codifica MD5 alla password
	 * @see \framework\db\dbpage::action_save()
	 */
	function action_save() {
		$_POST['password'] = md5($_POST['password']);
		return parent::action_save();
	}
}