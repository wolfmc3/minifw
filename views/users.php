<?php 
use framework\db\dbcontent;
class content extends dbcontent {
	protected $table = "users";
	protected $columnnames = array(
			"name" => "Nome",
			"username" => "Nome utente",
			"access" => "Autorizzazioni",
			"enabled" => "Abilitato"
	);
	
	function title() {
		return "Utenti";
	}
	
}