<?php

require_once('dbconnect.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($uname,$umail,$upass,$ugivename,$usurname)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO customer(username,mail,pass,Name,Surname) 
		                                               VALUES(:uname, :umail, :upass, :ugivename, :usurname)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);
			$stmt->bindparam(":ugivename", $ugivename);
			$stmt->bindparam(":usurname", $usurname);								  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	public function search($search)
	{
		try
		{	
			$_SESSION['search_term'] = $search;
			$stmt = $this->conn->prepare("SELECT * FROM requests WHERE item LIKE :search");
			
			$stmt->bindValue(":search","%".$search."%");
							  
				
			$stmt->execute();	

            return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	public function request($user_id,$req_item,$req_sub,$req_desc,$req_date,$req_price,$req_quant)
	{
		try
		{		
			$stmt = $this->conn->prepare("INSERT INTO requests(c_id,item,subject,descr,Date,price,quantity) 
		                                               VALUES(:id, :req_item, :req_sub, :req_desc, :req_date, :req_price, :req_quant)");
			
			$stmt->bindparam(":id", $user_id);
			$stmt->bindparam(":req_item", $req_item);
			$stmt->bindparam(":req_sub", $req_sub);
			$stmt->bindparam(":req_desc", $req_desc);
			$stmt->bindparam(":req_price", $req_price);
			$stmt->bindparam(":req_quant", $req_quant);	
			$stmt->bindparam(":req_date", $req_date);								  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

	public function accept($offer_id,$price,$quantity)
	{
		try
		{		
			$stmt = $this->conn->prepare("UPDATE offers SET accepted='Yes' WHERE id=$offer_id");
			$stmt->execute();

			$myfile = fopen("./offerxml/Offer_ID_'$offer_id'.xml", "w");
			$txt = '<?xml version="1.0" encoding="ISO-8859-1"?><order>';
			$txt .= "<offerid>$offer_id</offerid><price>$price</price><quantity>$quantity</quantity>";
			$txt .= "</order>";
			fwrite($myfile, $txt);
			fclose($myfile);			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

	public function offer($user_id,$off_rid,$off_price,$off_quant)
	{
		try
		{	

			$stmt = $this->conn->prepare("INSERT INTO offers(c_id,r_id,price,quantity) 
		                                               VALUES(:id, :off_rid, :off_price, :off_quant)");
			
			$stmt->bindparam(":id", $user_id);
			$stmt->bindparam(":off_rid", $off_rid);
			$stmt->bindparam(":off_price", $off_price);
			$stmt->bindparam(":off_quant", $off_quant);							  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT id, username, mail, pass FROM customer WHERE username=:uname OR mail=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($upass, $userRow['pass']))
				{
					$_SESSION['user_session'] = $userRow['id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>