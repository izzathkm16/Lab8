<?php
class DBController {
	private $host = "localhost";
	private $user = "izzat";
	private $password = "zap";
	private $database = "db_auth";
	private $pdo;

	function __construct() {
			$this->pdo = $this->connectDB();
}

function connectDB() {

	$pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8mb4', $this->user, $this->password);
	// See the "errors" folder for details...
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;

	// $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
	// return $conn;
}
    function runBaseQuery($query) {
				$stmt = $this->pdo->prepare($query);
				while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                $resultset[] = $row;
                }
                if(!empty($resultset))
                return $resultset;
    }



  function runQuery($query, $param_type, $param_value_array) {

        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->fetchAll();
				$sql->setFetchMode(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            foreach ($result as $row) {
                $resultset[] = $row;
            }
        }

        if(!empty($resultset)) {
            return $resultset;
        }
    }



    function bindQueryParams($sql, $param_type, $param_value_array) {
			//$sth = $this->pdo->prepare($sql);

				$param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $array[$i] = & $param_value_array[$i];


        }

				if ($param_type =='s'){
					$sql->bindParam(1, $array[0], PDO::PARAM_STR);

				}
				else if ($param_type == 'ii'){
					$sql->bindParam(1, $array[0], PDO::PARAM_INT);
					$sql->bindParam(2, $array[1], PDO::PARAM_INT);
				}

				else if ($param_type == 'ssss'){
					$sql->bindParam(1, $array[0], PDO::PARAM_STR);
					$sql->bindParam(2, $array[1], PDO::PARAM_STR);
					$sql->bindParam(3, $array[2], PDO::PARAM_STR);
					$sql->bindParam(4, $array[3], PDO::PARAM_STR);
				}


        // call_user_func_array(array(
        //     $sql,
        //     'bind_param'
        // ), $param_value_reference);
    }

    function insert($query, $param_type, $param_value_array) {
        $sql = $this->pdo->prepare($query);
        $this->bindQueryParams($query, $param_type, $param_value_array);
        $sql->execute();
    }

    function update($query, $param_type, $param_value_array) {
        $sql = $this->pdo->prepare($query);
        $this->bindQueryParams($query, $param_type, $param_value_array);
        $sql->execute();
    }
}
?>
