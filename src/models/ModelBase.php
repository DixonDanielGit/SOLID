<?php 

namespace App\models;

use PDO;
use PDOException;
use App\models\Connection;

class ModelBase extends Connection
{

	function __construct()
	{
		parent::__construct();
	}


	private function return_plach_and_colums($data)
	{
		$paramts = [];
		foreach ($data as $key => $value) {
			$paramts[":".$key] = $value;
		}
		$columsSQL = implode(', ', array_keys($data));
		$placeholder = implode(', ', array_keys($paramts));
		return[$columsSQL, $placeholder, $paramts];
	}

	protected function pagination(string $table ='', array $colums =[],string $ordenColumn ='id',string $condicionAditional='', string $buscar='',int $inicio =0, int $limite=10, string $ordenDir = 'DESC'){

		$paramts = [];
		$columsSQL = implode(', ', array_keys($colums));
		$sql="SELECT $columsSQL FROM $table ";
		$sql .= ($buscar!=''|| $condicionAditional !='') ? " WHERE " : ' ';
		$conector = '';

		if ($condicionAditional != '') {
			$sql .= $condicionAditional;
			$conector = " AND ";
		}

		if ($buscar!='') {
			$sql .=$conector;
			foreach ($colums as $key => $value) {
				$sql .= "$key LIKE :buscar OR ";
			}
			//eliminar el ultimo OR
			$ultimo_or = strrpos($sql,'OR');
			if($ultimo_or){
				$sql = substr($sql, 0, $ultimo_or);
			}
			$paramts['buscar'] = "%$buscar%";
		}
		$sql .="ORDER BY {$ordenColumn} {$ordenDir} LIMIT :inicio, :limite";
		$paramts['inicio'] = (int)$inicio;
		$paramts['limite'] = (int)$limite;
		$query = $this->getPDO()->prepare($sql);
		foreach($paramts as $key => $value){
            $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
			$query->bindValue(":$key",$value, $type);
		}
		return ($query->execute()) ? $query->fetchAll():[];
	}

	protected function pagination_join(array $tables =[], array $colums =[],string $ordenColumn ='id',string $condicionAditional='', string $buscar='',int $inicio =0, int $limite=10, string $ordenDir = 'DESC'){

		$columsSQL = [];
		foreach ($tables as $table) {
			$alias = $table['data']['alias'];

			foreach ($table['data']['colums'] as $key =>$value) {
				$columsSQL []= $alias.".".$key;
			}
		}
		$columsSQL = implode(', ',$columsSQL);
		$sql = "SELECT $columsSQL FROM";
		
		foreach ($tables as $key => $value) {
			$sql .= ($key != 0) ? " INNER JOIN " : " ";
			$sql .= $value['table'].' '.$value['data']['alias'];
			$sql .= ($key != 0) ? ' ON '.$value['data']['conector']: ' ';
		}

		$query = $this->getPDO()->prepare($sql);
		return ($query->execute()) ? $query->fetchAll():[];
	}

	protected function search($table, $all = true, $colums =[], $codition =[]){
		$columsSQL = (empty($colums)) ? '*' : implode(', ',array_keys($colums)) ;
		$sql = "SELECT $columsSQL FROM $table ";

		if (!empty($codition)) {
			$sql .= " WHERE ";
			foreach ($codition as $key => $value) {
				$sql .= " $key =:$key AND ";
			}
			$ultimo_and = strrpos($sql,'AND');
			if($ultimo_and){
				$sql = substr($sql, 0, $ultimo_and);
			}
		}

		$query = $this->getPDO()->prepare($sql);
		foreach ($codition as $key => $value) {
		 	$query->bindValue(":$key","$value");
		}
		if ($query->execute()) {
			return ($all) ? $query->fetchAll() : $query->fetch();
		}
		return [];
	}

	protected function add($table,$colums){
		[$columsSQL, $placeholder, $paramts] = $this->return_plach_and_colums($colums);
		$sql = "INSERT INTO $table  ($columsSQL) VALUES ($placeholder)";
		$query = $this->getPDO()->prepare($sql);
		foreach($paramts as $key => $value){
			$query->bindValue($key,$value);
		}
		$query->execute();
		return $this->getPDO()->lastInsertId();
	}

	protected function update($table,$colums,$data_id){
		[$columsSQL, $placeholder, $paramts] = $this->return_plach_and_colums($colums);

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


	protected function delete($table, $data_id){
		$id = implode('',array_keys($data_id));
		$id_value = implode('',array_values($data_id));
		$sql = "DELETE FROM $table WHERE $id =:$id";
		$query = $this->getPDO()->prepare($sql);
		foreach ($data_id as $key => $value) {
			$query->bindValue($key,$value);
		}
		$query->execute();
	}

}

 ?>