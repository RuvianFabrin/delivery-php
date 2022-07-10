<?php
session_start();
header('Content-type: text/html; charset=UTF-8');
class db {

    /*private $user ="wwisoe_quality"; //"wwisoe_dev";
    private $pass ="]8cpb3FVT%5B"; //"OqIuTd7ThQBgh";
    private $host = "localhost";
    private $database = "wwisoe_quality_base";//"wwisoe_quality_dev";
    private $ultimoId="Não iniciou.";*/

    private $user ="wwisoe_dev"; 
    private $pass ="OqIuTd7ThQBgh";
    private $host = "localhost";
    private $database = "wwisoe_quality_dev";
    private $ultimoId="Não iniciou.";

    private function Connect() {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->database;charset=latin1", $this->user, $this->pass,array(
            PDO::ATTR_PERSISTENT => true
        ));
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
//Só entra se está logado
if(isset($_SESSION)){
    if($_SESSION["idusuario"] > "0"){
        $obj = new db();
        $metodo = $_SERVER['REQUEST_METHOD'];
        $retorno=array();
        $param=array();//381ms
        foreach ($_REQUEST as $key => $value) { $nkey =  $obj->decript_tela($key);  $param[$nkey] =  $obj->decript_tela($value);}
        
        if ($metodo == 'POST') {
            //Update, insert, delete
            if(isset($param["select"]) || isset($param["update"]) || isset($param["delete"]) || isset($param["insert"])){ 
                //Verifica o tipo de ação
                if(isset($param["select"])){
                    $param["sql"]=$param["select"];
                    unset($param["select"]); 
                    $statement = $obj->run($param);
                    $retorno = ($statement->execute()) ?$statement->fetchAll(PDO::FETCH_ASSOC): array();//Select
                }elseif(isset($param["delete"])){
                    $param["sql"]=$param["delete"];
                    unset($param["delete"]); 
                    $statement = $obj->run($param);
                    $retorno = ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
                }elseif(isset($param["update"])){
                    $param["sql"]=$param["update"];
                    unset($param["update"]); 
                    $statement = $obj->run($param);
                    $retorno = ($statement->execute()) ? array('r' => "ok"): array('r' => "erro", );//Update ou delete
                }elseif(isset($param["insert"])){  
                    $param["sql"]=$param["insert"];   
                    unset($param["insert"]);  
                    $statement = $obj->run($param);
                    $retorno = ($statement->execute()) ? array('r' => "ok", "id"=>$obj->ultimoID()): array('r' => "erro", );//Update ou delete
                }
            }
        } 
        echo (json_encode($retorno))?json_encode($retorno):'"message":"Erro:'.json_last_error_msg().'"';
    }
}


/*  
    //Post
    protected $sqlInsert = "insert into %s (%s) values (%s)";$this->RunQuery($sql);
    protected $sqlUpdate = "update %s set %s where %s "; $this->RunQuery($sql);
    protected $sqlDelete = "delete from %s where %s"; $this->RunQuery($sql);

    // SQL.
    $sql = "UPDATE produto SET nome_produto = :nome, quant_produto = :quant, valor_produto = :valor WHERE id_produto = :id"; 

    // Estabelecendo conexão com o bando e passando os dados com prepare() e via bindValue().
    $stmt = $pdo->prepare($sql);
    $stmt -> bindValue(":id", 10);
    $stmt -> bindValue(":nome", "Alguma coisa");
    $stmt -> bindValue(":quant", 2000);
    $stmt -> bindValue(":valor", 3.5);

    // Verificando se deu tudo certo durante a execução.
    if ($stmt->execute()) {
        header('Location: ../index.php');
    } else {
        $msg = "Erro ao editar produto.";
    }



    //Get
    protected $sqlSelect = "select %s from %s where %s %s"; $this->RunSelect($string_sql);

    $query = "SELECT \* FROM Usuario WHERE Email = :email AND Senha = :senha";

    $statement = $this->con->prepare($query);
    $statement->bindValue(":email",$email); 
    $statement->bindValue(":senha",$senha);

    $statement->execute(); 
    $usuario = $statement ->fetchObject('Vendor Model Usuario'); 
    return $usuario; 
 */
?>