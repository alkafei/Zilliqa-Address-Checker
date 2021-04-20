<?php

/**
 *  Thx to Wahyu Arif P (warifp)
 * tinggalkan cangkulmu dan mulailah scan bersamaku
 */
 
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

echo "INPUT LIST ADDRESS ZIL: ";
$zil = trim(fgets(STDIN));
$list = file_get_contents($zil);
$datas = explode("\n", str_replace("\r", "", $list));

for ($i = 0; $i < count($datas); $i++) {
    
$address = $datas[$i];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.viewblock.io/zilliqa/addresses/'.$address.'?txsType=tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0';
$headers[] = 'origin: https://viewblock.io';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$ini = json_decode($result);
if ($ini->tokens->zil1hpwshtxspjakjh5sn7vn4e7pp4gaqkefup24h2) {
if ($ini->tokens->zil1hpwshtxspjakjh5sn7vn4e7pp4gaqkefup24h2->balance) {
    $balance = $ini->tokens->zil1hpwshtxspjakjh5sn7vn4e7pp4gaqkefup24h2->balance;
} else {
    $balance = 0;
}
$timestampx = $ini->extra->sync->timestamp;
$timestamp = date('d-m-Y H:i:s', $timestampx / 1000 );
$resultnya = "$address [ XPORT Balance: $balance ] [ Latest XPORT TX Date: $timestamp ]";
} else {
    $balance = 0;
    $resultnya = "$address [ XPORT Balance: $balance ]";
}

echo $resultnya.PHP_EOL;
}
echo 'DONE!'.PHP_EOL;
?>