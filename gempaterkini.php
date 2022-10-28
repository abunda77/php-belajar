<?php
// Cek Data 15 gempa Terbaru

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$url = "https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json";

$data = file_get_contents($url);

$datas = json_decode($data, true);

//echo "<pre>" . print_r($datas, true);
//echo "</pre>";

// Declare a multi-dimensional array
/* $arr = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9)
);
*/
//echo "<pre>" . print_r($arr, true);
//echo "</pre>";
// Iterate through the array using foreach
// construct and store the key and its value

// Use foreach loop to display the
// key of allelements
/*
foreach ($arr as $keyOut => $out) {
    foreach ($out as $keyIn => $value) {
        echo "key = (" . $keyOut . ", " . $keyIn
            . "), value = " . $value . "\n";
    }
}

*/

$detail = $datas["Infogempa"]["gempa"];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Gempa Terkini</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>




</head>

<body>
    <div class="container mt-auto">
        <div class="row ">
            <h1 class="text-center text-primary">15 Data Gempa Terkini di atas 5.0 M</h1>

            <table class="table table-striped">



                <tr>
                    <td>No</td>
                    <td>Tanggal</td>
                    <td>Jam</td>
                    <td>Wilayah</td>
                    <td>Magnitudo</td>
                </tr>

                <?php $i = 1;
                foreach ($detail as $data => $key) { ?>
                    <tr>
                        <td> <?= $i ?> </td>
                        <td><?= $key["Tanggal"];  ?></td>
                        <td><?= $key["Jam"]; ?></td>
                        <td><?= $key["Wilayah"]; ?></td>
                        <td><?= $key["Magnitude"]; ?></td>
                    </tr>

                <?php
                    $i++;
                }

                ?>
            </table>


        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Timeline</h6>
                        <div id="content">
                            <ul class="timeline">

                                <?php foreach ($detail as $data => $key) { ?>
                                    <li class="event" data-date="<?= $key["Tanggal"]; ?>">
                                        <h3><?= $key["Jam"]; ?></h3>
                                        <p>Wilayah : <b><i><?= $key["Wilayah"]; ?></i></b></p>
                                        <p>Kekuatan :<b><?= $key["Magnitude"]; ?></b><br>
                                            Potensi :<b><?= $key["Potensi"]; ?></b><br>
                                            Koordinat : <b><?= $key["Coordinates"]; ?></b><br>
                                            Kedalaman : <b><?= $key["Kedalaman"]; ?></b><br>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <script src="js/chart.js"></script>
                <div id="chart_div" style="width: 100%; height: 500px"></div>
                <div id="chart_div2" style="width: 100%; height: 500px"></div>

            </div>
        </div>
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.6.1.min.js"></script>



    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                // Di sini lah datanya    
                ['Tanggal', 'Kekuatan'],
                <?php foreach ($detail as $data => $key) { ?>['<?= $key["Tanggal"]; ?>', <?= $key["Magnitude"]; ?>],

                <?php } ?>
                // Mulai dari sini  
                /*  
                ['2013',  1000],
                  ['2014',  1170],
                  ['2015',  660,],
                  ['2016',  1030]
                */

            ]);

            var options = {
                title: 'Data Gempa Terkini',
                hAxis: {
                    title: 'Tanggal / Waktu',
                    titleTextStyle: {
                        color: '#f0f0f0'
                    }
                },
                vAxis: {
                    minValue: 0
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <script>
        google.charts.load('current', {
            'packages': ['map'],
            // Note: you will need to get a mapsApiKey for your project.
            // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
            'mapsApiKey': 'AIzaSyAAXMUlXr_zZyfExa5J50ky0Yb-jlS7RNI'

        });
        google.charts.setOnLoadCallback(drawMap);

        function drawMap() {
            var data = google.visualization.arrayToDataTable([

                // Mulai dari sini  datanya 
                ['Lat', 'Long', 'Kekuatan Gempa'],

                <?php foreach ($detail as $data => $key) { ?>[<?= $key["Coordinates"]; ?>, 'Kedalaman : <?= $key["Kedalaman"]; ?> |  Kekuatan : <?= $key["Magnitude"]; ?> M'],
                    /*
                [37.4232, -122.0853, 'Work'],
                [37.4289, -122.1697, 'University'],
                [37.6153, -122.3900, 'Airport'],
                [37.4422, -122.1731, 'Shopping']
                        */
                <?php } ?>

            ]);

            var options = {
                showTooltip: true,
                showInfoWindow: true
            };

            var map = new google.visualization.Map(document.getElementById('chart_div2'));

            map.draw(data, options);
        };
    </script>
</body>

</html>