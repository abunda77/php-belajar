<?php


ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['Submit'])) {

    $awb = trim($_GET["awb"]);
    $courier = trim($_GET["courier"]);

    switch ($courier) {
        case 'jne':
            $msg = 'JNE Reguler';
            //echo $msg;
            break;

        case 'jnt':
            $msg = 'JNT Reguler';
            //echo $msg;    
            break;

        case 'sicepat':
            $msg = 'SiCepat Reguler';
            //echo $msg;    
            break;


        case 'anteraja':
            $msg = 'Anteraja Reguler';
            //echo $msg;    
            break;

        case 'spx':
            $msg = 'Sopee Express';
            //echo $msg;    
            break;

        case 'pos':
            $msg = 'POS Indonesia';
            //echo $msg;    
            break;

        case 'tiki':
            $msg = 'TIKI Reguler';
            //echo $msg;    
            break;

        case 'ide':
            $msg = 'ID Express';
            //echo $msg;    
            break;

        case 'sicepat':
            $msg = 'SiCepat Reguler';
            //echo $msg;    
            break;
    }


    if ($awb == "") {
        $errorMsg =  "error : AWB kosong.";
        $code = "1";
    } elseif ($courier == "") {
        $errorMsg =  "error : Kurir belum diisi :";
        $code = "2";
    } else {
        echo "<div class='alert alert-success' role='alert'>
        Data terkirim, silahkan cek resi di bawah ini.
      </div>";
        //final code will execute here.


        // cek variabel
        echo "<div class='container'>";
        echo "Nomor resi: <b>" . $awb . "</b>";
        echo "<br><br>";
        echo "Ekspedisi : <b>" . $courier . "</b><br><br>";
        echo "</div>";
        //$json = '';

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


        //var_dump($data);

        $cek_status = $data["status"];
        $cek_message = $data["message"];

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
        //$cek_data_history_date = $data["data"]["history"]["date"];
        //$cek_data_history_desc = $data["data"]["history"]["desc"];
        //$cek_data_history_location = $data["data"]["histroy"]["location"];
        echo "<div class='container'>";
        echo "Code status :" . $cek_status;
        echo "Message :" . $cek_message;
        echo "</div>";

        




        function history($cek_data_history)
        {
           
            echo "<div class='container mt-5 mb-5'>
        <div class='row'>
            <div class='col-md-6 offset-md-3'>
                <h4>Detail Hitory</h4>
                <ul class='timeline'>";
            foreach ($cek_data_history as $row) { ?>


                    <li>
                        <?=  $row["date"]  ?>
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
            <br><br>Cek status :<b> $cek_status </b>
            <br> Message : <b> $cek_message </b>;
            <br>Status Pengiriman :<b> $cek_data_summary_status </b>
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
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Resi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css ">
    <script src="js/jquery-3.6.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <style type="text/css">
        .errorMsg {
            border: 1px solid red;
        }

        .message {
            color: red;
            font-weight: bold;
        }

        ul.timeline {
            list-style-type: none;
            position: relative;
        }

        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }

        ul.timeline>li {
            margin: 20px 0;
            padding-left: 20px;
        }

        ul.timeline>li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-primary">Cek Resi</h1>
                <?php if (isset($errorMsg)) {
                    echo "<p class='message'>" . $errorMsg . "</p>";
                } ?>
                <form action="" method="get">
                    <div class="form-group">
                        <label for="resi">Masukkan No Resi</label>
                        <input type="text" name="awb" placeholder="Masukkan No Resi" class="form-control" value="<?php if (isset($awb)) {
                                                                                                                        echo $awb;
                                                                                                                    } ?>">

                        <select name="courier" id="courier" class="form-control">
                            <option value="<?php if (isset($code) && $code == 2) {
                                                echo "class=errorMsg";
                                            } ?> ">Pilih Kurir</option>
                            <option value="jne">JNE</option>
                            <option value="jnt">JNT</option>
                            <option value="sicepat">SICEPAT</option>
                            <option value="anteraja">Anter AJA</option>
                            <option value="spx">Shopee Express</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                            <option value="ide">ID Express</option>
                        </select>
                        <input type="Submit" name="Submit" value="Cek Resi" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>Summary</th>
                <th>Detail</th>
            </tr>
            <tr>
                <td><?php echo $summary; ?></td>
                <td><?php echo $data_pengiriman; ?></td>
            </tr>

            <tr>
                <td>

                    <?php





                    //echo $pesan;
                    //echo $summary;
                    //echo $data_pengiriman;
                    history($cek_data_history);





                    ?>

                </td>
            </tr>
        </table>
    </div>

    
    
   


</body>

</html>