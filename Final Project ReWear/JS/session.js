$(document).ready(function(){
  
    loadProfile();
    loadOrders();
});
$(".profilePage").on("click",function(){
   // loadProfile();
    //loadOrders();
 
})


        function loadProfile(){
            var username = localStorage.getItem("username");
            
        
            var jsonToSend = {
                "action" : "LOADPROFILE",
                "username" :username
            }
            $.ajax({
                url :"../Data/applicationLayer.php",
                type:"POST",
                data:jsonToSend,
                ContentType : "application/json",
                dataType: "json",
                success: function(jsonData){
                   
                   var profile =""
                   profile +=`
                                <li class="profileInfo" > Username:  `+username+`</li>
                                <li class="profileInfo" > Firstname:  `+jsonData.firstname+`</li>
                                <li class="profileInfo" > Latname:  `+jsonData.lastname+`</li>
                                <li class="profileInfo">  Email:  `+jsonData.email+`</li>
                                <li class="profileInfo">  Gender:  `+jsonData.gender+`</li>
                                <li class="profileInfo">  Country.  `+jsonData.country+`</li>`
                                $("#profileList").append(profile);
                   
                }
            })
        }
        function loadOrders(){
            
            jsonToSend = {
                "action":"LOADORDERS",
                "userId":localStorage.getItem("userId")
            }
            $.ajax({
                url :"../Data/applicationLayer.php",
                type:"POST",
                data:jsonToSend,
                ContentType : "application/json",
                dataType: "json",
                success: function(jsonData){
                   for(data of jsonData){
                       var order = "";
                       order += `<div class="p-2">
                       <ul class="list">
                       <li> Order ID : `+ data.orderId+ `</li>
                       <li> Order Date : `+ data.orderDate+ `</li>
                       <li> Package Size : `+ data.package+ `</li>
                       <li> Price : `+ data.price+ `$</li>
                       </ul></div>`
                       $("#orderList").append(order);
                   }
                },

                   error : function(errorMessage){
                    console.log(errorMessage)
                   }
                })
            }
            

        
        
    

