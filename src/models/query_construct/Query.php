<?php 

namespace App\models\query_construct;

class Query
{
	private $table;
	private $columns =[];
	private $coditions =[];
	private $params =[];
	private $orderBy ='';
	private $orderDir='DESC';
	private $limit=null;
	private $offset=null;


	public function table($table)
	{
		$this->table = $table;
		return $this;
	}

	public function columns($columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function where($condition, $params=[])
	{
		$this->coditions[]= $condition;
		$this->params = array_merge($this->params,$params);
		return $this;
	}

	public function orderBy($colum, $dir='DESC')
	{
		$this->orderBy = $colum;
		$this->orderDir = $dir;
		return $this;
	}

	public function paginate($limit, $offset)
	{
		$this->limit = $limit;
		$this->offset = $offset;
		return $this;
	}
	

	public function select_construct()
	{
		$cols = empty($this->colums) ? '*' : implode(' ,', $this->colums);
		$sql = "SELECT $cols FROM {$this->table}";
		if (!empty($this->coditions)) {
			$sql .= " WHERE ". implode(" AND ", $this->coditions);
		}
		if($this->orderBy){
			$sql .= " ORDER BY {$this->orderBy} {$this->orderDir} ";
		}
		if($this->limit){
			$sql .= " LIMIT {$this->offset}, {$this->limit}";
		}

		return $sql;
	}

	public function getParams(){
		return $this->params;
	}

}

 ?>