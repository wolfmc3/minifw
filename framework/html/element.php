<?php
/**
 *
 * element.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html;
/**
 * element
 *
 * Genera un elemento html generico
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 *
 */
class element {
	/**
	 * @var string Nome del tag html
	 */
	protected $tag;
	/**
	 * @var string[] attributi tag
	 */
	protected $attr = array();
	/**
	 * @var string[]|\framework\html\element[] oggetti contenuti nel tag
	*/
	protected $inner;
	/**
	 * @var boolean indica se il contenuto deve essere trattato come html o come testo
	 */
	protected $html = FALSE;
	/**
	 * Costruttore
	 *
	 * @param string $tag Nome tag html (se vuoto l'oggeto non avrà nessun tag)
	 * @param string[] $attr Attributi del tag (class, name, id)
	 * @param string|\framework\html\element $inner Contenuto del tag
	 * @param boolean $html Indica se l'elemento è codice html già formato
	 */
	function __construct($tag="", $attr = array(), $inner = NULL,$html = FALSE) {
		$this->html = $html;
		$this->tag = $tag;
		if (!is_array($attr)) $attr = array();
		$this->attr = $attr;
		if (!is_null($inner)) $this->add($inner);
	}

	/**
	 * add
	 *
	 * Aggiunge uno o più oggetti element al tag corrente
	 *
	 * @param string|\framework\html\element|string[]|\framework\html\element[] $el elemento/i da inserire
	 * @return void|\framework\html\element ritorna l'elemento se $el non è un array
	 */
	function add($el) {
		if (is_array($el)) {
			foreach ($el as $sel) {
				$this->add($sel);
			}
		} else {
			if (is_a($el, "framework\\html\\element") || $this->html) {
				$this->inner[] = $el;
				return $el;
			} else {
				$this->inner[] = htmlentities($el ,ENT_COMPAT, "UTF-8");
			}
		}
	}
	/**
	 * addBR()
	 * Aggiunge come oggetto figlio n tag BR
	 *
	 * @param number $count numero di tag BR da inserire
	 */
	function addBR($count = 1) {
		for ($i = 0; $i < $count; $i++) {
			$this->add(new br());
		}
	}
	/**
	 * html()
	 *
	 * Azzera il contenuto e aggiunge $html
	 * @param string|\framework\html\element $html
	 */
	function html($html) {
		$this->inner = array();
		if ($html) $this->add($html);
	}
	/**
	 * append
	 *
	 * Aggiunge un elemento al contenuto del tag
	 *
	 * @param string|\framework\html\element $element
	 * @return string|\framework\html\element Elemento appena inserito
	 */
	function &append($element) {
		$this->inner[] = $element;
		return $element;
	}
	/**
	 * addAttr()
	 *
	 * aggiunge un attributo al tag, se l'attributo già esiste aggiunge $value all'attributo esistente
	 *
	 * @param string $key
	 * @param string $value
	 * @return \framework\html\element THIS element
	 */
	function addAttr($key,$value) {
		if (array_key_exists($key,$this->attr)) {
			$this->attr[$key] .= " ".$value;
		} else {
			$this->attr[$key] = $value;
		}
		return $this;
	}
	/**
	 * getContents()
	 * Ritorna il contenuto grezzo del tag
	 * @return string|multitype:\framework\html\element
	 */
	function getContents() {
		return $this->inner;
	}

	/**
	 * findTag()
	 * Ritorna un riferimento al primo elemento figlio che corrisponde al tag specificato
	 * @param string $tag
	 * @return \framework\html\element|NULL Ritorna l'elemento o NULL se non trovato
	 */
	function &findTag($tag) {
		if ($this->tag == $tag) {
			return $this;
		}
		$inner = NULL;
		if (is_array($this->inner)) {
			foreach ($this->inner as $element) {
				if (is_a($element, "framework\\html\\element") && ($inner = &$element->findTag($tag)) !== NULL){
					break;
				}
			}
		}
		return $inner;

	}
	/**
	 * findId()
	 * Ritorna un riferimento al primo elemento figlio che contiene l'attributo id specificato
	 * @param string $id
	 * @return \framework\html\element|NULL Ritorna l'elemento o NULL se non trovato
	 */

	function &findId($id) {
		if (array_key_exists("id", $this->attr ) && $this->attr["id"] == $id) {
			return $this;
		}
		$inner = NULL;
		if (is_array($this->inner)) {
			foreach ($this->inner as $element) {
				if (is_a($element, "framework\\html\\element") && ($inner = &$element->findId($id)) !== NULL){
					break;
				}
			}
		}
		return $inner;

	}
	/**
	 * __toString()
	 *
	 * Converte l'oggetto nel codice HTML risultante
	 *
	 * @return string HTML completo dell'oggetto
	 */
	function __toString() {
		$html = "";
		$fo = (is_array($this->inner) && count($this->inner) > 1)?PHP_EOL:"";

		if ($this->tag) $html .= "$fo<".$this->tag;
		foreach ($this->attr as $key => $value) {
			$html .= " ".$key."='".htmlspecialchars($value,ENT_COMPAT, "UTF-8")."' ";
		}
		if (!is_null($this->inner)) {
			if ($this->tag) $html .= ">$fo";
			if (is_array($this->inner)) {
				foreach ($this->inner as $single) {
					$html .= $single.$fo;
				}
			} else {
				if (is_a($this->inner, "framework\\html\\element") || $this->html) {
					$html .= $this->inner;
				} else {
					$html .= htmlspecialchars($this->inner,ENT_COMPAT, "UTF-8");
				}
			}
			if ($this->tag) {
				$html .= "</".$this->tag.">";
				if (isset($this->attr['id']) && is_array($this->inner) && count($this->inner) > 1) $html .= "<!-- ".$this->attr['id']." -->".PHP_EOL;
			}

		} else {
			if ($html != '') {
				$html .= "/>$fo";
			}
		}

		return $html;
	}
	/**
	 * element::<TAG>()
	 *
	 * Ritorna un nuovo elemento corrispondente al TAG specificato<br>
	 * Esempio:<br>
	 * <code>
	 * $grassetto = <b>element::strong()</b>->add("Ciao");
	 *
	 * oppure
	 *
	 * $grassetto = new element("strong");
	 * $grassetto->add("Ciao");
	 * </code>
	 *
	 * @param string $el
	 * @param mixed $args
	 * @return \framework\html\element
	 */
	public static function __callstatic($el,$args) {
		return new element($el,$args);
	}
}

