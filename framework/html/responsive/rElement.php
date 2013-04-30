<?php
/**
 *
 * rElement.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\responsive;
use framework\html\element;
/**
 *
 * rElement
 *
 * Genera un elemento che prevede gli attributi class e id
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/responsive
 *
 */
class rElement extends element {
	/**
	 * Costruttore
	 *
	 * @param string $tag
	 * @param string $class
	 * @param string $id
	 * @param string[] $options
	 */
	function __construct($tag,$class="",$id="",$options = array()) {
		parent::__construct($tag,$options);
		if ($class) $this->addAttr("class", $class);
		if ($id) $this->addAttr("id", $id);
	}
}