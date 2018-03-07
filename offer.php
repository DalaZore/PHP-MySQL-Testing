<?php

	require_once("session.php");
	
	require_once("func.php");
	$auth_user = new USER();
	$user_req = new USER();
	$user_id = $_SESSION['user_session'];
    
	$stmt = $auth_user->runQuery("SELECT * FROM customer WHERE id=:id");
	$stmt->execute(array(":id"=>$user_id));
	
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['offer_id']))
    {
        $_SESSION['off_rid'] = $_POST['offer_id'];
        $_SESSION['offer_item'] = $_POST['offer_item'];
    }

    if(isset($_POST['btn-createoffer']))
    {
        $off_rid = strip_tags($_SESSION['off_rid']);
        $off_price = strip_tags($_POST['off_price']);
        $off_quant = strip_tags($_POST['off_quant']);
        
        if($off_price=="")	{
            $error[] = "Please provide a valid Price!";	
        }
        else if($off_quant=="")	{
            $error[] = "Please provide a valid Quantity!";	
        }
        else
        {
            try
            {
                        
                if($auth_user->offer($user_id,$off_rid,$off_price,$off_quant)){	
                    $auth_user->redirect('offer.php?posted');
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

    <div class="signin-form">
	<div class="container">
        <h2 class="form-signin-heading">Create Offer for Request ID <?php echo $_SESSION['off_rid']; ?></h2><hr />
        <form method="post" class="form-signin">  
            <input type="hidden" class="form-control" name="off_rid" value="<?php echo htmlspecialchars($_SESSION['off_rid']); ?>"/> <br />         
            <div class="form-group">
                <label>Requested Item</label>
                <input type="text" class="form-control" name="off_item" placeholder="<?php echo htmlspecialchars($_SESSION['offer_item']); ?>" value="<?php if(isset($error)){echo htmlspecialchars($_SESSION['offer_item']);}?>" readonly/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="off_price" placeholder="Enter a Price" value="<?php if(isset($error)){echo $off_price;}?>" />
            </div>
            <div class="form-group">
            	<input type="number" class="form-control" name="off_quant" placeholder="Enter the Quantity" value="<?php if(isset($error)){echo $off_quant;}?>" />
            </div>

            <hr />
            <div class="form-group">
            	<button type="submit" name="btn-createoffer">
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
						<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully submitted the Offer!
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