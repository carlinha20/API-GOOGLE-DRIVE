<?php

$file = file_get_contents("https://drive.google.com/drive/folders/1IfIgdHSk4S-poPxgWqhbT4r3FcT0Qq0O"); // aqui é o texto que retorna para a variavel file// lendo o arquivo em uma string...
// string(sequencia de caracteres)
$file = explode("window['_DRIVE_ivd'] = '", $file)[1]; //Delimitador e a String// Todo texto em php é transformado em uma string
// quando faço a requisiçao com explode ele tras para mim as informaçoes trnsformanda em uma array(índices)
$file =stripcslashes($file); // ele vai decodificar a string de forma visivel
$file = explode("';if ", $file)[0]; // aqui ele vai me trazer um array

//header("Content-Type: application/json; charset=UTF-8");
$file = json_decode($file); //aquii vai decodificar os array
$file = $file[0];

//echo $file; // o echo é para string e nao para texto, aqui ele vai me trazer objeto 

//var_dump($file); // aqui ele vai trazer o texto
$result = [];

foreach ($file as $item) { // aqui vai ser o loop das informaçoes 
     $r = new StdClass; // objeto do php
     $r->id = $item[0];
     $r->download = "https://drive.google.com/u/0/uc?id=$item[0]&export=download";
     $r->folder = $item[1][0];
     $r ->nome = $item[2];

     array_push($result, $r); // ele vai trazer todas as informaçoes contida nos valores em cima


	//var_dump($r);
	# code...
}

//var_dump($result);
header("Content-Type: application/json");//sao os tipos de conteudos que vai passar por aqui
echo json_encode($result);

?>