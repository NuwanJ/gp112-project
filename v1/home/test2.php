<?php
ini_set('error_log', 'log/error.log');
error_reporting(E_ERROR);
ini_set('display_errors', 1);

//calculate(140, 3, 91, 1);

$eNum = 140;
$s1 = 3;
$s2 = 91;
$print = 1;

$fs = 10000;
$ts = 1 / $fs;

$T = ($s2 - $s1) * $ts;
$w = round(2 * pi() / $T, 2);

$c = $s2 - $s1;

$Z_xsin = array();
$Z_xcos = array();
$amplitude = array();
$phase = array();

$h = 0;
$hComp = 50;

if ($print == 1) echo "fs = $fs <br> ts = $ts <br> s1 = $s1 <br> s2 = $s2 <br><br> T = $T <br> w = $w ";

//Read input file
$input = readMyFile($eNum);


for ($i = $s1; $i <= $s2; $i++) {

    $xt = $input[$i];
    //echo "$xt ";

    for ($h = 0; $h < $hComp; $h++) {
        $a = cosComponent($xt, $h + 1, $w, $i - $s1, $ts);
        $b = sinComponent($xt, $h + 1, $w, $i - $s1, $ts);

        if (($i == $s1) || ($i == $s2 - 1)) {
            $Z_xcos[$h] += $a;
            $Z_xsin[$h] += $b;

        } else {
            $Z_xcos[$h] += 2 * $a;
            $Z_xsin[$h] += 2 * $b;
        }

    }
}


for ($h = 0; $h < $hComp; $h++) {
    $hh = $h + 1;

    $a = $Z_xcos[$h] / (2 * $c);
    $b = $Z_xsin[$h] / (2 * $c);

    $v = sqrt($a * $a + $b * $b);
    $phi = atan($b / $a);

    $amplitude[$h] = $v;
    $phase[$h] = $phi;

    //echo "<tr><td>$hh</td> <td>$a</td> <td>$b</td> <td>$v</td> <td>$phi</td></tr>";
}


table_harmonic($hComp, $amplitude, $phase);

echo "<h3>Amplitude components</h3>";

for ($i = 0; $i < $h; $i++) {
    echo "$amplitude[$i]<br>";
}

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

    //echo "<tr><td>$i</td> <td>$tt</td> <td>$in[$i]</td> <td>$out[$i]</td> <td>$def[$i]</td> <td>$ratio[$i]</td></tr>";
}

?>

    <div id="chartContainer" style="height: 400px; width: 100%;"></div>


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



<?php
function calculate($eNum, $s1, $s2, $print)
{

    $fs = 10000;
    $ts = 1 / $fs;

    $T = ($s2 - $s1) * $ts;
    $w = round(2 * pi() / $T, 2);

    $c = $s2 - $s1;

    $Z_xsin = array();
    $Z_xcos = array();
    $amplitude = array();
    $phase = array();

    $h = 0;
    $hComp = 10;

    if ($print == 1) echo "fs = $fs <br> ts = $ts <br> s1 = $s1 <br> s2 = $s2 <br><br> T = $T <br> w = $w ";

    //Read input file
    $input = readMyFile($eNum);


    for ($i = $s1; $i <= $s2; $i++) {

        $xt = $input[$i];
        //echo "$xt ";

        for ($h = 0; $h < $hComp; $h++) {
            $a = cosComponent($xt, $h + 1, $w, $i - $s1, $ts);
            $b = sinComponent($xt, $h + 1, $w, $i - $s1, $ts);

            if (($i == $s1) || ($i == $s2 - 1)) {
                $Z_xcos[$h] += $a;
                $Z_xsin[$h] += $b;

            } else {
                $Z_xcos[$h] += 2 * $a;
                $Z_xsin[$h] += 2 * $b;
            }

        }
    }


    for ($h = 0; $h < $hComp; $h++) {
        $hh = $h + 1;

        $a = $Z_xcos[$h] / (2 * $c);
        $b = $Z_xsin[$h] / (2 * $c);

        $v = sqrt($a * $a + $b * $b);
        $phi = atan($b / $a);

        $amplitude[$h] = $v;
        $phase[$h] = $phi;

        echo "<tr><td>$hh</td> <td>$a</td> <td>$b</td> <td>$v</td> <td>$phi</td></tr>";
    }


    table_harmonic(10, $amplitude, $phase);

    echo "<h3>Amplitude components</h3>";

    for ($i = 0; $i < $h; $i++) {
        echo "$amplitude[$i]<br>";
    }

}


function table_harmonic($h, $amplitude, $phase)
{

    echo "<br><br><table class='table'>";
    echo "<tr> <th>Harmonic</th> <th>Amplitude</th> <th>Phase (rad)</th> <th>Phase (deg)</th></tr>";

    for ($i = 0; $i < $h; $i++) {
        $hh = $i + 1;
        $phase_deg = 180 * $phase[$i];
        echo "<tr> <td>$hh</td> <td>$amplitude[$i]</td> <td>$phase[$i]</td> <td>$phase_deg</td></tr>";
    }

    echo "</table><br><br>";
}


function cosComponent($xt, $h, $w, $t, $ts)
{
    return $xt * cos($h * $w * $t * $ts);
}

function sinComponent($xt, $h, $w, $t, $ts)
{
    return $xt * sin($h * $w * $t * $ts);
}

function readMyFile($eNum)
{

    $input = array();
    $k = 1;

    $eNumber = strtolower(str_replace("/", "", $eNum));

    if (file_exists("../data/e15$eNum.txt")) {

        $file = fopen("../data/e15$eNum.txt", "r");

        //echo "<div style='display:none;'><table class='table' border='1'>";

        while (!feof($file)) {
            $input[$k] = fgets($file);
            $k++;
            //echo "<tr><td>$k</td> <td>$input[$k]</td></tr>";
        }
        //echo "</table></div>";

        fclose($file);
    }
    return $input;

}


?>