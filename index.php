<?php
    if(isset($_GET["error"])){
        $error = $_GET["error"];

        if($error == "true"){
            echo '<script type="text/javascript">
                        alert("Error Occur: It looks Like you have already registered!");
                    </script>';
        }else{
            echo '<script type="text/javascript">
                        alert("Login to continue..");
                    </script>';
        }
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="New Intelligent System">
    <title>HRA</title>
   <!-- 
    <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <link rel="stylesheet" href="./css/bootstrap.min.css">
  
	   <link rel="stylesheet" href="css/layouts/blog.css">-->
      <link rel="stylesheet" href="./css/registration/registration.css">
	  <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <!-- js -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/webcam/webcam.min.js"></script>
    

         
        <!--<![endif]-->
</head>

<head>

  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="col-md-12"  style="background-color:#ad2134;">
<br>
   <!--<h1 class="text-center">Intelligent Talent Acquisition System</h1>  
            -->
           
   <h1 class="text-center"  style="color:#f2e6e8;">Intelligent Talent Acquisition System <h1>       
</div>
<body style="background-color:#16c8f0;">

<div class='col-md-12'>
<div class="col-md-6">
<img src='b.jpg' style="width:800px;
}" >
</div>
    <div class="col-md-6" >
        <div>
            
            <!-- A wrapper for all the blog posts -->
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="posts">

               

                <section>
                    <div class="container" id="register">  
					<br>
                        <form id="contact" action="./register.php" method="post" enctype="multipart/form-data">
                          <h3>Candidate Registration</h3>
                          <h4 style="float:right">One Step toward success ...</h4>
                          
                           <fieldset>
                                <div id="results">Your captured image will appear here...</div>
                                <div id="my_camera"></div>
                                <div id="cam_btn">
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    <input type="button" value="Done" onClick="photo_done()">
                                </div>
                          </fieldset>

                          <fieldset>
                            <input name="fname" placeholder="First Name" type="text" tabindex="1" required autofocus>
                          </fieldset>
                          
                          <fieldset>
                            <input name="lname" placeholder="Last Name" type="text" tabindex="2" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name ="age" placeholder="Age" type="Number" tabindex="3" required min=18 autofocus>
                          </fieldset>

                          
                          <fieldset>
                            <input name="college" placeholder="College" type="text" tabindex="4" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name="degree" placeholder="Degree" type="text" tabindex="5" required autofocus>
                          </fieldset>
                          <fieldset>
                                <input name="stream" placeholder="Stream" type="text" tabindex="5" required autofocus>
                          </fieldset>

                          <fieldset>
                                <input name="experience" placeholder="Experience(years)" type="number" tabindex="5" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name="email" placeholder="Email Address" type="email" tabindex="6" required>
                          </fieldset>
                          
                          <fieldset>
                            <input name="phone" placeholder="Phone Number" type="tel" tabindex="7" required autofocus="">
                          </fieldset>

                          <fieldset>
                                <button style="display:block;width:120px; height:30px;" onClick="document.getElementById('getFile').click()">Upload Resume</button>
                                <i id="fileName">Nothing selected</i>
                                <input name="file" type="file" id="getFile" style="display:none;padding:2px;" accept=".pdf" tabindex="5" required autofocus>
                            </fieldset>

                          <input type="hidden" name="image_data" value="" id="image_data"/>
                                                 
                          <fieldset>
                            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                          </fieldset>

                          <h6>Already Registered <a href="#" id="login-trigger">Login</a></h6>
                        </form>
                    
                      </div>

                      <div class="container" id ="login">  
                            <form id="contact"action="./login.php" method="post">
                              <h3>Candidate Login</h3>
                              <h4 style="float:right">One Step toward success ...</h4>
                              
                              
                              <fieldset>
                                <input name="email" placeholder="Email Address" type="email" tabindex="6" required>
                              </fieldset>
                                                     
                              <fieldset>
                                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                              </fieldset>
    
                              <h6>New Candidate <a href="#" id = "register-trigger">Register</a></h6>
                            </form>
                          </div>
                          <script>
                              var click=0;
                              $(document).ready(function(){
                                    $("#register").hide();
                                    $("#fileName").hide();
                                    $("#register-photo").hide();

                                    $("#login-trigger").click(function(){
                                        $("#register").hide();
                                        $("#register-photo").hide();
                                        $("#login").show();

                                        Webcam.reset();
                                    });

                                    $("#register-trigger").click(function(){
                                        $("#login").hide();
                                        $("#register").show();
                                        $("#register-photo").show();
                                        //<!-- Configure a few settings and attach camera -->
                                        Webcam.set({
                                            width: 340,
                                            height: 240,
                                            image_format: 'jpeg',
                                            jpeg_quality: 90
                                        });
                                        Webcam.attach( '#my_camera' );
                                    });

                                    $('input[type="file"]').change(function(e){
                                        var fileName = e.target.files[0].name;
                                        $("#fileName").show();
                                        $("#fileName").html(fileName);
                                        //alert('The file "' + fileName +  '" has been selected.');
                                    });
                                });
                          
                            //<!-- Code to handle taking the snapshot and displaying it locally -->
    
                                var img_data = "";
    
                                function take_snapshot() {
                                    click++;
                                    // take snapshot and get image data
                                    Webcam.snap( function(data_uri) {
                                        // display results in page
                                        document.getElementById('results').innerHTML = 
                                            '<h6>Here is your image:</h6>' + 
                                            '<img src="'+data_uri+'"/>';
                                            img_data=data_uri;
                                    } );
                                }
    
                                function photo_done(){
                                    if(click>0){
                                        $("#my_camera").remove();
                                        $("#cam_btn").remove();

                                        document.getElementById('results').innerHTML = 
                                                '<img src="'+img_data+'"/>';
                                        Webcam.reset();
                                        $("#image_data").val(""+img_data);
                                    }else{
                                        alert("Please Capture Image");
                                    }
                                }
                            </script>
                </section>
            </div>
        </div>
    </div>
</div>
</body>
</html>
