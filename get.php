<?php

require 'constants.php';

$key = trim(file_get_contents("KEY"));
$station = trim(file_get_contents("STATION"));

$url = "https://api.wmata.com/StationPrediction.svc/json/GetPrediction/$station";
$headers = [
	"Accept: application/json",
	"api_key: $key"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result);

//echo print_r($data, true)."\n";

$trains = $data->Trains;
$hasData = (array)$trains;

$options = Array();

for ($i = 0; $hasData && $i < sizeOf($trains); $i++) {
	if (!$options[$trains[$i]->Group]) {
		$options[$trains[$i]->Group] = Array();
	}
	$optionData = Array();
	$optionData['line'] = $trains[$i]->Line;
	$optionData['dest'] = $trains[$i]->DestinationName;
	$optionData['time'] = $trains[$i]->Min;
	array_push($options[$trains[$i]->Group], $optionData);
}

//echo print_r($options, true)."\n";

$fout = "current.dat";
$outfile = fopen($fout, "w");
fwrite($outfile, json_encode($options));
fclose($outfile);
?>

