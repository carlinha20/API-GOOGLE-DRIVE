<?php 
require_once "functions.php"; 

// $data = get_video_info('1l1qnF1LyQOzSqJZX9DdrlOD5cOhQmovd');
$data = get_video_info('1wbjbo5qepHGxVf46RPKoaAGU7iZUEdR0'); // aqui pego os dados passando pelo ID = trazendo a requisiçao
// $data = get_video_info('1ZQX54BRUiF-sO73sogaAdK4RhIcFPLis');
// $data = get_video_info('1r_2xs5KEqNpeThypcMq-KJ_NSWqyXgDq');

// $h = get_Content_Length($data->formats[0]->url);

// var_dump($data);
// var_dump($h);


$headers = [ //serve para definir ou modificar as diretivas do cabeçalho HTTP de uma mensagem de resposta do servidor para o cliente
	"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 Edg/98.0.1108.56",
	"cookie: DRIVE_STREAM=$data->drive_stream;",
];

$headers = implode("\n", $headers); //ele junta todos e depois separa com barra n, na requisiçao da parte de cima

$options = (
	array(
		"http"=> array(
			//"follow_location"=>false,// tras uma busca e aqui nao quero que ele redirecione para outra pagina
			'method'=>'GET', // métodos utilizados para o envio de dados de um formulário web para processamento por um script em php
			"header"=>"Content-Type: application/x-www-form-urlencoded\r\n".$headers,
		)
	)
);

$context = stream_context_create($options); //aqui ele joga as informaçoes atribuida em cima em uma unica funçao, coletando os dados

// header('Content-Length: 27996334');
header('content-type: video/mp4');
header('accept-ranges: bytes'); // nessa parte estou passando todos os meus dados por aqui// estou tratando o video para carregar mais rapido sem dar travadas na hora de carregar
header('Pragma: public');
header('Expires: 0');
header('Content-Transfer-Encoding: binary');
// header('Content-Disposition: inline; filename="videoplayback_proxy.mp4";');
header('Content-Disposition: inline; filename="videoplayback_proxy.mp4";'); // aqui é´o nome do arquivo 

// $file = "media/videoplayback.mp4";
$file = $data->formats[0]->url;

// var_dump($file);

$chunkSize = 2048 * 2048; // tanto de memoria que posso quebrar// ou seja um calculo doido que da certo '-'
$handle = fopen($file, 'rb', false, $context);

$content_length = get_Content_Length($http_response_header);
header("Content-Length: $content_length");

// die();

while (!feof($handle)){
    $buffer = fread($handle, $chunkSize); // nessa parte ele tras linha por linha do arquivo, buscando o video no modo automatico sem travar. Tirando isso se travar ésua net da xuxa
    echo $buffer;
    ob_flush();
    flush();
}
fclose($handle);
exit;




?>