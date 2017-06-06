<?php
session_start();

include_once '../data/database.php';

$login = true;
/*if ((isset($_SESSION['user'])) && (GetLoginSessionVar() != $_SESSION['user'])) {
    $login = true;
} else {
    $login = false;
    header("location: ../login/");
}
*/
$userName = $_SESSION['user'];

function GetLoginSessionVar()
{
    $rand_key = "0iQx5oBk66oVZep";
    $retvar = md5($rand_key);
    $retvar = 'usr_' . substr($retvar, 0, 10);
    return $retvar;
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Who is Speaking ?</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../css/index.css" rel="stylesheet"/>
    <link href="../css/font-awesome.min.css" rel="stylesheet"/>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/index.js"></script>
    <script src="../js/cr.js"></script>

    <link rel="shortcut icon" href="../img/fav.ico">
</head>


<body>

<a name="top"></a>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="http://apps.ceykod.com/">
                <div class="navbar-brand" id="page-title">Who is Speaking ?</div>
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!--<div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right <?php /*if (!$login) echo "hidden";*/ ?>">
                <li><a href="../messages/"><i class="nav-ico fa fa-envelope-o"></i></a></li>
                <li><a href="../settings/"><i class="nav-ico fa fa-cog"></i></a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php /*echo $userName; */?><span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right <?php /*if ($login) echo "hidden"; */?>">
                <li><a href="../login/"><i class="nav-ico fa fa-sign-in"></i>Login<span></span></a>
                </li>
            </ul>
        </div>-->
    </div>


</nav>