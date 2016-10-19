<?php
//$access_token = '6AHZeq++0ib7lwzyTgJJdOJON151Ugy/L3EXVepD5tBAj/MhR5iwoQxufCbcEyGXjVP7YP7xLAOeNDCKeoLmtpaIt1dxiuz+Hs5oYxOMTPQ4I61ttgUzX10Dc3ofzQ8BEYxql2nC1c23Wy9TRpIL+QdB04t89/1O/w1cDnyilFU=';
$access_token = 'GetTMp7MUnHI0c5JhOidQ8Vhp2sa96hGnfMjGq89KUT6luiflYZKTwTCrkXuES1DI4kg9Y5/dkDa5hZF/OfJ+MhzUsnnamUfcctnguRE3uYiPmhKA9ZiLRfIsiHShTGSdqVynUdOx7AC+u/36YBn4gdB04t89/1O/w1cDnyilFU=';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
