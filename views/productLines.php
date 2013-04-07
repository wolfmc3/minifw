<?php 
namespace views;
use framework\db\dbcontent;
class productlines extends dbcontent {
	protected $title = "Linee prodotti";
	protected $table = "productlines";
	protected $columnnames = array (
			'productLine' => 'Linea',
			'textDescription' => 'Descrizione',
			'htmlDescription' => 'HTML',
			'image' => 'IMMAGINE',
	);
	
	
	protected $idkey = "productLine";
	protected $shortFields = "productLine";
		
	/** OPTIONAL **/
	protected $columnsettings = array (
			'productLine' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'textDescription' =>
			array (
					'datatype' => 'varchar',
					'len' => '4000',
					'null' => true,
					'ontable' => true,
			),
			'htmlDescription' =>
			array (
					'datatype' => 'mediumtext',
					'len' => '0',
					'null' => true,
					'ontable' => false,
			),
			'image' =>
			array (
					'datatype' => 'mediumblob',
					'len' => '0',
					'null' => true,
					'ontable' => false,
			),
	);
	
}