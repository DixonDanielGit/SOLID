<?php 

namespace App\models\repositories;

use App\config\Connection;
use  App\models\query_construct\Query;
use App\Paciente;

class PacienteRepository
{
	private $db;
	
	function __construct($db)
	{
		$this->db = $db;
	}


	public function paginate($colums, $search='',$page=1, $perPage=10)
	{
		$query = new Query();
		$query->table('paciente')->columns($colums)->orderBy('id_paciente','DESC')->paginate($perPage, ($page - 1) * $perPage);

		if ($search) {
			$likeConditions = [];
			foreach ($colums as $col) {
				$likeConditions[]="$col LIKE :search";
			}
			$query->where(implode(" OR ", $likeConditions), ['search'=>"%$search%"]);
		}

		$sql= $query->select_construct();
		$q = $this->db->getPDO()->prepare($sql);
		foreach ($query->getParams() as $key => $value) {
			$type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
			$q->bindValue(":$key",$value, $type);
		}
		return ($q->execute()) ? $q->fetchAll() : [];
	}

}


 ?>