<?php

ini_set('error_log', 'log/error.log');
error_reporting(E_ERROR);
ini_set('display_errors', 1);

include_once '../data/header.php';

?>

<script src="../js/canvasjs.min.js"></script>

<div class="container-fluid main-content">

    <br><br><br><br>

    <div class="row main-content">
        <div class="col-xs-10 col-sm-8 col-xs-offset-1 col-sm-offset-2">
            <?
            $input = array();
            $input[0] = 0;
            $k = 1;

            $eNumber = strtolower(str_replace("/", "", $_GET['enum']));

            $file = fopen("../data/e15$eNumber.txt", "r");

            echo "<div style='display:none;'><table class='table' border='1'>";

            while (!feof($file)) {
                $input[$k] = fgets($file);
                echo "<tr><td>$k</td> <td>$input[$k]</td></tr>";
                $k++;

            }
            echo "</table></div>";

            fclose($file);

            ?>

            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
            <br><br><br>

        </div>

        <br><br><br>
    </div>
</div>


<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Inputs : <?php echo $eNumber;?>"
            },
            axisX: {
                valueFormatString: ""
            },
            data: [{
                type: "line",
                dataPoints: [
                    <?php
                         for ($i = 0; $i < $k; $i++) {
                            $tt = $i;
                            $n = $input[$i];
                            if($n=="") $n=0;

                            print "{x: $tt, y: $n}";

                            if($i!= ($k-1)){
                                print ",";
                            }
                        }

                        ?>
                ]
            }]
        });
        chart.render();
    }
</script>


<?php include_once '../data/footer.php'; ?>

</body>
</html>