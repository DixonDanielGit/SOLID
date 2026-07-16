<?php 

namespace App\models;

use PDO;
use PDOException;
use App\models\Connection;

class ModelBase extends Connection
{
	private $tables;
	private $colums =[];
	private $condicionAditional ='';
	private $alias ='';
	private $union ='';
	private $ordenColumn ='id';
	private $search ='';
	private $start =0;
	private $limit=10;
	private $ordenDir ='DESC';

	function __construct()
	{
		parent::__construct();
		$this->tables = [];
		$this->colums = ["*"];
		$this->alias = [];
		$this->union = [];
		$this->condicionAditional = '';
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

	public function read($all = true){
		$paramts = [];
		$columsSQL = implode(',', $this->colums);
		$sql="SELECT $columsSQL FROM ";

		//si el mas de una tabla se le agrega el inner join
		if (count($this->tables) > 1 ) {
			foreach ($this->tables as $key => $value) {
				if (count($this->tables) != count($this->alias)) {
					echo "El numero de tablas no coincide con el numero de alias";
					return;
				}
				if ($key ==0) {
					$sql .= " {$value} {$this->alias[$key]}";
				} else {
					$sql .= " INNER JOIN {$value} {$this->alias[$key]} ON {$this->union[$key-1]}";
				}	
			}
		}else{
			$sql .=" {$this->tables[0]} ";
		}

		$sql .= ($this->search !=''|| $this->condicionAditional !='') ? " WHERE " : ' ';
		$conector = '';

		if ($this->condicionAditional != '') {
			$sql .= $this->condicionAditional;
			$conector = " AND ";
		}

		if ($this->search !='') {
			$sql .=$conector;
			foreach ($this->colums as $colum) {
				if(strrpos($colum,'AS')){
					$alias = explode("AS", $colum);
					$colum = $alias[0];
				}
				$sql .= "$colum LIKE :buscar OR ";
			}
			//eliminar el ultimo OR
			$ultimo_or = strrpos($sql,'OR');
			if($ultimo_or){
				$sql = substr($sql, 0, $ultimo_or);
			}
			$paramts['buscar'] = "%$this->search%";
		}
		if ($this->limit > 0) {
			$sql .=" ORDER BY {$this->ordenColumn} {$this->ordenDir} LIMIT :inicio, :limite";
			$paramts['inicio'] = (int)$this->start;
			$paramts['limite'] = (int)$this->limit;
		}
		$query = $this->getPDO()->prepare($sql);

		foreach($paramts as $key => $value){
            $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
			$query->bindValue(":$key",$value, $type);
		}

		// return $sql;
		if ($query->execute()) {
			return (!empty($all)) ? $query->fetchAll() : $query->fetch();
		}

	}

	public function create(){
		try{
			$columsSQL = $this->return_data($this->colums)[0];
			$placeholder = $this->return_data($this->colums)[1];
			$paramts = $this->return_data($this->colums)[2];

			$sql = "INSERT INTO $this->tables  ($columsSQL) VALUES ($placeholder)";
			$query = $this->getPDO()->prepare($sql);
			foreach($paramts as $key => $value){
				$query->bindValue($key,$value);
			}
			// return $sql;
			$query->execute();
			return $this->getPDO()->lastInsertId();
		} catch (\Exception $e) {
            return $e;
        }
	}

	public function update($data_id){
		try{
			$columsSQL = $this->return_data($this->colums)[0];
			$placeholder = $this->return_data($this->colums)[1];
			$paramts = $this->return_data($this->colums)[2];

			$sql = "UPDATE $this->tables SET ";
			foreach ($this->colums as $key => $value) {
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
			return 1;

		} catch (\Exception $e) {
            return $e;
        }
	}


	public function delete($data_id){
		try{
			$id = implode('',array_keys($data_id));
			$id_value = implode('',array_values($data_id));
			$sql = "DELETE FROM $this->tables WHERE $id =:$id";
			$query = $this->getPDO()->prepare($sql);
			foreach ($data_id as $key => $value) {
				$query->bindValue($key,$value);
			}
			$query->execute();
			return 1;
		} catch (\Exception $e) {
            return $e;
        }
	}

	public function get_tables()
	{
		return $this->tables;
	}

	public function get_colums()
	{
		return $this->colums;
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

	public function get_condicion_aditional()
	{
		return $this->condicionAditional;
	}


	public function set_tables($tables)
	{
		$this->tables = $tables;
	}

	public function set_colums($colums)
	{
		$this->colums = $colums;
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

	public function set_condicion_aditional($condicionAditional)
	{
		$this->condicionAditional =$condicionAditional;
	}

}

 ?>