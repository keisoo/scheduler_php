<?php
  session::init();
?>
<!DOCTYPE html>
<html>
<head>
    <title>IRTC</title>
    <link rel="stylesheet" href="<?= URL?>public/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= URL?>public/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= URL?>public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?=URL?>public/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?=URL?>public/css/hover.css">
   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= URL?>public/js/jquery.js"></script>
    <?php 
        if(isset($this->js)){ 
            foreach($this->js as $js){
                echo '<script src = "' . URL . 'views/' . $js . '"></script>';
            }
        }
    ?>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>

</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img class="pull-left" src="<?= URL?>public/images/tup.png" style="width: 45px; margin-top: 5px; margin-bottom: 5px; min-height: 10px; min-width: 10px;" />
                <a id="brandNameLarge" class="navbar-brand" href="<?= URL?>" style="font-family: calibri">&nbsp; INFORMATION AND RESEARCH TRAINING CENTER</a>
                <a id="brandNameSmall" class="navbar-brand" href="<?= URL?>" style="font-family: calibri">&nbsp; IRTC</a>
            </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                <ul class="nav navbar-nav navbar-right" style="margin-right:1px;">
                    <?= (session::get('type')==1?'<li><a href="'.URL.'administrator" data-toggle="tooltip" data-bar="administrator" title="Admin" data-placement="bottom"><i class="fa fa-user-secret fa-2x"></i></a></li>':'') ?>
                    <li><a class="hvr-pulse" href="<?= URL?>home" data-toggle="tooltip" data-bar="home" title="Home" data-placement="bottom"><i class="fa fa-home fa-2x "></i></a></li>
                    <li><a href="#" class="hvr-pulse" data-placement="bottom" id="popover"><i class="fa fa-search fa-2x"></i></a></li>
                    <li data-toggle="modal" data-target="#myModal"><a href="#" class="red-tooltip hvr-pulse" data-toggle="tooltip" title="Add" data-placement="bottom"><i class="fa fa-plus-circle fa-2x"></i></a></li>
                    <li><a href="<?= URL?>listview" class="red-tooltip hvr-pulse" data-bar="view" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fa fa-list-ul fa-2x"></i></a></li>
                    <li ><a id="logout" class="red-tooltip hvr-pulse" data-toggle="tooltip" title="Logout" data-placement="bottom"><i class="fa fa-sign-out fa-2x"></i></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

<!--search-->
    <div id="popover-head" class="hide">Search Event</div>
    <div id="popover-content" class="hide">
      <form class="form-inline" method = "POST" action="<?= URL?>listview/search">
        <div class="form-group">
            <select class="form-control" style="width: 196px; margin-bottom: 5px;" name="select">
                <option value="title" selected>Title</option>
                <option value="College">College</option>
                <option value="organizer">Organizer</option>
            </select>
            <input class="form-control" type="text" placeholder="Search" name="searchField" /> <!-- $_POST['searchField']--> 
        </div>
        <input style="margin-top: 10px;" class="btn btn-default" type="submit" />
      </form>
    </div>