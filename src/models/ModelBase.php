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



}

 ?>