<?php


header('Content-type: application/json');
header('Accept: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];

switch($action)
{
    case "LOGIN" : loginFunction();
                    break;
    case "REGISTER" : registrationFunction();
                    break;
    case "CHECKSESSION" :checkSessionFunction();
                    break;
    case "DELETESESSION": deletSessionFunction();
                    break;
    case "CHECKCOOKIE" : checkCookieFunction();
                    break;
    case "LOADPROFILE" : loadProfileFunction();
                    break;
    case "MAKEORDER" : createOrderFunction();
                    break;
    case "CHECKORDER" : checkOrderFunction();
                    break;
    case "LOADORDERS" : loadOrdersFunction();
                    break;

}
//Functions

function loginFunction(){

    $uName = $_POST["uName"];
    $uPassword = $_POST["uPassword"];

    $loginResponse = attemptLogin($uName, $uPassword);

    if($loginResponse["MESSAGE"] == "SUCCESS") {
        $response = array("userId"=>$loginResponse["userId"],"firstname"=>$loginResponse["firstname"], "lastname"=>$loginResponse["lastname"]);

        session_start();

         $_SESSION['currentUser']= $uName;
            $_SESSION['fName'] = $response['firstname'];
            $_SESSION['lName'] = $response['lastname'];

            if($_POST["checkbox"]){
                    $cookieName = "savedUser";
                    $cookieValue = $uName;
                    setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");

            }

        echo json_encode($response);

    }
    else{
        echo "HAlloo";
        genericErrorFunction($loginResponse["MESSAGE"]);
    }
}

function registrationFunction(){

    $uName = $_POST["uName"];
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $userPassword = $_POST['uPassword'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];

    $createResponse = createUser($uName, $fName, $lName, $email,  $userPassword,  $country, $gender);
    if ($createResponse["MESSAGE"]=="SUCCESS"){

    session_start();

     $_SESSION['currentUser']= $uName;
        $_SESSION['fName'] = $fName;
        $_SESSION['lName'] = $lName;



        $response = array('result'=>$createResponse["MESSAGE"]);
        echo json_encode($response);


    }
    else
    {

        genericErrorFunction($createResponse["MESSAGE"]);
    }
}

 
 
  function checkSessionFunction(){
    session_start();
    if( isset($_SESSION["currentUser"]) && isset($_SESSION["fName"]) && isset($_SESSION["lName"]) ) {
      echo json_encode(array("currentUser" => $_SESSION["currentUser"], "fName" => $_SESSION["fName"], "lName" => $_SESSION["lName"]));
    }
    else {
      //return to log in error
      header("HTTP/1.1 400 Session not found");
      die(json_encode(array("message" => "Error", "code" => 1337)));
    }
  }

  function deletSessionFunction(){
    session_start();
    session_destroy();
    echo json_encode("Hallo");
  }

  function checkCookieFunction(){
    if( isset($_COOKIE["savedUser"])) {
        $response = array('savedUser' => $_COOKIE["savedUser"]);
        echo json_encode($response);
      }
      else {
        //return to log in error
        header("HTTP/1.1 400 Cookie not found");
        die(json_encode(array("message" => "Error", "code" => 1337)));
      }
  }
  function loadProfileFunction(){
    $uName = $_POST["username"];
    $result = loadProfile($uName);
    if($result["MESSAGE"]=="SUCCESS"){
        echo json_encode($result);
    }
    else{
        genericErrorFunction($result["MESSAGE"]);
    }

  }

 function createOrderFunction(){
    $userId = $_POST["userId"];
    $package = $_POST["package"];
    $price = $_POST["price"];
    $response= createOrder($userId,$package,$price);
    if ($response["MESSAGE"]=="SUCCESS"){
        
                echo json_encode($response["MESSAGE"]);
            }
            else{
                genericErrorFunction($response["MESSAGE"]);
            }
}
function checkOrderFunction(){
    $username = $_POST["username"];
    $result= checkOrder($username);
    
    if($result["MESSAGE"]=="SUCCESS"){
        
        echo json_encode($result);
    }
    else{
        genericErrorFunction($result["MESSAGE"]);
    }
   
}
function loadOrdersFunction(){
    $userId = $_POST["userId"];
    $result= loadOrders($userId);
    if($result[1]["MESSAGE"]=="SUCCESS"){
        
        echo json_encode($result);
    }
    else{
        genericErrorFunction($result["MESSAGE"]);
    }
}


  function genericErrorFunction($errorCode)
  {

      switch($errorCode)
      {
          case "500" : header("HTTP/1.1 500 Bad connection, portal down");
                       die("The server is down, we couldn't stablish the data base connection.");
                       break;
          case "406" : header("HTTP/1.1 406 User not found.");
                       die("Wrong credentials provided.");
                       break;
      }
  }


?>
