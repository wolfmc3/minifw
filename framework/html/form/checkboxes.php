<?php
/**
 *
 * checkboxes.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
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
 * $options = array("val1"=>"Elemento","val2"=>"Elemento 2");
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
	 * Costruttore
	 *
	 * @param string $name Corrisponde all'attributo name="$name" dei tag
	 * @param string $data Array contenente la coppia chiave=>Nome della select
	 * @param string $cur Array valori da riportare come selezionati []=nessuno
	 * @param string $options attributi del tag div che li contiene
	 */

		function __construct($name, $data, $cur, $options = array()) {
			app::Controller()->getPage()->addJquery();
			app::Controller()->getPage()->addJavascript("checkboxes.js");
			$control =  new element("div", array("id" => $name,"data-toggle"=>"buttons-radio","class"=>"checkboxes btn-group" ),"");
			foreach ($data as $key => $value) {
				$selected = (array_search($key, $cur) !== FALSE)?"active":"";
				$control->add(new element("button",array("class"=>"btn btn-primary".($selected?" active":""),"data-name"=>"#{$name}_{$key}","data-value"=>"$key","id"=>"btn_{$name}_{$key}"),$value));
				$this->append(new hidden($name."[]", ((array_search($key, $cur) !== FALSE)?$key:""),array("id"=>"{$name}_{$key}")));

				/*$this->add(new element("input",array($selected=>"1", "type"=>"checkbox","name"=>"{$name}[]","value"=>"$key","id"=>"{$name}_{$key}")));
				$this->add(new element("label",array("for"=>"{$name}_{$key}"),$value));*/
			}
			$this->append($control);

		}
	}

