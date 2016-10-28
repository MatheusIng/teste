<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');

$data = file_get_contents("php://input");
$objData = json_decode($data);

$dns = "mysql:host=localhost;dbname=alexandria_13";
$user = 'root';
$pass = 'usbw';

$counter = $objData->counter;
$token = $objData->token;

try {	
	$con = new PDO($dns, $user, $pass);
	if(!$con){
		echo "Não foi possivel conectar com Banco de Dados!";
	}
	if ($token === "1f3d2gs3f2fg3as2fdg3re2t1we46er45" && isset($token)) {
		
	$query = $con->prepare('SELECT * FROM livros LIMIT '.$counter.', 5');
		
        $query->execute();
		
        $out = "[";
		
        while($result = $query->fetch()){
			if ($out != "[") {
				$out .= ",";
			}
			$out .= '{"id_livro": "'.$result["id_livro"].'",';
			$out .= '"nome_livro": "'.$result["nome_livro"].'",';
			$out .= '"autor": "'.$result["autor"].'",';
			$out .= '"nome_dono": "'.$result["nome_dono"].'"}';
		}
		$out .= "]";
		echo $out;
	
	}
} catch (Exception $e) {
	echo "Erro: ". $e->getMessage();
};
