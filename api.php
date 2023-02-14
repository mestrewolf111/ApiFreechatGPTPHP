<?php
#session_start();
ignore_user_abort(1);
set_time_limit(0);
error_reporting(0);

############################################# 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lista = $_POST['lista'];
    
    }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
        $lista = $_GET['lista'];
   
    }

    function getStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function multiexplode($delimiters, $string) {
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

$url = $_GET['lista'];
$texto = urldecode($url);

$separar = explode(' ', $texto);
$texto = implode(' ', $separar);



function __curl($url, $post = false, $header = false){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  if ($post) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie_hz.txt');
  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie_hz.txt');
  if ($header) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  }
  $exec = curl_exec($ch);
  return $exec;
}  

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.openai.com/v1/completions",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"model\": \"text-davinci-003\",\n  \"prompt\": \"$texto\",\n  \"temperature\": 0.7,\n  \"max_tokens\": 256,\n  \"top_p\": 0.83,\n  \"frequency_penalty\": 0,\n  \"presence_penalty\": 0\n}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer API-KEY",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);

 $data = getStr($response, 'text":"', '"');

 echo '#Reposta =>'.$data.'';

?>
 
