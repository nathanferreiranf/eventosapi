<?php 
header('Content-Type: application/json');

# Substitua abaixo os dados, de acordo com o banco criado
$user = "gotec";
$password = "gotec_adm_sql"; 
$database = "eventosapi"; 

# O hostname deve ser sempre localhost 
$hostname = "mydbcaseof.cxvv0uf8ozxe.us-east-1.rds.amazonaws.com"; 

# Conecta com o servidor de banco de dados 
$link = mysqli_connect($hostname, $user, $password, $database);

//mysql_connect( $hostname, $user, $password ) or die( ' Erro na conexão ' ); 
//mysql_select_db( $database ) or die( 'Erro na seleção do banco' );

$query = "SELECT * FROM users";
$result_query = mysqli_query( $link, $query ) or die(' Erro na query:' . $query . ' ' . mysql_error() );

$data = [];

while ($row = mysqli_fetch_array( $result_query )) { 
    array_push($data, $row);
}

mysqli_close($link);

//Criamos uma função que recebe um texto como parâmetro.
function gravar($texto){
	//Variável arquivo armazena o nome e extensão do arquivo.
	$arquivo = "meu_arquivo.txt";
	
	//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
	$fp = fopen($arquivo, "a+");

	//Escreve no arquivo aberto.
	fwrite($fp, $texto);
	
	//Fecha o arquivo.
	fclose($fp);
}

gravar(json_encode($data));

?>