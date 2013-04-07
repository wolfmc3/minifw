<?php
namespace framework\html; 
	class element {
		protected $tag;
		protected $attr;
		protected $inner;
		
		function __construct($tag, $attr = array(), $inner = NULL) {
			$this->tag = $tag;
			if (is_null($attr)) $attr = array();
			$this->attr = $attr;
			if (!is_null($inner)) $this->addElement($inner);
		}
		
		function addElement($el) {
			if (is_array($el)) {
				foreach ($el as $sel) {
					$this->addElement($sel);
				}
			} else {
				if (is_string($el)) {
					$this->inner[] = htmlentities($el);					
				} else {
					$this->inner[] = $el;
				}
			}
		}
		
		function addAttr($key,$value) {
			$this->attr[$key] = $value;
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

