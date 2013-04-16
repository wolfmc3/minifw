<?php
namespace framework\html\form; 
use framework\html\element;
use framework\app;
/**
 * checkboxes
 *
 * Genera una serie di opzioni checkbox<br>
 * 
 * <code>
 * use framework\html\select;
 * $options = ["val1"=>"Elemento","val2"=>"Elemento 2"];
 * $checkboxes = new checkboxes("type_select",$options,"val1");
 * echo $checkboxes;
 * </code>
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see element
 *
 */
class checkboxes extends element {
	/**
	 * 
	 * @param string $name Corrisponde all'attributo name="$name" dei tag 
	 * @param string $data Array contenente la coppia chiave=>Nome della select
	 * @param string $cur Array valori da riportare come selezionati []=nessuno
	 * @param string $options attributi del tag div che li contiene
	 */
	
		function __construct($name, $data, $cur, $options = array()) {
			parent::__construct("div", array("id" => $name,"class"=>"checkboxes" ),"");
			foreach ($data as $key => $value) {
				$selected = (array_search($key, $cur) !== FALSE)?"checked":"unchecked";
				$this->add(new element("input",[$selected=>"1", "type"=>"checkbox","name"=>"{$name}[]","value"=>"$key","id"=>"{$name}_{$key}"]));
				$this->add(new element("label",["for"=>"{$name}_{$key}"],$value));
			}
			
		}
	}	

