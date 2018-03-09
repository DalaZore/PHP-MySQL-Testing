<?php

	require_once("session.php");
	
	require_once("func.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM customer WHERE id=:id");
	$stmt->execute(array(":id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['btn-show']))
    {
            try
            {
                $auth_user->redirect('all_offers.php');
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }	
    }
    if(isset($_POST['btn-request']))
    {
    $req_item = strip_tags($_POST['req_item']);
	$req_sub = strip_tags($_POST['req_sub']);
	$req_desc = strip_tags($_POST['req_desc']);
    $req_price = strip_tags($_POST['req_price']);
    $req_quant = strip_tags($_POST['req_quant']);
    $req_date = strip_tags($_POST['req_date']);
    
    if($req_item=="")	{
		$error[] = "Please provide a valid Item!";	
	}
	else if($req_sub=="")	{
		$error[] = "Please provide a valid Subject!";	
	}
	else if($req_desc=="")	{
		$error[] = "Please provide a valid Description!";	
	}
	else if($req_price=="")	{
		$error[] = "Please provide a Price!";
	}
    else if($req_quant=="")	{
		$error[] = "Please provide a Quantity!";
    }
    else if($req_date=="")	{
		$error[] = "Please provide a valid Date!";
    }
	else
	{
		try
		{
                       
            if($auth_user->request($user_id,$req_item,$req_sub,$req_desc,$req_date,$req_price,$req_quant)){	
                $auth_user->redirect('request.php?posted');
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
    <link rel="icon" href="img/favicon.ico">	    
    <!-- Titel Declaration -->
    <title>WebShop</title>
    <!-- Stylesheet Firefox, Chrome, Safari, Opera -->
    <link rel="stylesheet" type="text/css" href="css/default.css" />    
</head>

<body> 
    <!-- NAVIGATION BAR -->
    <nav>
        <ul id="nav">
            <li class="home"><a href="home.php"><img src="img/home.png"></a></li>
            <li><a href="#s1">Menu</a>
                <span id="s1"></span>
                <ul class="subs">
                    <li><a href="request.php">Post a new Request</a>
                    </li>
                    <li><a href="search.php">Search for Requests</a>
                        <ul>
                            <li><a href="all_requests.php">Show all requests</a></li>
                            <li><a href="home.php">View your own Requests</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="login"><a href="#6"><?php print($userRow['username']); ?></a>
            <span id="s6"></span>
                <ul class="subs">
                    <li><a href="logout.php?logout=true">logoff</a>
                        <ul>

                        </ul>
                    </li>
                </ul>
            </li>
                
        </ul>
        
    </nav>
    <div class="form-group">
	<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Request Form</h2><hr />
           
            <div class="form-group">
                <input type="text" class="form-control" name="req_item" placeholder="Enter an Item" value="<?php if(isset($error)){echo $req_item;}?>" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="req_sub" placeholder="Enter a Subject" value="<?php if(isset($error)){echo $req_sub;}?>" />
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="req_price" placeholder="Enter a Price" value="<?php if(isset($error)){echo $req_price;}?>" />
            </div>
            <div class="form-group">
            	<input type="number" class="form-control" name="req_quant" placeholder="Enter the Quantity" value="<?php if(isset($error)){echo $req_quant;}?>" />
            </div>
            <div class="form-group">
            	<input type="date" class="form-control" name="req_date" placeholder="" value="<?php if(isset($error)){echo $req_date;}?>" />
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" name="req_desc" id="comment" placeholder="Enter a description" value="<?php if(isset($error)){echo $req_desc;}?>"></textarea>
            </div> 
            <hr />
            <div class="form-group">
            	<button type="submit" name="btn-request">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;Post Request
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
				else if(isset($_GET['posted'])){
					?>
					<div class="alert alert-info">
						<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully submitted the Request!
					</div>
					<?php
				}
			?>
            <br />
        </form>
	</div>
    </div>
    <footer>
        <p>© 2018 Copyright</p>
</footer>
</body>


</html>
