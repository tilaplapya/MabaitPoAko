<?php 
    class Get{
        private $pdo;

        public function __construct(\PDO $pdo)
        {
            $this->pdo=$pdo;
        }

    public function executeQuery($sql){
        $data = array();
        $errmsg = "";
        $code = 0;

        try {
            if($result = $this->pdo->query($sql)->fetchAll()){
                foreach ($result as $record) {
                    # code...
                    array_push($data, $record);
                }
                $code=200;
                $result=null;
                return array("code"=>$code, "data"=>$data);
            }
            else{
                $errmsg = "not found";
                $code = 404;
            }
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }
        return array("code"=>$code, "errmsg"=>$errmsg);
    }


    public function sendPayload($data, $remarks, $message, $code){
        $status = array("remarks"=>$remarks, "message"=>$message);
        http_response_code($code);
        return array(
        "status"=>$status, 
        "payload"=>$data,
        "prepared by"=>"niggerman",
        "timestamp"=>date_create()
    );


    }

    public function get_record($table, $condition=null){
        $sqlString="SELECT * FROM $table";
        if($condition != null){
            $sqlString.= "WHERE" .$condition;
        }
        $result = $this->executeQuery($sqlString);

        if($result['code']==200){
            return $this->sendPayload($result['data'] , 'Yey' , 'bobo ka pala eh' , $result['code']);
        }
        return $this->sendPayload(null , 'sad' , 'bobo ka talaga brian gabriel emmanuel entero gonzales' , $result['code']);
    }
    
    public function get_employees($id=null){
        $conditionString = null;
        if($id!=null){
            $conditionString = "EMPLOYEE_ID=$id";
        }
        return $this->get_record("employees",$conditionString);
    }
    }
?>