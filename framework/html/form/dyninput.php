<?php
namespace framework\html\form; 
	use framework\html\element;
use framework\html\anchor;
use framework\app;
use framework\html\icon;
/**
 * dyninput
 *
 * Genera un campo input in base alle impostazioni
 * NOTA: questo oggetto è utilizzato dall'oggetto dbcontents
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see \framework\db\dbcontent
 *
 */

class dyninput extends element {
		/**
		 * Costruttore 
		 * @param string $key Nome del tag nel form (attributo name)
		 * @param string $text Valore attuale (attributo value)
		 * @param string[] $setting Impostazioni
		 */
		function __construct($key, $text, $setting = array()) {
			parent::__construct("span");
			if (count($setting) && array_key_exists("inputtype", $setting)) {
				$input = NULL;
				$dt = $setting['inputtype'];
				$len = $setting['len'];
				if ($dt == "readonly") {
					$this->add($text);
				} elseif ($dt == "currency" || $dt == "numeric") {
					$input = $this->append(new element("input",array("type" => "text","class"=>"$dt","value"=> $text,"name" => $key)));
				} elseif ($dt == "date" || $dt == "datetime" || $dt == "time") {
					$objdate = strtotime($text);
					$date = date(app::conf()->format->date, $objdate);
					$time = date(app::conf()->format->time, $objdate);
					if (strpos($dt, "date") !== FALSE) {
						$input = $this->append(new element("input",array("type" => "text","value"=>$date, "class" => "date","data-ref"=>$key)));
					}					
					if (strpos($dt, "time") !== FALSE) {
						$input = $this->append(new element("input",array("type" => "time","value"=>$time, "class" => "time","data-ref"=>$key)));
					}					
					$input = $this->append(new element("input",array("type" => "hidden","value"=> $text,"id" => $key,"name" => $key)));
				} elseif ($dt == "text") {
					$input = $this->append(new element("input",array("type" => "text","value"=> $text,"name" => $key)));
					if (is_numeric($len) && $len > 0) {
						$input->addAttr("size", $len);
						$input->addAttr("maxlength", $len);
					}
				} elseif ($dt == "longtext") {
					$input = $this->append(new element("textarea",array("name" => $key),$text.""));
					$input->addAttr("style","width: 100%; height: 150px;");
				} elseif ($dt == "bool") {
					$input = $this->append(new element("div",array("id" => $key,"class"=>"bool")));
					$input->add(new element("label",["for"=>"{$key}1"],"Si"));
					$input->add(new element("input",["type"=>"radio","name"=>"$key","value"=>"1","id"=>"{$key}1"]));
					$input->add(new element("label",["for"=>"{$key}2"],"No"));
					$input->add(new element("input",["type"=>"radio","name"=>"$key","value"=>"0","id"=>"{$key}2"]));
					$input = NULL;
				} else {
					$input = $this->append(new element("input",array("type" => "text","value"=> $text,"name" => $key)));
				}
				if ($input) {
					$input->addAttr("class", "ui-widget ui-widget-content ui-corner-all");
					if (array_key_exists('relation', $setting) && $setting['relation']) {
						$obj = $setting['relation'];
						$input->addAttr("readonly","1");
						$input->addAttr("style","vertical-align: middle");
						$input->addAttr("class","fromlist");
						$label = " (".app::Controller()->$obj->label($text).")";
						$this->append(
							new anchor(app::root()."$obj/table",array(new icon("FolderOpen"),new element("span",["id"=>"label_$key"],$label ) ),array("class"=>"selectitem rotate"))
						);
					}
					if ($setting['regexpr']) {
						$input->addAttr("data-validate", $setting['regexpr']);
					} elseif (array_key_exists('required', $setting) && $setting['required']) {
						$input->addAttr("data-validate", '^\s*\S.*$');
					}
				}
			} else {
				parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
			}
		}
		
	}	

