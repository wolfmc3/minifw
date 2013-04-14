<?php
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
		protected $attr;
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
		 */
		function __construct($tag="", $attr = array(), $inner = NULL) {
			$this->tag = $tag;
			if (is_null($attr)) $attr = array();
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
				if (is_string($el)&&!$this->html) {
					$this->inner[] = htmlentities($el);					
				} else {
					$this->inner[] = $el;
					return $el;
				}
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
			$this->add($html);
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
		 * @param unknown $key
		 * @param unknown $value
		 */
		function addAttr($key,$value) {
			if (array_key_exists($key,$this->attr)) {
				$this->attr[$key] .= " ".$value;
			} else {
				$this->attr[$key] = $value;
			}
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
				
			if ($this->tag) $html = "<".$this->tag;
			foreach ($this->attr as $key => $value) {
				$html .= " ".$key."='".htmlspecialchars($value)."' ";
			}
			if (!is_null($this->inner)) {
				if ($this->tag) $html .= ">\n";
				if (is_array($this->inner)) {
					foreach ($this->inner as $single) {
						$html .= $single;
					}
				} else {
					if (is_object($this->inner)) {
						$html .= $this->inner;
					} else {
						$html .= htmlspecialchars($this->inner);
					}
				}
				if ($this->tag) $html .= "</".$this->tag.">\n";
				
			} else {
				$html .= "/>";				
			}
							
			return $html;
		}
	}	

