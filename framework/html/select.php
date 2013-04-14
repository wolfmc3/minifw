<?php
namespace framework\html; 
/**
 * select
 *
 * Genera una lista a discesa completa<br>
 * <code>
 * <select>
 * <option>Elemento</option>
 * <option>Elemento 2</option>
 * </select>
 * </code>
 * sarà generato dal codice:<br>
 * <code>
 * use framework\html\select;
 * $options = ["val1"=>"Elemento","val2"=>"Elemento 2"];
 * $select = new select("form_select",$options,"val1");
 * echo $select;
 * </code>
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see element
 *
 */
class select extends element {
	/**
	 * 
	 * @param string $name Corrisponde all'attributo name="$name" del tag select
	 * @param string $data Array contenente la coppia chiave=>valore della select
	 * @param string $cur Valore da riportare come selezionato ""=nessuno
	 * @param string $options attributi del tag select
	 */
		function __construct($name, $data, $cur, $options = array()) {
			parent::__construct("select", array_merge(array("name" => $name),$options));
			foreach ($data as $key => $value) {
				$options = array("value" => $key);
				if ($cur == $key) $options["selected"] = "1";
				$el = new element("option",$options);
				$el->add($value);
				$this->add($el);
			}
			
		}
	}	

