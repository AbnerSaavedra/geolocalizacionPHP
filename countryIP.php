<?php  

include("libraries/geoip.inc");


function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
 
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
 
    return $_SERVER['REMOTE_ADDR'];
}

function devolverInfoIP(){

$ip = getRealIP();

$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);

$country_code = geoip_country_code_by_addr($gi, $ip);
echo "Your country code is: $country_code \n\n";

$country_name = geoip_country_name_by_addr($gi, $ip);
echo "Your country name is: $country_name \n\n";
 
 geoip_close($gi);

header('Content-Type: application/json');
//Guardamos los datos en un array
$datos = array(
'estado' => 'ok', 
'countryName' => $country_name, 
'countryCode' => $country_code
);
//Devolvemos el array pasado a JSON como objeto
return json_encode($datos, JSON_FORCE_OBJECT);
}

echo(devolverInfoIP());

?>