<?php

ini_set('error_log', 'log/error.log');
error_reporting(E_ERROR);
ini_set('display_errors', 1);

include_once '../data/header.php';
?>
<div class="container-fluid main-content">

    <br><br><br><br>

    <div class="row main-content">
        <div class="col-xs-10 col-sm-8 col-xs-offset-1 col-sm-offset-2">
            <br><br><br><br>
            <?php
            $eNum = $_GET['enum'];

            if(($eNum<135)||($eNum>140)){
                echo "<script>alert('That E number currently not available')</script>";
                echo "<script>history.go(-1)</script>";
                exit;
            }

            echo "<h1>Results for E/15$eNum</h1>";
            echo " <a href='plot.php?enum=$eNum'>Plot Values</a><br>";
            echo " <a href='index2.php?enum=$eNum'>Calculate Harmonic components</a>";

            ?>


            <br><br><br>
        </div>

        <br><br><br>
    </div>
</div>


<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Input vs Generated Output",
                fontSize: 30
            },
            animationEnabled: true,
            axisX: {
                gridColor: "Silver",
                tickColor: "silver",
                valueFormatString: ""
            },
            toolTip: {
                shared: true
            },
            theme: "theme2",
            axisY: {
                gridColor: "Silver",
                tickColor: "silver"
            },
            legend: {
                verticalAlign: "center",
                horizontalAlign: "right"
            },
            data: [
                {
                    type: "line",
                    showInLegend: true,
                    lineThickness: 2,
                    name: "Input",
                    markerType: "square",
                    color: "#F08080",
                    dataPoints: [
                        <?php
                          for ($i = 0; $i < $c; $i++) {
                             $tt = $ts*$i;
                             $n = $input[($i+ $s1)];
                             echo "{x: $tt, y: $n}";

                             if($i!= ($c-1))echo ",";
                         }

                         ?>
                    ]
                },
                {
                    type: "line",
                    showInLegend: true,
                    name: "Output",
                    color: "#20B2AA",
                    lineThickness: 2,

                    dataPoints: [
                        <?php
                         for ($i = 0; $i < $c; $i++) {
                            $tt = $ts*$i;
                            $n = $out[$i];
                            echo "{x: $tt, y: $n}";

                            if($i!= ($c-1))echo ",";
                        }

                        ?>
                    ]
                }
            ],
            legend: {
                cursor: "pointer",
                itemclick: function (e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    }
                    else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }
            }
        });

        chart.render();


    }
</script>
<script src="../js/canvasjs.min.js"></script>

<?php include_once '../data/footer.php'; ?>

</body>
</html>