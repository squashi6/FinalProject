

 $(document).ready(function(){
    
    checkCookie();
    

 });
var radio = $(".radio");
var register = $(".reg");
var warnings = $(".warning");



//eventListeners

$("#submitLog").on("click", function(){
    checkLogin(); 
})


//$(".addButton").on("click")

$("#submitReg").on("click",function(){ 
    checkRegister();  
  });


    // functionality to swap between sides
$("#register").on("click", function(){  
    $("#loginfield").attr("hidden","true");
    $("#registerfield").removeAttr("hidden","false");
   
})
$("#login").on("click", function(){  
    $("#registerfield").attr("hidden","true");
    $("#loginfield").removeAttr("hidden","false");
}) 

$(".productPage").on("click",function(){
    $("#productPage").removeAttr("hidden","false");
    $("#profilePage").attr("hidden","true");
    $("#stylesPage").attr("hidden","true");
    $("#inventoryPage").attr("hidden","true");
    $("#aboutusPage").attr("hidden","true");
}) 
    
    

$(".inventoryPage").on("click",function(){
    $("#inventoryPage").removeAttr("hidden","false");
    $("#profilePage").attr("hidden","true");
    $("#stylesPage").attr("hidden","true");
    $("#productPage").attr("hidden","true");
    $("#aboutusPage").attr("hidden","true");
})
$(".profilePage").on("click",function(){
    $("#profilePage").removeAttr("hidden","false");
    $("#inventoryPage").attr("hidden","true");
    $("#stylesPage").attr("hidden","true");
    $("#productPage").attr("hidden","true");
    $("#aboutusPage").attr("hidden","true");
})

$(".stylesPage").on("click",function(){
    $("#stylesPage").removeAttr("hidden","false");
    $("#profilePage").attr("hidden","true");
    $("#inventoryPage").attr("hidden","true");
    $("#productPage").attr("hidden","true");
    $("#aboutusPage").attr("hidden","true");
   
})
$(".aboutusPage").on("click",function(){
    $("#aboutusPage").removeAttr("hidden","false");
    $("#inventoryPage").attr("hidden","true");
    $("#stylesPage").attr("hidden","true");
    $("#productPage").attr("hidden","true");
    $("#profilePage").attr("hidden","true");
})
$("#order").on("click", function(){
    
    checkOrder();
})
$("#executeOrder").on("click", function(){
    makeOrder(localStorage.getItem("userId")); 
})

//variables


//functions
function checkLogin(){   
            
    
    const username = $("#username").val();
    var password = $("#password").val();
        if (username !="" && password !=""){
            if($("#remember").prop("checked")){
                var checkbox=true;
            }
            else{
                var checkbox = false;
            }
            var jsonToSend = {
                "action" : "LOGIN",
                "uName" : username,
                "uPassword" : password,
                "checkbox": checkbox
            };
            $.ajax({
                url : "./Data/applicationLayer.php",
                type : "POST",
                data : jsonToSend,
                ContentType : "application/json",
                dataType : "json",
                success : function(dataReceived){
                    alert("welcome back   " + dataReceived.firstname+"   "+dataReceived.lastname);
                    localStorage.setItem("username",username);
                    localStorage.setItem("userId",dataReceived.userId);
                    redirectWelcome();
                    

                    
                },
                error : function(errorMessage){
                    alert(errorMessage.statusText);
    
                }  
            })
            
        }
    }


function checkRegister(){
    //checking the Text inputs
    var count=0;
    var errors=0;
    $(".reg").each(function(){
        if($(this).val()==""){
            warnings[count].removeAttribute("hidden");
            
            errors++;
        }
        else{
            warnings[count].setAttribute("hidden","");
        }
        count++;

    })
    //checking the Select bar
    if($("#country option:selected").val()=="1"){
        $("#countryw").removeAttr("hidden");
        errors++;
    }
    //checking the radio Button
   if($("#male").attr('checked')===false&&$("female").attr('checked')===false){
    
       $("#gender").removeAttr("hidden");
    errors++;
   }
   
    if(errors===0){

        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val(); 
        var username = $("#usernameReg").val();
        var email = $("#email").val();
        var password = $("#passwordreg").val();
        var passwordConf = $("#passwordregconf").val();
        var country = $("#country").val();
        var gender = $(".radio").prop("checked",true).val();

        var jsonToSend = {
            "action": "REGISTER", 
            "fName": firstname,
            "lName" : lastname,
            "uName" : username,
            "email": email,
            "uPassword" : password,
            "country": country,
            "gender":gender
        };
        console.log(jsonToSend)

        $.ajax({
            url : "./Data/applicationLayer.php",
            type : "POST",
            data : jsonToSend,
            ContentType : "application/json",
            dataType : "json",
            success : function(dataReceived){
                localStorage.setItem("username",username);
                console.log("success");
                redirectWelcome();
                
            },
            error : function(errorMessage){
                
                
                alert(errorMessage.statusText);
                        }
                       
        })
    }
}





function redirectHome() {
    jsonToSend = {
        "action": "DELETESESSION"
    }
    $.ajax({
        url: "../Data/applicationLayer.php",
        type: "POST",
        data: jsonToSend,
        ContentType : "application/json",
        dataType : "json",
        success: function(dataReceived) {
            console.log(dataReceived);
            window.location.replace('../index.html');
        },
        error: function(error) {
            console.log(error);
            alert("Error logging out. Try again later.");
        }
    });   
    
  }
  function redirectWelcome() { 
      
    window.location.replace('html/welcome.html');  
       
}
 function checkCookie(){
    jsonToSend = {
        "action": "CHECKCOOKIE"
    }
    $.ajax({
        url: "./Data/applicationLayer.php",
        type: "POST",
        data: jsonToSend,
        ContentType : "application/json",
        dataType : "json",
        success: function(dataReceived) {
                    $("#username").val(dataReceived.savedUser);
                },
                error : function(errorMessage){
                    //console.log(errorMessage)
    
                }  
            })


 }

 function makeOrder(userId) {
     var username = localStorage.getItem("username");
     var package = $(".package:checked").val();
     if (package === "small") {
         var price = 15;
     }
     else {
         var price = 20;
     }
     var jsonToSend = {
         "action": "MAKEORDER",
         "userId": userId,
         "package": package,
         "price": price
     }
     $.ajax({
         url: "../Data/applicationLayer.php",
         type: "POST",
         data: jsonToSend,
         ContentType: "application/json",
         dataType: "json",
         success: function (dataReceived) {
             alert("Order Made");
         },
         error: function (errorMessage) {
             console.log(errorMessage)

         }
     })
 }
 function checkOrder(){
    var package = $(".package:checked").val();
    if (package === "small") {
        var price = 15;
    }
    else {
        var price = 20;
    }
     var jsonToSend = {
         "action" : "CHECKORDER",
         "username": localStorage.getItem("username")
     }
     $.ajax({
        url: "../Data/applicationLayer.php",
        type: "POST",
        data: jsonToSend,
        ContentType: "application/json",
        dataType: "json",
        success: function (dataReceived) {
            
            if(dataReceived){
                var date = Date.now();
                
                var orderData ="";
                var username =localStorage.getItem("username");
                orderData +=`
                             <li class="orderData" > Username:  `+username+`</li>
                             <li class="orderData" > Order DATE:  `+date+`</li>
                             <li class="orderData" > Size:  `+dataReceived.size+`</li>
                             <li class="orderData">  Type:  `+dataReceived.type+`</li>`;
                             $("#checkOrder").prop("hidden",false);
                             $("#orderData").append(orderData);
                
            }
            else{
                alert("select Style First")
            }
        },
        error: function (errorMessage) {
            console.log(errorMessage)

        }
    })

 }



