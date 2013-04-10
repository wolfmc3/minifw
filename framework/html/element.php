<?php
namespace framework\html; 
	class element {
		protected $tag;
		protected $attr;
		protected $inner;
		protected $html = FALSE;
		
		function __construct($tag="", $attr = array(), $inner = NULL) {
			$this->tag = $tag;
			if (is_null($attr)) $attr = array();
			$this->attr = $attr;
			if (!is_null($inner)) $this->add($inner);
		}
		
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
		
		function html($html) {
			$this->inner = array();
			$this->add($html);
		}
		
		function &append($element) {
			$this->inner[] = $element;
			return $element;
		}
		
		function addAttr($key,$value) {
			if (array_key_exists($key,$this->attr)) {
				$this->attr[$key] .= " ".$value;
			} else {
				$this->attr[$key] = $value;
			}
		}
		
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

