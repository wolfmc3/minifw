<?php
/**
 *
 * textblock.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\responsive;
use framework\html\element;
/**
 *
 * Elemento textblock
 *
 * Genera un elemento con titolo e righe<br>
 * Legato al layout bootstrap responsivo<br>
 * <pre>
 * <div>
 * <h3>$title</h3>
 * <p>appended line 1</p>
 * <p>appended line 2</p>
 * <p>appended line 3</p>
 * </div>
 * </pre>
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/responsive
 *
 */
class textblock extends div {
	/**
	 * Costruttore
	 *
	 * @param string $title Titolo
	 * @param number $span Colonne occupate
	 * @param number $offset Colonne di spazio prima
	 * @param string $class Class da aggiungere
	 * @param string $id ID del blocco
	 * @param string[] $attr attributi del contenitore div
	 */
	function __construct($title, $span=0, $offset=0 , $class="", $id="", $attr = array()) {
		parent::__construct( $class, $id, $attr);
		if ($span) $this->addAttr("class", "span$span");
		if ($offset) $this->addAttr("class", "offset$offset");
		$titleel = new element("h3");
		$titleel->add($title);
		parent::append($titleel);
	}
	/**
	 * append()
	 *
	 * aggiunge un paragrafo <P>$el</P> nel contenitore DIV
	 *
	 * @param mixed Contenuto del paragrafo
	 * @see \framework\html\element::append()
	 */
	function &append($el) {
		$cont = element::p();
		$cont->add($el);
		parent::add($cont);
		return $this;
	}
}