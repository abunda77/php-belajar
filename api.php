<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$awb = $_POST['awb'];
$courier = $_POST['courier'];

$url = "https://api.binderbyte.com/v1/track";
$api_key = "7c25ea95caba25ee465342114fb5c1bd53890364dc1852130007c77630df5284";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.binderbyte.com/v1/track?api_key=' . $api_key . '&courier=' . $courier . '&awb=' . $awb . '',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;




$data = json_decode($response, true);

/*
var_dump($data);
echo "<pre>" . print_r($data, true);
echo "</pre>";
*/
$cek_status = $data["status"];
$cek_message = $data["message"];





if ($cek_status == 400 or $cek_status == null or $cek_status == 500 or $cek_status == 503 or $cek_status == 504 or $cek_status == 505) {
    echo "<h1 class='display-1 text-center mt-5'>Paket tidak terlacak</h1><br>
    <img src='assets/crying.gif' class='img-fluid mx-auto d-block' width='200px' height='200px'><br>";
    die();
}

$cek_data_summary_awb = $data["data"]["summary"]["awb"];
$cek_data_summary_courier = $data["data"]["summary"]["courier"];
$cek_data_summary_service = $data["data"]["summary"]["service"];
$cek_data_summary_status = $data["data"]["summary"]["status"];
$cek_data_summary_date = $data["data"]["summary"]["date"];
$cek_data_summary_desc = $data["data"]["summary"]["desc"];
$cek_data_summary_amount = $data["data"]["summary"]["amount"];
$cek_data_summary_weight = $data["data"]["summary"]["weight"];

$cek_data_detail_origin = $data["data"]["detail"]["origin"];
$cek_data_detail_destination = $data["data"]["detail"]["destination"];
$cek_data_detail_shipper = $data["data"]["detail"]["shipper"];
$cek_data_detail_receiver = $data["data"]["detail"]["receiver"];


$cek_data_history = $data["data"]["history"];
/*
        echo "<div class='container'>";
        echo "Code status :" . $cek_status;
        echo "Message :" . $cek_message;
        echo "</div>";
    */
function history($cek_data_history)
{

    echo "<div class='container mt-5 mb-5'>
        <div class='row'>
            <div class='col-md-6 offset-md-3'>
                <h4 class='mb-5'>Detail Hitory</h4>
                <ul class='timeline'>";
    foreach ($cek_data_history as $row) { ?>


        <li>
            <?= $row["date"]  ?>
            <?= $row['desc']; ?></p>
            <?= $row['location'];  ?></p>

        </li>
    <?php } ?>
<?php echo "
                </ul>
            </div>
        </div>
    </div>";
}
$summary = "
   
   
    <br>AWB :<b> $cek_data_summary_awb </b>
    <br>Ekspedisi :<b> $cek_data_summary_courier </b>
    <br>Jenis Layanan :<b> $cek_data_summary_service </b>
    <br>Tanggal Pengiriman :<b> $cek_data_summary_date </b>
    <br>Deskripsi barang :<b> $cek_data_summary_desc </b>
    <br>Jumlah Item :<b> $cek_data_summary_amount </b>
    <br>Berat :<b> $cek_data_summary_weight </b>
    </p></center>";

$data_pengiriman = "

    <p align=left>
    <br><br>Asal :<b> $cek_data_detail_origin  </b>
    <br>Tujuan :<b> $cek_data_detail_destination  </b>
    <br>Pengirim : <b>  $cek_data_detail_shipper </b>
    <br>Pengirim : <b> $cek_data_detail_receiver </b>

    </p></center>";




?>


<div class="card d-grid gap-3 mx-auto" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title p-2 bg-light border">Status : <?= $cek_data_summary_status ?></h5>
        <h6 class="card-subtitle mb-2 text-muted p-2 bg-light border"><?= $data_pengiriman ?></h6>
        <p class="card-text p-2 bg-light border"><?= $summary; ?></p>

    </div>


</div>


<table class="table table-bordered">
    <tr>
        <td>

            <?php

            history($cek_data_history);

            ?>

        </td>
    </tr>
</table>