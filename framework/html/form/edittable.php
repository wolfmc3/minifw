<?php
namespace framework\html\form;
use framework\html\element;
/**
 * edittable
 *
 * Genera form html completo di tabella in base alle impostazioni
 * NOTA: questo oggetto è utilizzato dall'oggetto dbcontents
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see \framework\db\dbcontent
 *
 */

class edittable extends element {
/**
 * 
 * @param mixed[] $row Array associativo contenente i dati
 * @param array[] $cols Colonne
 * @param string[] $options attributi oggetto table generato
 */
	function __construct($row, $cols, $options = array()) {
		parent::__construct("table",$options,array());
		$this->addAttr("style", "width: 100%;");
		foreach ($cols as $colname => $settings) {
			if (ctype_alpha(substr($colname, 0,1))) {
				$tr = new element("tr");
				$tr->add(new element("th",array(),$settings['name'])); //LABEL
				$input = new dyninput($colname, $row[$colname],$settings);
				$tr->add(new element("td",array(),$input)); //INPUT
				$this->add($tr);
			}
		}
		$tr = new element("tr");
		$td = new element("td",array("colspan"=>"2"),new submit("Salva"));
		$td->addAttr("style", "text-align: center;");
		$tr->add($td);
		$this->add($tr);


	}

}

