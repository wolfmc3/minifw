<?php 
namespace framework\security;
	/**
	 * Security
	 *
	 * Inzializza il controller per la sicurezza 
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/security
	 *
	 * 
	 */
class security {
	/**
	 * @var string Modulo utilizzato
	 */
	private $module = "";
	/**
	 * Construttore
	 * Inizializza la classe sicurezza e carica il modulo specificato nella configurazione (security->module)
	 * Questa classe è inizializzata dalla classe application
	 * 
	 * @see \framework\app Applicazione
	 * 
	 */
	function __construct() {
		
	}
}

interface securitymoduleinterface {
	function getUser($username, $password);
	function setUser($userdata);
	 	
}
