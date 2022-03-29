<?php  
function url_parser($str){
	parse_str($str, $info);// aqui ele organiza a parte da estrutura das informaçoes contida na linha 46
	return (object)$info;
}

function get_Content_Length($response_headers){
	foreach ($response_headers as $header) {
		if(strpos($header, "Content-Length") !== false){ //aqui organizo todas as informaçoes contida junto com o cookies
			return explode(": ", $header)[1];
			break;
		}
	}
}

function get_DRIVE_STREAM($file){
	foreach ($file as $item) {
		if(strpos($item, 'DRIVE_STREAM=') !== false){ //essa funçao limpa todo a requisiçao trazida // e tras os conteudo de uma forma limpa contida nela
			$file = explode(': ', $item)[1];
			$file = str_replace('DRIVE_STREAM=', '', $file);
			$file = explode(';', $file)[0];
		}
	}
	return $file; // aqui ele vai me da um retorno do drive stream
}

function get_video_info($docid){
	$endpoint = "https://drive.google.com/u/0/get_video_info?docid=$docid&drive_originator_app=303";

	$headers = [
		"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 Edg/98.0.1108.56",
	];

	$headers = implode("\n", $headers);

	$options = [
		"http"=>[
			"follow_location"=>false,// tras uma busca, e aqui nao quero que ele redirecione para outra pagina
			"header"=>"Content-Type: application/x-www-form-urlencoded\r\n".$headers,
			"method"=>"GET",
		]
	];

	$context = stream_context_create($options);//aqui ele joga as informaçoes atribuida em cima em uma unica funçao, coletando os dados
	$file = file_get_contents($endpoint, false, $context);//
	$file = url_parser($file)->url_encoded_fmt_stream_map;//aqui vem o codigo com assinatura, ou seja, ele organiza todo o codigo e tras tudo contextualizado(organizado).
	// $file = url_parser($file);
	// var_dump($file);

	// die();
	
	// var_dump($drive_stream);
	
	$formats = explode(',', $file);
	$f = [];

	foreach ($formats as $item) {
		parse_str($item, $format);
		array_push($f, (object)$format);
	}

	$drive_stream = get_DRIVE_STREAM($http_response_header);

	$result = new StdClass;
	$result->drive_stream = $drive_stream;
	$result->formats = $f;

	// var_dump($result); // ele tras de uma forma atualizada a cada busca que for dado no video, os cookies sao atualizado // por isso que sera algo dificil de expirar os videos. '-'
	return $result;

}	





// get_video_info('1l1qnF1LyQOzSqJZX9DdrlOD5cOhQmovd');


?>