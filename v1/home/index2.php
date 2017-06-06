<?php


include_once '../data/header.php';
include_once 'test.php';

?>
<div class="container-fluid main-content">

    <br><br><br><br>

    <div class="row main-content">
        <div class="col-xs-10 col-sm-8 col-xs-offset-1 col-sm-offset-2">
            <br><br>

            <h1>Amplitude components for E/15/<?php echo $_GET['enum'] ?></h1>
            <br><br>

            <table class="table">
                <tr>
                    <?

                    $data = array(
                        135 => array(78, 156, 235, 313, 392, 471, 550),
                        136 => array(73, 148, 225, 301, 377, 453, 529),
                        137 => array(88, 172, 256, 340, 429, 509, 593),
                        138 => array(66, 134, 203, 272, 340, 407, 474),
                        139 => array(43, 85, 128, 170, 213, 255, 298),
                        140 => array(3, 92, 180, 268, 356, 443, 530));

                    for ($j = 0; $j < 6; $j++) {

                        $s = $data[$_GET['enum']];
                        $k = $j + 1;
                        $s1 = $s[$j];
                        $s2 = $s[$k] - 1;
                        //echo "<h1>Cycle $k : $s1 - $s2</h1>";
                        echo "<td><h4>$k : $s1 - $s2</h4>";
                        calculate($_GET['enum'], $s1, $s2, 0);
                        //echo "<hr>";

                        echo "</td>";

                    }

                    ?>

                </tr>
            </table>


            <br><br><br>

            <!--<div id="chartContainer" style="height: 400px; width: 100%;"></div>-->
            <br><br><br>


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