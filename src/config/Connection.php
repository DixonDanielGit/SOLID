<?php 

namespace App\config;

use PDO;
use PDOException;

class Connection
{
	private $pdo;
	
	function __construct(){

	    try {
	        $this->pdo = new PDO("mysql:host=localhost;dbname=bd", 'root', '');
	        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } catch (PDOException $e) {
         	die("Error en conexión a bd_sistema: " . $e->getMessage());
        }
	}

	public function getPDO(){
		return $this->pdo;
	}

}

 ?>