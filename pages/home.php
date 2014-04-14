<script>
    $(document).ready(function() {
        var offset = 0; 
        // Load the initial 5 apps 
        $.ajax({
           url: 'scripts/getApps.php',
           type: 'post',
           data: {"offset": offset},
           success: function(response) {
              
                $("#apps").replaceWith(response);
               
            }
        });
    
        // Load next 5 
        $('#next').click(function(){
            offset = offset+5; 
            console.log(offset);
                $.ajax({
                   url: 'scripts/getApps.php',
                   type: 'post',
                   data: {"offset": offset},
                   success: function(response) {
                        console.log(response);
                        $("#apps").replaceWith(response);
                       
                    }
                });
        });
        
        // Load previous 5 
        $('#back').click(function(){
            if (offset > 4) {
            
                offset = offset-5; 
                console.log(offset);
                console.log('back called');
                $.ajax({
                   url: 'scripts/getApps.php',
                   type: 'post',
                   data: {"offset": offset},
                   success: function(response) {
                        console.log(response);
                        $("#apps").replaceWith(response);
                       
                    }
                });
            }
        });
        
        // Rate an app 
        $('#content').on("click", "img", function (event) {
        
            // parse the dynamically generated image id to get data of click
            var id = event.target.id; 
            var appid = id.substr(1); 
            var rating = id.substr(0, 1); 
            var like = 0; 
            if (rating == 'l') {
                like = 1; 
            }
            
            if (rating == 'l' || rating == 'd') {
                $.ajax({
                       url: 'scripts/rateApp.php',
                       type: 'post',
                       data: {"liked": like, "appid" : appid},
                       success: function(response) {
                           
                           // If we echoed something then we already voted 
                           if (response.toString().length > 1) {
                           
                               alert("Already voted!"); 
                           
                           // Change the values      
                           } else {
                                var currentRating = $("#appRating"+appid).text(); 
                                var totalRating = $("#appTotal"+appid).text(); 
                                console.log(currentRating);
                                console.log(totalRating);
                                
                                if (like == 1) {
                                    var newRating = parseInt(currentRating.substr(13));
                                    newRating = newRating + 1; 
                                    $("#appRating"+appid).text("Total Likes: " + newRating); 
                                }
                                
                                var newTotal = parseInt(totalRating.substr(17));
                                newTotal = newTotal+1; 
                                $("#appTotal"+appid).text("Total Ratings: " + newTotal);
                                
                           }
                      
                        }
                    });
            }
           
        });
        

        
    });
</script>
<div id="apps">
</div><br/>
<a href="#" id="next">Next</a>
<a href="#" id="back">Back</a>