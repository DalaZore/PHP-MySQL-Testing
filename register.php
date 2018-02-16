<?php
session_start();
require_once('func.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['uname']);
	$umail = strip_tags($_POST['umail']);
    $upass = strip_tags($_POST['upass']);
    $ugivename = strip_tags($_POST['ugivename']);
    $usurname = strip_tags($_POST['usurname']);
    $ufirm = strip_tags($_POST['ufirm']);	
	
	if($uname=="")	{
		$error[] = "Please provide a valid Username!";	
	}
	else if($umail=="")	{
		$error[] = "Please provide a Mail-Address!";	
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please provide a valid Mail-Address!';
	}
	else if($upass=="")	{
		$error[] = "Please provide a Password!";
	}
	else if(strlen($upass) < 8){
		$error[] = "Password must be atleast 8 characters";	
    }
    else if($ugivename=="")	{
		$error[] = "Please provide your given Name!";
    }
    else if($usurname=="")	{
		$error[] = "Please provide you Surname!";
    }
    else if($ufirm=="")	{
		$error[] = "Please provide your Company Name!";
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT username, mail FROM customer WHERE username=:uname OR mail=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['username']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($row['mail']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($uname,$umail,$upass,$ugivename,$usurname,$ufirm)){	
					$user->redirect('register.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
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
</head>
<body>


<!-- NAVIGATION BAR -->
	<nav>
        <ul id="nav">
            <li class="home"><a href="#"><img src="img/home.png"></a></li>
            <li><a href="#s1">Requests</a>
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
            <li class="login"><a href="index.php">Log In</a>
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
                        <li><label>Don't have an account yet ? <a href="register.php">Register here.</a></label></li>
                        <li><input type="checkbox" checked="checked" name="remember"> Remember me</li>
                        <li><button type="submit" name="btn-login">LOGIN</button></li> 
                    </form> 
                </ul>
            </li>
                
        </ul>
	</nav>
	<div class="signin-form">
	<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Register Form</h2><hr />
           
            <div class="form-group">
            <input type="text" class="form-control" name="uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            <div class="form-group">
            <input type="email" class="form-control" name="umail" placeholder="Enter Mail Address" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="upass" placeholder="Enter Password" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="ugivename" placeholder="Enter given Name" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="usurname" placeholder="Enter Surname" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="ufirm" placeholder="Enter Company Name" />
            <hr />
            <div class="form-group">
            	<button type="submit" name="btn-signup">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Register
                </button>
            </div>
			<?php
				if(isset($error)){
					foreach($error as $error){
						?>
						<div class="alert alert-danger">
							<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
						</div>
						<?php
					}
				}
				else if(isset($_GET['joined'])){
					?>
					<div class="alert alert-info">
						<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
					</div>
					<?php
				}
			?>
            <br />
        </form>
	</div>
	</div>
</body>
</html>