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
	
?>
