<?php
/**
 *
 * div.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\responsive;
/**
 *
 * div
 *
 * Genera un tag html div con classe e id
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/responsive
 *
 */
class div extends rElement {
	/**
	 * Costruttore
	 *
	 * @param string $class
	 * @param string $id
	 * @param array $options
	 */
	function __construct($class,$id="",$options = array()) {
		parent::__construct("div",$class,$id,$options);
	}
}