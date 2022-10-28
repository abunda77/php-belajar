<?php

// Cek Gempa Terkini 1 Data

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Authority: data.bmkg.go.id';
$headers[] = 'Pragma: no-cache';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

//echo $result;

$data = json_decode($result, true);
//echo "<pre>" .print_r($data, true);
//echo "</pre>";




$tanggal = $data["Infogempa"]['gempa']['Tanggal'];
$jam = $data["Infogempa"]['gempa']['Jam'];
$stamp = $data["Infogempa"]['gempa']['DateTime'];
$koordinate = $data["Infogempa"]['gempa']['Coordinates'];
$lintang = $data["Infogempa"]['gempa']['Lintang'];
$bujur = $data["Infogempa"]['gempa']['Bujur'];
$magnitude = $data["Infogempa"]['gempa']['Magnitude'];
$kedalaman = $data["Infogempa"]['gempa']['Kedalaman'];
$wilayah = $data["Infogempa"]['gempa']['Wilayah'];
$potensi = $data["Infogempa"]['gempa']['Potensi'];
$dirasakan = $data["Infogempa"]['gempa']['Dirasakan'];
$shakemap = $data["Infogempa"]['gempa']['Shakemap'];










?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gempa Teraakhir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

    <h1 class="text-center text-primary">Gempa Terakhir</h1>
    <div class="alert alert-primary" role="alert">
        <strong>Informasi Gempa</strong> <i>terupdate</i>
    </div>
    </h2>
    <section class="mx-auto p-5">
        <table class="table table-bordered">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo $tanggal ?></td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>:</td>
                <td><?php echo $jam ?></td>
            </tr>
            <tr>
                <td>Lintang</td>
                <td>:</td>
                <td><?php echo $lintang ?></td>
            </tr>
            <tr>
                <td>Bujur</td>
                <td>:</td>
                <td><?php echo $bujur ?></td>
            </tr>
            <tr>
                <td>Magnitude</td>
                <td>:</td>
                <td><?php echo $magnitude ?></td>
            </tr>
            <tr>
                <td>Kedalaman</td>
                <td>:</td>
                <td><?php echo $kedalaman ?></td>
            </tr>
            <tr>
                <td>Wilayah</td>
                <td>:</td>
                <td><?php echo $wilayah ?></td>
            </tr>
            <tr>
                <td>Potensi</td>
                <td>:</td>
                <td><?php echo $potensi ?></td>
            </tr>
            <tr>
                <td>Shakemap</td>
                <td>:</td>
                <td><img src="https://data.bmkg.go.id/DataMKG/TEWS/<?= $shakemap ?>"></td>
            </tr>

        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</body>

</html>