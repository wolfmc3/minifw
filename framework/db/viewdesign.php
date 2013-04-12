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
use framework\html\table;
use framework\html\template;
use framework\html\dotlist;
class viewdesign extends dbcontent {
	protected $columns = array("1");
	
	function init() {
		parent::init();
		$this->addJavascript(app::root()."js/dbdesign.js");
		$this->addJavascript(app::root()."js/jquery-ui.js");
		$this->addCss(app::root()."css/black-tie/jquery-ui.css");
		$this->typeByAction("addform", self::TYPE_AJAX);
		$this->typeByAction("coldata", self::TYPE_JSON);
		$this->typeByAction("viewinfo", self::TYPE_JSON);
		$this->typeByAction("download", self::TYPE_CUSTOM);
	}
	
	function action_download() {
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename= " . $this->obj .".php");
		header("Content-Transfer-Encoding: binary");
		echo $_POST["source"];
	}

	function action_export() {
		//print_r($_POST);
		$table = $this->table;
		$idkey = implode(",", $_POST["id"]);
		$DescriptionKeys = implode(",", $_POST["name"]);
		
		$settings = [];
		foreach ($_POST['settings'] as $column => $setting) {
			$settings[$column] = array();
			foreach ($setting as $key => $var) {
				$settings[$column][$key] = (is_numeric($var)?intval($var):$var);
			}
		}
		 	
		$columns = str_replace("array (", "array(\n", str_replace("),", "),\n", str_replace("\n", "", var_export($settings,TRUE)))) ;
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

//LISTA COLONNE e IMPOSTAZIONI
protected \$columns = $columns;
	
//CAMPO DESCRIZIONE
protected \$DescriptionKeys = '$DescriptionKeys';
				 	
//TITOLO VISUALIZZATO NEL BROWSER
function title() {
	return '$table';
}
}
CODE;

		$show = new element();
		$form = $show->append(new element("form",array("method"=>"POST", "action"=>$this->url("download"))));
		$form->add("Incolla questo codice nella pagina /views/$table.php oppure ");
		$form->add(new submit("Scarica $table.php"));
		$form->add(" e salvalo nella cartella /views/");
		$form->add(new hr());
		$form->add(new element("textarea",array("name"=>"source", "id"=>"tocopy","readonly" => "1", "style"=>"width: 100%;", "rows"=>"40"),$string));
		return $show;
	}
	
	function action_addform() {
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
		$views = app::getViews();
		$views = array_combine($views, $views);
		//CREATE FORM
		$show = new element("form",array("id"=>"addform"));
		$typeselect = new select("type", array(
				"/"=>"Visualizza tabella collegata",
				"+"=>"Visualizza tabella in linea",
				"?"=>"Modifica record collegato",
				"!"=>"Visualizza info",
				"="=>"Campo calcolato",
		), "/",array("id"=>"addtype"));
		$viewcontainer = new element("div",array(),"");
		$show->append($viewcontainer)->add(array("Tipo: ",$typeselect));
		$viewcontainer = new element("div",array("class"=>"showtable viewrecord"),"");
		$show->append($viewcontainer)->add(array("Vista: ", new select("view", $views, "",array("class"=>"showtable viewrecord", "id"=>"selectviews")) ));
		$viewcontainer = new element("div",array("class"=>"showtable viewrecord"),"");
		$show->append($viewcontainer)->add(array("Azione: ", new select("action",array("table"=>"Lista"),"",array("id"=>"selaction") )));
		$viewcontainer = new element("div",array("class"=>"showtable viewrecord"),"");
		$show->append($viewcontainer)->add(array("Campo id: ", new select("field",$colnames,"")));
		$viewcontainer = new element("div",array("class"=>"showtable"),"");
		$show->append($viewcontainer)->add(array("Colonna target: ", new select("target",array(),"",array("id"=>"target"))));
		$viewcontainer = new element("div",array("class"=>"calcfield"),"");
		$fieldlinks = array();
		$show->append($viewcontainer)->add(array("Espressione: ", new element("textarea",array("name"=>"expr","id"=>"expr","cols"=>"45"),"")));
		foreach ($colnames as $key => $value) {
			$fieldlinks[] = new anchor("$key",$key,array("class"=>"fieldlist_add"));
		}
		
		$viewcontainer = new element("div",array("class"=>"calcfield","style"=>"clear: both;"),"");
		$show->append($viewcontainer)->add($fieldlinks);
		
		return $show;
	}
	
	function action_viewinfo() {
		$views = app::getViews();
		$res = [];
		foreach ($views as $value) {
			$obj = app::Controller()->$value;
			if (method_exists($obj, "fields")) {
				$res[$value] = ["keys" => $obj->key(),"fields"=>$obj->fields()]; 
			}
		}
		return $res;
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
		$show->add(new jsondata("colsrawdata",$colsettings));
		
		//$colnames = array_merge($colnames,$this->columns);
		$select = new select("colsource", $colnames, "",array("id"=>"cols", "multiple"=>1,"size"=>count($colnames)+1));
		$template = new template("viewdesign_design", array(
				"addformurl"=>$this->url("addform"),
				"fields"=>$select,
				"colslength"=>count($colnames)+1,
				"idselect" => new select("id[]", $prikey, "",array("id"=>"id","multiple"=>1,"size"=>count($prikey))),
				"nameselect"=> new select("name[]", $colnames, "",array("id"=>"names", "multiple"=>1,"size"=>count($colnames)+1))
		));
		$views = app::getViews(); 
		$views = array_combine($views, $views);
		$views = array_merge([""=>"--"], $views );
		
		$show->add(new jsondata("listviews",$views));
		$show->add($template);
		$show->add(array(new br(), new submit("Genera!")));
		return $show;
	}
	
}
