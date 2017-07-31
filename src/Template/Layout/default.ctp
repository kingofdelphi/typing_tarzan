<!DOCTYPE html>
<?php 
$session = $this->request->session(); 
$loggedin = $session->check('user');
$v = ['none', 'initial'];
$in = 'display:' . $v[!$loggedin];
$out = 'display:' . $v[$loggedin];
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Typing Tarzan</title>

        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/new.css" rel="stylesheet">

        <script src="/js/jquery.js"></script>

    </head>

    <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Typing Tarzan</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                        <li><a id='about' href='#about'>About</a></li>
                        <li><a id='feedback' href='#feedback'>Feedback</a></li>
<!--
                        <li><a href="#contact">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
--!>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li style='<?php echo $in;?>'><a href="/signup"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li style='<?php echo $in;?>'><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li style='<?php echo $out;?>'><a href="/logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <!--<div class="page-header">
                <h1>You can select a user you want to join with</h1>
                </div> --!>
                <div class='row'>
                    <?php if ($loggedin) { ?>
                        <div class='col-sm-9'>
                            <?= $this->fetch('content') ?>
                        </div>
                        <div class='col-sm-3'>
                            <div class='form-group' style='position:fixed'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <pre class='form-control'>Chatbox</pre>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <textarea id='msghistory' readonly style='resize:none' class='form-control' rows='20'></textarea>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-8'>
                                    <input id='umsg' type='text' class='form-control'>
                                </div>
                                <div class='col-sm-4' style='height:100%;margin-bottom:0'>
                                    <button id='message_send' class='form-control'>Send</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class='col-sm-12'>
                            <?= $this->fetch('content') ?>
                        </div>
                    <?php } ?>
                </div>
        </div>
        <footer class="footer" style='background-color:black;color:white'>
            <div class="container">
                <p class="text-muted">Copyright(c) Vector Softs 2016</p>
            </div>
        </footer>
        <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="/js/bootstrap.min.js"></script>
            <script>
$("body").on('click', '#about' ,function() {
    $("#ab_modal").css('opacity', 0);
    $("#ab_modal").css('display', 'flex');
    $("#ab_modal").animate({opacity: 0.75}, 1000, 
            function() {
                $("#modal_cont").css('background-color',
                        "rgba(0, 0, 0, 1)");
            }
            );
}
);
$('body').on('click', "#ab_modal", function() {
    $("#ab_modal").animate({ opacity: 0}, 1000, 
            function() { 
                $("#ab_modal").css('display', 'none');
            }
            );
}
);
            </script>
    </body>
    <div id='ab_modal' class='modal'>
        <div id='modal_cont' class='modal-content'>
            <h2 style='text-align:center'>About Myself</h1>
            <h4 style='text-align:justify'>It's hard to choose a favorite among so many great tracks, but "The Greatest Love of All" is one of the best, most powerful songs ever written about self-preservation, dignity. Its universal message crosses all boundaries and instills one with the hope that it's not too late to better ourselves. Since, it's impossible in this world we live in to empathize with others, we can always empathize with ourselves. It's an important message, crucial really. And it's beautifully stated on the album.</h4>
        </div>
    </div>
</html>

