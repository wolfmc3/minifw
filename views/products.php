<?php 
namespace views;

use framework\db\dbcontent;
class products extends dbcontent {
	protected $title = "Prodotti";
	protected $table = "products";
	protected $columnnames = array (
			'productCode' => 'Codice',
			'productName' => 'Nome',
			'?productLines/productLine' => 'Linea',
			'productScale' => 'Scala',
			'productVendor' => 'Colonna productVendor',
			'productDescription' => 'Descrizione',
			'quantityInStock' => 'Giacenza',
			'buyPrice' => 'Prezzo acquisto',
			'MSRP' => 'Listino',
			'/orderdetails/table/productCode' => 'Ordini',
	);
	
	
	protected $idkey = "productCode";
	
	/** OPTIONAL **/
	protected $columnsettings = array (
			'productCode' =>
			array (
					'datatype' => 'varchar',
					'len' => '15',
					'null' => false,
					'ontable' => true,
			),
			'productName' =>
			array (
					'datatype' => 'varchar',
					'len' => '70',
					'null' => false,
					'ontable' => true,
			),
			'productLine' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'productScale' =>
			array (
					'datatype' => 'varchar',
					'len' => '10',
					'null' => false,
					'ontable' => true,
			),
			'productVendor' =>
			array (
					'datatype' => 'varchar',
					'len' => '50',
					'null' => false,
					'ontable' => true,
			),
			'productDescription' =>
			array (
					'datatype' => 'text',
					'len' => false,
					'null' => false,
					'ontable' => false,
			),
			'quantityInStock' =>
			array (
					'datatype' => 'smallint',
					'len' => '6',
					'null' => false,
					'ontable' => true,
			),
			'buyPrice' =>
			array (
					'datatype' => 'double',
					'len' => false,
					'null' => false,
					'ontable' => true,
			),
			'MSRP' =>
			array (
			'datatype' => 'double',
			'len' => false,
			'null' => false,
			'ontable' => true,
			),
	);
	
}