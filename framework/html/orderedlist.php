<?php 
namespace framework\html; 
/**
 * orderedlist
 *
 * Genera elenco numerato completo<br>
 * <code>
 * <ol>
 * <li>Elemento</li>
 * <li>Elemento 2</li>
 * </ol>
 * </code>
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see element
 *
 */

class orderedlist extends element {
	/**
	 * Costruttore
	 * 
	 * @param string $ulclass classe css per l'elemento UL
	 * @param string[] $options Attributi opzionali del tag
	 */
	function __construct($ulclass = NULL,$options = []) {
		parent::__construct("ol",$options);
		if ($ulclass) $this->addAttr("class", $ulclass);
	}
	
	/**
	 * addItem()
	 * 
	 * Aggiunge gli elementi in un tag LI
	 * 
	 * @param string|\framework\html\element $el elemento da inserire nel tag LI
	 * @param string[] $attr attributi del tag LI
	 */
	function addItem($el, $attr = array()) {
		$ul = new element("li",$attr);
		$ul->add($el);
		parent::add($ul);
	}
	
	/**
	 * add
	 * 
	 * aggiunge un tag li per ogni elemento specificato
	 * 
	 * @param \framework\html\element $el Elemento da inserire
	 * @param string[] $attr Attributi del tag LI da generare
	 * 
	 * @see \framework\html\element::add()
	 */
	function add($el, $attr = array()) {
		if (is_array($el)) {
			foreach ($el as $key => $value) {
				$this->addItem($value);
			}
		} else {
			$ul = new element("li",$attr);
			$ul->add($el);
			parent::add($ul);
		}
	}
} 