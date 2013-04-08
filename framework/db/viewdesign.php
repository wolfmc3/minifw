<?php 
namespace framework\db;
use framework\html\element;
use framework\html\select;
use framework\app;
use framework\html\form\jsondata;
use framework\html\br;
use framework\html\form\submit;
use framework\html\anchor;
use framework\html\hr;
use framework\html\form\text;
class viewdesign extends dbcontent {
	function init() {
		parent::init();
		$this->addJavascript(app::root()."js/dbdesign.js");
		$this->addJavascript(app::root()."js/jquery-ui.js");
		$this->addCss(app::root()."css/black-tie/jquery-ui.css");
		$this->typeByAction("addform", self::TYPE_AJAX);
		$this->typeByAction("coldata", self::TYPE_JSON);
	}
	

	function action_export() {
		$cols = array_values($_POST['cols']);
		$settings = $_POST['settings'];
		$table = $this->table;
		$idkey = implode(",", $_POST["id"]);
		$shortFields = $_POST['name'];
		
		$columnnames = array();
		$columnsettings = array();
		
		foreach ($cols as $col) {
			$colsetting = $settings[$col];
			$columnnames[$col] = $colsetting['name'];
			if (isset($colsetting['datatype'])) {
				unset($colsetting['name']);
				$columnsettings[$col] = $colsetting;
			}
		}
		
		$columnsettings = var_export($columnsettings,TRUE);
		$columnnames = var_export($columnnames,TRUE);
				
		$string = <<<CODE
<?php
namespace views;
use framework\\db\\dbcontent;
class $table extends dbcontent {
//TABELLA
protected \$table = '$table';

//CHIAVE PRIMARIA
protected \$idkey = '$idkey';

//PERMESSI
protected \$addRecord = TRUE;
protected \$editRecord = TRUE;
protected \$deleteRecord = TRUE;
protected \$viewRecord = TRUE;

//LISTA COLONNE
protected \$columnnames = $columnnames;
	
//CAMPO DESCRIZIONE
protected \$shortFields = '$shortFields';
		
//IMPOSTAZIONI
protected \$columnsettings = $columnsettings;
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return '$table';
}
}
CODE;

		$show = new element();
		$show->add("Incollare questo codice nella pagina /views/$table.php");
		$show->add(new hr());
		$show->add(new element("textarea",array("id"=>"tocopy","readonly" => "1", "style"=>"width: 100%;", "rows"=>"40"),$string));
		return $show;
	}
	
	function action_addform() {
		$show = new element("form",array("id"=>"addform"));
		$show->add("Tipo: ");
		$show->append(new select("type", array(
				"/"=>"Visualizza tabella collegata",
				"+"=>"Visualizza tabella in linea",
				"?"=>"Modifica record collegato",
				"!"=>"Visualizza info",
		), "/",array("id"=>"addtype")));
		$views = app::getViews();
		$views = array_combine($views, $views);
		$show->add(array(new br(),"Vista: ", new select("view", $views, "") ));
		$viewcontainer = new element("span",array("id"=>"viewcont"),"");
		$show->append($viewcontainer)->add(array(new br(),"Azione: ", new select("action",array(
				"table"=>"Lista"
		),"",array("id"=>"selaction") )));
		$db = new database();
		$cols = $db->columnInfo($this->table);
		$colnames = array();
		foreach ($cols as $key => $value) {
			$key = $value['Field'];
			unset($value['Field']);
			if (strpos($value['Type'], "(") === FALSE ) $value['Type'] .= "(0)";
			list($datatype,$len) = explode("(", $value['Type']);
			$len = substr($len, 0,-1);
			unset($value['Type']);
			$value["datatype"] = $datatype;
			$value["len"] = $len;
			$colnames[$key] = $key." (".implode(" ", $value).")";
		}
		
		$show->add(array(new br(),"Campo id: ", new select("field",$colnames,"")));
		return $show;
	}
	
	function action_coldata() {
		$db = new database();
		return $db->columnInfo($this->table);
	}
	
	
	function action_table() {
		$ret = new element();
		$ret->add(new element("h3",null,"Attenzione!! Vista in modalità design: "));
		$ret->add(new anchor(app::root().$this->obj."/design/", "Genera design!"));
		$ret->add(new hr());
		$ret->add(parent::action_table());
		return $ret;
	}
	
	function action_design() {
		$db = new database();
		$cols = $db->columnInfo($this->table);
		$show = new element("form",array("METHOD"=>"POST","ACTION"=>app::root().$this->obj."/export/"));
		$colnames = array();
		$prikey = array();
		$colsettings = array();
		foreach ($cols as $key => $value) {
			$key = $value['Field'];
			unset($value['Field']);
			if ($value['Key'] == "PRI") $prikey[$key] = $key;
			if (strpos($value['Type'], "(") === FALSE ) $value['Type'] .= "(0)";
			list($datatype,$len) = explode("(", $value['Type']);
			$len = substr($len, 0,-1);
			unset($value['Type']);
			$value["datatype"] = $datatype;
			$value["len"] = $len;
			$colnames[$key] = $key." (".implode(" ", $value).")";
			$colsettings[$key] = $value;
		}
		$show->add(new jsondata("cols", $colsettings));
		$show->add(array(new br(),"Colonna ID:", new select("id[]", $prikey, "",array("id"=>"id", "multiple"=>1,"size"=>count($prikey)))));
		$show->add(array(new br(),"Colonna descrizione:", new select("name", $colnames, "",array())));
		
		$select = new select("cols[]", $colnames, "",array("id"=>"cols", "multiple"=>1,"size"=>count($colnames)+1));
		$show->add(array(new element("hr"),"Colonne disponibili:",new br(), $select));
		$addformlink = new anchor($this->url("addform"),"Aggiungi...",array("class"=>"button addspecial"));
		$show->add(array(new element("br"),"Campo speciale:",$addformlink));
		$show->add(new element("h3",NULL,"Impostazioni"));
		$table = new element("table",array("id"=>"settings")," ");
		$head = $table->append(new element("thead"))->append(new element("tr"));
		$heads = array("Nome", "Descrizione","In lista","Tipo","Lunghezza","Consenti null");
		foreach ($heads as $value) {
			$head->append(new element("th",NULL,$value));
		}
		$table->add(new element("tbody"));
		$show->add($table);
		$show->add(array(new br(), new submit("Genera!")));
		return $show;
	}
	
}
