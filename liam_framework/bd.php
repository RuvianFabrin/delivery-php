<?php
//session_start();
header('Content-type: text/html; charset=UTF-8');
class db {

    /*private $user ="wwisoe_quality"; //"wwisoe_dev";
    private $pass ="]8cpb3FVT%5B"; //"OqIuTd7ThQBgh";
    private $host = "localhost";
    private $database = "wwisoe_quality_base";//"wwisoe_quality_dev";
    private $ultimoId="Não iniciou.";/**/
    /** */
    private $user ="root"; 
    private $pass ="";
    private $host = "localhost";
    private $database = "delivery";
    private $ultimoId="Não iniciou.";/**/

    private function Connect() {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->pass,array(
            PDO::ATTR_PERSISTENT => true
        ));//charset=latin1"//utf8
        $conn -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        return $conn;
    }
    public function sq($sql) {
        return $this->Connect()->prepare($sql);
    }
    
    public function RunQuery($sql) {
        //tirado para aumentar performance, o usuario que conecta no banco só faz insert,select, delete e update
        //05/04/2021
        //if($this->prevent_injection($sql)){
            $stm = $this->Connect()->prepare($sql);
            $executou= $stm->execute();
            $this->ultimoId= $this->Connect()->lastInsertId();
            return $executou;
        //}
    }
    public function ultimoID(){
        return $this->Connect()->lastInsertId();
    }

    public function run($param){
        $statement = $this->sq($param["sql"]);
        unset($param["sql"]);
        foreach ($param as $key => $value) {
            $statement->bindValue(":".$key,$value); 
        }
        return $statement;
    }

    public function insert($param){
        $statement = $this->sq($param["sql"]);
        unset($param["sql"]);
        foreach ($param as $key => $value) {
            $statement->bindValue($key,$value); 
        }
        return $statement;
    }


    public function RunSelect($sql) {
       //if($this->prevent_injection($sql)){
            $stm = $this->Connect()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        //}
    }
    public function GetColumns($sql) {
        //if($this->prevent_injection($sql)){
            $stm = $this->Connect()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_COLUMN);
        //}
    }
    public function encript_tela($data){
        $openSSL =  openssl_encrypt(
             $data,
             'AES-128-CBC',
             $_SESSION["SECRET"],
             0,
             $_SESSION["SECRET_IV"]);
        $preparaUm = str_replace("/","_brr_",$openSSL);
        $preparaDois = str_replace("=","_gl_",$preparaUm);
        $retorno = str_replace("+","_ms_",$preparaDois);
        return "xtdrk_".$retorno;
    }
    public function decript_tela($data){
        $preparaU = str_replace("xtdrk_","",$data);
        $preparaUm = str_replace("_ms_","+",$preparaU);
        $preparaDois = str_replace("_brr_","/",$preparaUm);
        $dado = str_replace("_gl_","=",$preparaDois);
        //echo "<br>";
        //print_r($dado);
        //echo "<br>";
        $retorno = openssl_decrypt(
             $dado,
             'AES-128-CBC',
             $_SESSION["SECRET"],
             0,
             $_SESSION["SECRET_IV"]);
            return ($retorno)?$retorno:$data;
    }
}
/*

CONVERT(CAST(op_urgencia AS BINARY) USING utf8),
CONVERT(CAST(op_conserto AS BINARY) USING utf8)
/**/
?>