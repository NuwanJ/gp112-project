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

            <h1> Who is Speaking
                <small>Web Calculator</small>
            </h1>

            <br><br><br>

            <form class="form-horizontal" role="form" method="get" action="view.php">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="enum">E/15/xxx</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="enum" id="enum" placeholder="xxx"
                               value="140">
                    </div>
                </div>

                <div class="hidden">
                    <div class="form-group">
                        <h3>Select your cycle here :</h3>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="s1">Starting row</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="s1" id="s1" placeholder="" value="87">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="s2">Ending row</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="s2" id="s2" placeholder="" value="176">
                        </div>
                    </div>


                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>

        </div>

        <br><br><br>
    </div>
</div>


<?php include_once '../data/footer.php'; ?>

</body>
</html>