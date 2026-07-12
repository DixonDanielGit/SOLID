<?php 

namespace App\models;

use PDO;
use PDOException;
use App\models\Connection;

class ModelBase extends Connection
{
	protected $table;
	protected $colums =[];
	protected $condicionAditional ='';

	private $ordenColumn ='id';
	private $search ='';
	private $start =0;
	private $limit=10;
	private $ordenDir ='DESC';

	function __construct($table, $colums, $condicionAditional)
	{
		parent::__construct();
		$this->table = $table;
		$this->colums = $colums;
		$this->condicionAditional = $condicionAditional;
	}


	private function return_data($data)
	{
		$paramts = [];
		foreach ($data as $key => $value) {
			$paramts[":".$key] = $value;
		}
		$columsSQL = implode(', ', array_keys($data));
		$placeholder = implode(', ', array_keys($paramts));
		return[$columsSQL, $placeholder, $paramts];
	}

	public function pagination(){

		$paramts = [];
		$columsSQL = implode(', ', array_keys($this->colums));
		$sql="SELECT $columsSQL FROM $this->table ";
		$sql .= ($this->search !=''|| $this->condicionAditional !='') ? " WHERE " : ' ';
		$conector = '';

		if ($this->condicionAditional != '') {
			$sql .= $this->condicionAditional;
			$conector = " AND ";
		}

		if ($this->search !='') {
			$sql .=$conector;
			foreach ($this->colums as $key => $value) {
				$sql .= "$key LIKE :buscar OR ";
			}
			//eliminar el ultimo OR
			$ultimo_or = strrpos($sql,'OR');
			if($ultimo_or){
				$sql = substr($sql, 0, $ultimo_or);
			}
			$paramts['buscar'] = "%$this->search%";
		}
		$sql .="ORDER BY {$this->ordenColumn} {$this->ordenDir} LIMIT :inicio, :limite";
		$paramts['inicio'] = (int)$this->start;
		$paramts['limite'] = (int)$this->limit;
		$query = $this->getPDO()->prepare($sql);
		foreach($paramts as $key => $value){
            $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
			$query->bindValue(":$key",$value, $type);
		}
		return ($query->execute()) ? $query->fetchAll():[];
	}

	public function add($table,$colums){
		$columsSQL = $this->return_data($colums)[0];
		$placeholder = $this->return_data($colums)[1];
		$paramts = $this->return_data($colums)[2];

		$sql = "INSERT INTO $table  ($columsSQL) VALUES ($placeholder)";
		$query = $this->getPDO()->prepare($sql);
		foreach($paramts as $key => $value){
			$query->bindValue($key,$value);
		}
		$query->execute();
		return $this->getPDO()->lastInsertId();
	}

	public function update($table,$colums,$data_id){
		$columsSQL = $this->return_data($colums)[0];
		$placeholder = $this->return_data($colums)[1];
		$paramts = $this->return_data($colums)[2];


		$sql = "UPDATE $table SET ";
		foreach ($colums as $key => $value) {
			$sql .= "$key =:$key, ";
		}
		$ultima_coma = strrpos($sql,',');
		if($ultima_coma){
			$sql = substr($sql, 0, $ultima_coma);
		}
		$id = implode('',array_keys($data_id));
		$id_value = implode('',array_values($data_id));
		$sql .= " WHERE  $id =:$id";
		$paramts[":$id"] = $id_value;
		
		$query = $this->getPDO()->prepare($sql);
		foreach($paramts as $key => $value){
			$query->bindValue($key,$value);
		}
		$query->execute();
		return $this->getPDO()->lastInsertId();
	}


	public function delete($table, $data_id){
		$id = implode('',array_keys($data_id));
		$id_value = implode('',array_values($data_id));
		$sql = "DELETE FROM $table WHERE $id =:$id";
		$query = $this->getPDO()->prepare($sql);
		foreach ($data_id as $key => $value) {
			$query->bindValue($key,$value);
		}
		$query->execute();
	}


	public function get_orden_column()
	{
		return $this->ordenColumn;
	}

	public function get_search()
	{
		return $this->search;
	}

	public function get_start()
	{
		return $this->start;
	}

	public function get_limit()
	{
		return $this->limit;
	}

	public function get_orden_dir()
	{
		return $this->ordenDir;
	}

	public function set_orden_column($ordenColumn)
	{
		$this->ordenColumn = $ordenColumn;
	}


	public function set_search($search)
	{
		$this->search = $search;
	}

	public function set_start($start)
	{
		$this->start = $start;
	}

	public function set_limit($limit)
	{
		$this->limit = $limit;
	}

	public function set_orden_dir($ordenDir)
	{
		$this->ordenDir = $ordenDir;
	}

}

 ?>