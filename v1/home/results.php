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
            <?
            $input = array();
            $k = 1;

            $eNumber = strtolower(str_replace("/", "", $_GET['enum']));

            $file = fopen("../data/$eNumber.txt", "r");

            echo "<div style='display:none;'><table class='table' border='1'>";

            while (!feof($file)) {
                $input[$k] = fgets($file);
                echo "<tr><td>$k</td> <td>$input[$k]</td></tr>";
                $k++;

            }
            echo "</table></div>";

            fclose($file);

            $fs = 10000;
            $ts = 1 / $fs;

            $s1 = $_GET['s1'];
            $s2 = $_GET['s2'];

            $T = ($s2 - $s1) * $ts;
            $w = round(2 * pi() / $T, 2);

            $c = $s2 - $s1;

            $xsin = array();
            $xcos = array();
            $amplitude = array();
            $phase = array();

            $h = 0;
            $hComp = 10;

            echo "fs = $fs <br> ts = $ts <br> s1 = $s1 <br> s2 = $s2 <br><br> T = $T <br> w = $w ";


            echo "<br><br><br><br>";

            ?>
            <button class="btn btn-default" data-toggle="collapse" data-target="#rawData">Show Calculation Table
            </button>

            <div id="rawData" class="collapse">
                <br><br>
                <?php
                echo "<table  class='table'>";

                echo "<tr><td>t</td> <td>x(t)</td> <td>x(t)*cos(h*w*t)</td> <td>x(t)*sin(h*w*t)</td> </tr>";

                for ($i = $s1; $i <= $s2; $i++) {

                    echo "<tr>";

                    $xt = $input[$i];

                    echo "<td>" . $ts * ($i - $s1) . "</td>";
                    echo "<td>$xt</td>";

                    for ($h = 0; $h < $hComp; $h++) {
                        $a = $xt * cos(($h + 1) * $w * ($i - $s1) * $ts);
                        $b = $xt * sin(($h + 1) * $w * ($i - $s1) * $ts);

                        $xcos[$h] += $a;
                        $xsin[$h] += $b;

                        echo "<td>$a</td>";
                        echo "<td>$b</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

                ?>
            </div>

            <br><br>
            <table class="table">
                <tr>
                    <th>h</th>
                    <th>SUM ( x(t)*cos(h*w*t) )</th>
                    <th>SUM ( x(t)*sin(h*w*t) )</th>
                    <th>V</th>
                    <th>phi (rad)</th>
                </tr>


                <?php
                for ($h = 0; $h < $hComp; $h++) {
                    $hh  = $h+1;
                    $a = $xcos[$h] * $ts * 2 / $T;
                    $b = $xsin[$h] * $ts * 2 / $T;
                    $v = sqrt($a * $a + $b * $b);
                    $phi = atan($b / $a);

                    $amplitude[$h] = $v;
                    $phase[$h] = $phi;

                    echo "<tr><td>$hh</td> <td>$a</td> <td>$b</td> <td>$v</td> <td>$phi</td></tr>";
                }
                ?>
            </table>

            <br><br><br>

            <h2>V1 to V10 for current cycle :</h2>
            <?php

            for ($h = 0; $h < $hComp; $h++) {
                echo "$amplitude[$h]</br>";
            }

            ?>

            <br><br><br>

            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
            <br><br><br>

            <table class="table">
                <tr>
                    <th>N</th>
                    <th>t</th>
                    <th>Orig</th>
                    <th>Gen</th>
                    <th>Diff</th>
                    <th>Ratio</th>
                </tr>
                <?php

                $out = array();
                for ($i = 0; $i < $c; $i++) {

                    $val = 0;
                    $tt = $ts * $i;

                    for ($h = 0; $h < $hComp; $h++) {
                        $val += $amplitude[$h] * cos((($h + 1) * $w * $tt) + $phase[$h]);
                    }

                    $out[$i] = $val;
                    $in[$i] = $input[($i + $s1)];
                    $def[$i] = $in[$i] - $out[$i];
                    $ratio[$i] = $out[$i] - $in[$i];

                    echo "<tr><td>$i</td> <td>$tt</td> <td>$in[$i]</td> <td>$out[$i]</td> <td>$def[$i]</td> <td>$ratio[$i]</td></tr>";
                }


                ?>
            </table>


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