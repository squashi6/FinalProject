<?php

	function databaseConnection()
	{

		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "reweardb";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error)
		{
			return null;
		}
		else
		{
			return $conn;
		}
	}

	function attemptLogin($uName, $uPassword)
	{
		$connection = databaseConnection();

		if ($connection != null)
		{
			$sql = "SELECT * FROM Users WHERE username = '$uName' AND passwrd = '$uPassword'";
			$result = $connection->query($sql);

			if ($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
					$response = array("userId"=>$row["UserId"],"firstname"=>$row["fName"], "lastname"=>$row["lName"], "MESSAGE"=>"SUCCESS");
				}

				$connection->close();
				return $response;
			}
			else
			{
				$connection->close();
				return array("MESSAGE"=>"406");
			}
		}
		else
		{
			return array("MESSAGE"=>"500");
		}

	}
	function createUser($uName, $fName, $lName, $email,  $userPassword,  $country, $gender){
		$connection = databaseConnection();

		if ($connection != null)
		{

		$sql = "INSERT INTO Users(fName, lName, username, email, passwrd, country, gender)
		 VALUES ('$fName', '$lName', '$uName','$email','$userPassword','$country', '$gender')";

		$result = $connection->query($sql);

					if ($result)
					{
						$connection->close();
						return array("MESSAGE"=>"SUCCESS");
					}
					else
					{
						$connection->close();
						return array("MESSAGE"=>"406");
					}

		}
		else{
			return array("MESSAGE"=>"500");
		}
	}


	function loadProfile($uName){
		$connection = databaseConnection();

		if ($connection != null){
				$sql = "SELECT * FROM Users WHERE username = '$uName'";
				$result = $connection->query($sql);

		if($result->num_rows >0){
			while ($row = $result-> fetch_assoc()){
                $response = array("firstname"=>$row["fName"],"lastname"=>$row["lName"],"username"=>$row["uName"],
                "email"=>$row["email"],"country"=>$row["country"],"gender"=>$row["gender"],"MESSAGE"=>"SUCCESS");
            	}
				$connection->close();
			return $response;
		}
		else{
			$connection->close();
			return array("MESSAGE"=>"406");
		}
			}
			else{
				$connection->close();
				return array("MESSAGE"=>"500");
			}


	}


	
	function createOrder($userId, $package, $price){
		$connection = databaseConnection();
		if($connection != null){
			$time = time();
			$sql = "INSERT INTO Orders(userId,package,orderDate,price) values ('$userId','$package', '$time', '$price'); ";
			$result=$connection->query($sql);
			if($result){
					return array("MESSAGE"=>"SUCCESS");
				}
				else{
					return array("MESSAGE"=>"406");
				}
			
		}
		else{
			return array("MESSAGE"=>"500");
		}
	}

	function checkOrder($username){
		$connection = databaseConnection();
		
				if ($connection != null){
						$sql = "SELECT * FROM Users WHERE username = '$username'";
						$result = $connection->query($sql);
						if($result->num_rows >0){
									while ($row = $result-> fetch_assoc()){
										$userId = $row["UserId"];
									}
								}
								
						
						$sql = "SELECT * from Styles where userId = '$userId'";
						$result= $connection->query($sql);
						if($result->num_rows > 0){
							while ($row = $result-> fetch_assoc()){
								$response= array("userId"=>$userId,"size"=>$row["size"],"type"=>$row["type"],"MESSAGE"=> "SUCCESS");
						}
						return $response;
					}
							else{
								return array("MESSAGE"=>"406");
						}
						
					}
					else{
						return array("MESSAGE"=>"500");
					}
		
		
			}
			function loadOrders($userId){
				$connection = databaseConnection();
				
						if ($connection != null){
							$sql = "SELECT * FROM Orders WHERE userId = '$userId'";
							$result= $connection->query($sql);
							$re =array();
							if($result->num_rows > 0){
								while ($row = $result-> fetch_assoc()){
									$response= array("orderId"=>$row["orderId"],"orderDate"=>$row["orderDate"],"package"=>$row["package"],"price"=>$row["price"],"MESSAGE"=>"SUCCESS");
									$re[] = $response;
								}
								$connection->close();
								return $re;
							}
							else{
								$connection->close();
								return array("MESSAGE"=>"406");
							}
							
				

			}
			else{
				return array("MESSAGE"=>"500");
			}
		}
		function saveStyle($userId,$type,$size,$colors,$brands){
			$connection = databaseConnection();
			if($connection != null){
				//Check if styles is already selected
				$sql= "SELECT styleId from Styles WHERE userId = '$userId'";
				$result =$connection->query($sql);

				//Delete all tables if style is already saved
				
				if($result->num_rows >0){
					$styleId = array();
					while ($row = $result-> fetch_assoc()){
						$styleId[] = $row["styleId"];
					}
					foreach( $styleId as $styleId){
						$sql = "DELETE FROM Styles_Colors WHERE styleId = '$styleId'";
						$connection->query($sql);
						$sql = "DELETE FROM Styles_Brands WHERE styleId = '$styleId'";
						$connection->query($sql);		
					}
					$sql = "DELETE FROM Styles where userId = '$userId'";
					$connection->query($sql);
				}
				
				//Create new style
				$sql = "INSERT INTO Styles (userId,type,size)
				VALUES('$userId','$type','$size')";
				$connection->query($sql);
				$sql= "SELECT styleId from Styles WHERE userId = '$userId'";
				$result =$connection->query($sql);
				if($result->num_rows >0){
					while ($row = $result-> fetch_assoc()){
						$styleId = $row["styleId"];
					}
				}
				
				foreach( $colors as $value){
						$sql = "INSERT INTO Styles_Colors (styleId,colorId)
							VALUES('$styleId','$value')";
						$connection->query($sql);	
						}	
				foreach( $brands as $value){
						$sql = "INSERT INTO Styles_Brands (styleId,brandId)
							    VALUES('$styleId','$value')";
						$result = $connection->query($sql);	
				}
			
			
				if($result){
					
					return array("MESSAGE"=>"SUCCESS");
				}
				else{
					
					return array("MESSAGE"=>"406");
				}
			}
			else{
				return array("MESSAGE"=>"500");
			}
		}

		function loadStyle($userId){
			$connection = databaseConnection();
			if($connection != null){
			$sql= "SELECT * FROM Styles WHERE userId = '$userId'";
			$result =$connection->query($sql);
			if($result->num_rows >0){
				while ($row = $result-> fetch_assoc()){
					$styleId = $row["styleId"];
				}
				$sql = "SELECT * FROM Styles s
				JOIN Styles_Brands sb ON s.styleId = sb.styleId
				JOIN Styles_Colors sc ON s.styleId = sc.styleId
				JOIN Colors c ON sc.colorId = c.colorId
				JOIN Brands b ON b.brandId = sb.brandId
				WHERE s.styleId = '$styleId'";
				$result =$connection->query($sql);
				if($result->num_rows >0){
					$re=array();
					while ($row = $result-> fetch_assoc()){
						$response = array("size"=>$row["size"],"type"=>$row["type"],"brand"=>$row["brandname"],"color"=>$row["colorname"],"MESSAGE"=>"SUCCESS");
						$re[] = $response;
					}
					return $re;
				}
				else{
					return array("MESSAGE"=>"406");
				}

			}
			
			else{
				return array("MESSAGE"=>"406");
			}
			
			
		}
		else{
			return array("MESSAGE"=>"500");
		}
	}
	function updateProfile($userId,$uName,$fName,$lName,$email,$country){
		$connection = databaseConnection();
		if($connection != null){
			$sql= "UPDATE Users
			SET username = '$uName',
			fName = '$fName',
			lName = '$lName',
			email = '$email',
			country = '$country'
			WHERE UserId = '$userId'";
			$result =$connection->query($sql);
			if($result){
				return array("MESSAGE"=>"SUCCESS");
				
			}
			else{
				return array("MESSAGE"=>"406");

			}
		}
		else{
			return array("MESSAGE"=>"500");
			
		}
	}
?>
