<?php
session_start();
require_once("func.php");
$login = new USER();

if($login->is_loggedin()!="")
{
	$login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$uname = strip_tags($_POST['username']);
	$umail = strip_tags($_POST['username']);
	$upass = strip_tags($_POST['password']);
		
	if($login->doLogin($uname,$umail,$upass))
	{
		$login->redirect('home.php');
	}
	else
	{
		$error = "Wrong Details !";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
    
    <!--
		*********************************
        * Created by Luca Colagiorgio   *
        * and Remo Steinmann            *
        * as part of an Assignement     *
        *********************************
	-->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Stylesheets-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
    <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
    <!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
    <link rel="apple-touch-icon-precomposed" href="img/mobile_favicon.png">
    <!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
    <link rel="icon" href="img/favicon.png">	    
    <!-- Titel Declaration -->
    <title>WebShop</title>
    <!-- Stylesheet Firefox, Chrome, Safari, Opera -->
    <link rel="stylesheet" type="text/css" href="css/default.css" />    
    <!-- Stylesheet IE -->
    <link rel="stylesheet" type="text/css" href="IEsucks.css" />
</head>

<body> 
    <!-- NAVIGATION BAR -->
    <nav>
        <ul id="nav">
            <li class="home"><a href="#"><img src="img/home.png"></a></li>
            <li><a href="#s1">Menu 1</a>
                <span id="s1"></span>
                <ul class="subs">
                    <li><a href="#">Header a</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Header b</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#s2">Menu 2</a>
                <span id="s2"></span>
                <ul class="subs">
                    <li><a href="#">Header c</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Header d</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#s3">Menu 3</a>
                <span id="s3"></span>
                <ul class="subs">
                    <li><a href="#">Header c</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Header d</a>
                        <ul>
                            <li><a href="#">Submenu x</a></li>
                            <li><a href="#">Submenu y</a></li>
                            <li><a href="#">Submenu z</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
                
            <li><a href="#">Menu 4</a></li>
            <li><a href="#">Menu 5</a></li>
            <li class="login"><a href="#s6">Log In</a>
                <span id="s6"></span>
                <ul class="subs">
                    <form action="" method="post">
                        <li><p>Username</p>
                            <ul>
                                <input name="username" type="text" placeholder="Username">
                                
                            </ul>
                        </li>
                        <li><p>Password</p>
                            <ul>
                                <input name="password" type="password" placeholder="Password">
                            </ul>
                        </li>
                        <li><a href="#">Forgot Password</a></li>
                        <li><button type="submit" name="btn-login">LOGIN</button></li>
                        <li>
                            <?php
                                if(isset($error))
                                {
                                    ?>
                                    <div class="alert alert-danger">
                                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                                    </div>
                                    <?php
                                }
                            ?>
                        </li> 
                    </form> 
                </ul>
            </li>
                
        </ul>
        
    </nav>
    <div class="signin-form">

	<div class="container">  
        <form class="form-signin" method="post" id="login-form">
            <h2 class="form-signin-heading">Log In to WebApp.</h2><hr />
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username or Mail Address" required />
                <span id="check-e"></span>
            </div>      
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Your Password" />
            </div>      
            <hr />
           
            <div class="form-group">
                <button type="submit" name="btn-login">
                        <i class="glyphicon glyphicon-log-in"></i> &nbsp; Log In
                </button>
            </div> 
            <div id="error">
                <?php
                    if(isset($error))
                    {
                        ?>
                        <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
                    }
                ?>
            </div> 
            <br />
                <label>Don't have account yet ? <a href="register.php">Register here.</a></label>
        </form>

    </div>
    
</div>
</body>

</html>
