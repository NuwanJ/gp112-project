
<?php
ini_set('error_log', 'log/error.log');
error_reporting(E_ERROR);
ini_set('display_errors', 1);

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

        for ($h = 0; $h < $hComp; $h++) {
            $a = cosComponent($xt, $h + 1, $w, $i - $s1, $ts);
            $b = sinComponent($xt, $h + 1, $w, $i - $s1, $ts);

            $Z_xcos[$h] += $a;
            $Z_xsin[$h] += $b;
        }
    }

    for ($h = 0; $h < $hComp; $h++) {
        $hh = $h + 1;

        $a = $Z_xcos[$h] * $ts * 2 / $T;
        $b = $Z_xsin[$h] * $ts * 2 / $T;
        $v = sqrt($a * $a + $b * $b);
        $phi = atan($b / $a);

        $amplitude[$h] = $v;
        $phase[$h] = $phi;

        //echo "<tr><td>$hh</td> <td>$a</td> <td>$b</td> <td>$v</td> <td>$phi</td></tr>";
    }


    //table_harmonic(10, $amplitude, $phase);

    //echo "<h3>Amplitude components</h3>";
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

    if (file_exists("../data/e15$eNumber.txt")) {

        $file = fopen("../data/e15$eNumber.txt", "r");

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