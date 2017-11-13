$(document).ready(function(){
    loadStyle();
    loadProfile();
    loadOrders();
});

$("#saveChanges").on("click",function(){ 
    loadProfile();
    
  });


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
                                <lh> Profile
                                <li class="profileInfo" > Username:  `+username+`</li>
                                <li class="profileInfo" > Firstname:  `+jsonData.firstname+`</li>
                                <li class="profileInfo" > Latname:  `+jsonData.lastname+`</li>
                                <li class="profileInfo">  Email:  `+jsonData.email+`</li>
                                <li class="profileInfo">  Gender:  `+jsonData.gender+`</li>
                                <li class="profileInfo">  Country.  `+jsonData.country+`</li>`
                                $("#profileList").html(profile);
                                
                   var profile =""
                   profile +=`
                                <lh> Profile
                                <li class="profileInfo">Username : <input type="text" id="username" value="`+username+`"></li>
                                <li class="profileInfo">Firstname: <input type="text" id="firstname" value="`+jsonData.firstname+`"</li>
                                <li class="profileInfo">Lastname : <input type="text" id="lastname" value="`+jsonData.lastname+`"</li>
                                <li class="profileInfo">Email    : <input type="text" id="email" value="`+jsonData.email+`"</li>
                                <li class="profileInfo">Username : <input type="text" id="country" value="`+jsonData.country+`"</li>
                                `
                                $("#changeProfileField").html(profile);
                   
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
                       <lh>Order Nr.`+ data.orderId+ `
                       <li class="profileInfo"> Order Date : `+ data.orderDate+ `</li>
                       <li class="profileInfo"> Package Size : `+ data.package+ `</li>
                       <li class="profileInfo"> Price : `+ data.price+ `$</li>
                       </ul></div>`
                       $("#orderList").append(order);
                   }
                },

                   error : function(errorMessage){
                    console.log(errorMessage)
                   }
                })
            }
            function loadStyle(){
                jsonToSend = {
                    "userId" : localStorage.getItem("userId"),
                    "action" : "LOADSTYLE"
                }
                $.ajax({
                    url :"../Data/applicationLayer.php",
                    type:"POST",
                    data:jsonToSend,
                    ContentType : "application/json",
                    dataType: "json",
                    success: function(jsonData){
                        var type = jsonData[0]["type"];
                        var size = jsonData[0]["size"];
                        var brands = [];
                        var colors = [];
                        var brand  = "";
                        var color = "";
                        for( data of jsonData){
                            if(!brands.includes(data.brand)){
                                brands.push(data.brand);
                            }
                        }
                        for( data of jsonData){
                            if(!colors.includes(data.color)){
                                colors.push(data.color);
                            }
                        }
                        for( data of brands){
                           brand += data+", ";
                        }
                        for( data of colors){
                            color += data+", ";
                        }
                        console.log(color);

                        console.log(brand);

                        var html = `
                        <lh>MyStyle
                        <li class="profileInfo"> Type : `+ type+ `</li>
                        <li class="profileInfo"> Size: `+ size+ `</li>
                        <li class="profileInfo"> Brands : `+ brand+ `</li>
                        <li class="profileInfo"> Colors : `+ color+ `</li>`;

                        $("#styleList").html(html);
                        

                       
                  
                        
                        
                    },
    
                       error : function(errorMessage){
                           var html = `<li> No Style selected yet</li>`
                        $("#styleList").html(html);
                       }
                    })
            }
            

        
        
    

