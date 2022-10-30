<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

$awb = $_POST['awb'];
$courier = $_POST['courier'];

$url = "https://api.binderbyte.com/v1/track";

$api_key = $keys; // API Key ada di file config.php

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
    echo "<div class='alert alert-danger fs-6 text-center' role='alert'
    style='margin-left: 150px;margin-right: 190px;margin-top: 55px;padding-left: 85px;padding-right: 61px;'><span
        class='fs-6' style='margin-right: -1px;margin-left: -85px;''>Paket tidak terlacak ...!</span></div>
    <img src='assets/crying.gif' class='img-fluid mx-auto d-block' width='200px' height='200px' loading='lazy'><br>
    <footer class='text-center py-4'>
    <div class='container'>
        <div class='row row-cols-1 row-cols-lg-3'>
            <div class='col-lg-10 offset-lg-1 offset-xl-1 offset-xxl-1'>
                <p class='fs-6 fw-light text-center my-2'><strong>Copyright © 2022</strong><a href='https://kangmaserie.my.id' target='_blank'><strong> Kangmaserie.my.id</strong></a></p>
            </div>
        </div>
    </div>
</footer>";
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
   
<p align=left>
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






<!-- Mulia di sini -->
<div class="alert alert-success fs-6 text-center" role="alert"
    style="margin-left: 150px;margin-right: 190px;margin-top: 55px;padding-left: 85px;padding-right: 61px;"><span
        class="fs-6" style="margin-right: -1px;margin-left: -85px;">Status : <strong>Delivered </strong></span></div>
<div class="table-responsive" style="margin-top: 57px;margin-bottom: 39px;">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Summary</th>
                <th>Data Pengiriman</th>

            </tr>
        </thead>
        <tbody>

            <tr>
                <td>

                    <h6 class="card-subtitle mb-2 text-muted p-2 bg-light border">
                        <br><?= $summary ?>
                    </h6>
                </td>
                <td>
                    <p class="card-text p-2 bg-light border"><?= $data_pengiriman; ?></p>
                </td>

            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <tr>
            <td>

                <?php

                history($cek_data_history);

                ?>

            </td>
        </tr>
    </table>
    <footer class="text-center py-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col-lg-10 offset-lg-1 offset-xl-1 offset-xxl-1">
                    <p class="fs-6 fw-light text-center my-2"><strong>Copyright © 2022</strong><a
                            href="https://kangmaserie.my.id" target="_blank"><strong> Kangmaserie.my.id</strong></a></p>
                </div>
            </div>
        </div>
    </footer>
</div>