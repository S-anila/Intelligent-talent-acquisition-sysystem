<?php
//error_reporting(0);
    include'./serverScript/class/Database.php';
 
    $db = new Database();

    $db->connect();

    $db->sql("SELECT count(*) as num FROM pb_candidate_list;");

    $num_conducted = $db->getResult();

    $db->sql("SELECT count(*) as num FROM pb_candidate_details;");
    $num_total = $db->getResult();
?> 
<!doctype htmwl>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="New Intelligent System">
    <title>TEST</title>
    
    <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <!-- JS -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <!--<![endif]-->
    
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/blog-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="css/layouts/blog.css">
        <!--<![endif]-->
        <style type="text/css">
            form { margin-top: 15px; }
            form > input { margin-right: 15px; }
            #profilePhoto {
                    zoom: 2;  //increase if you have very small images

                    display: block;
                    margin: auto;

                    height: auto;
                    max-height: 100%;

                    width: auto;
                    max-width: 100%;
                }
                /* Create two equal columns that floats next to each other */
            .column_2 {
                float: left;
                width: 50%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }
            .column_1 {
                float: right;
                width: 50%;
                
                height: 300px; /* Should be removed. Only for demonstration */
            }

            /* Clear floats after the columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
            #photoBanner{
                border-right-style:solid;
                border-right-width:thick;
                border-color:#ff9f80;

            }
            .button {
                background-color: #57d9a0;
                border: none;
                color: black;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
            }
            .button:hover{
                text-decoration:none; 
                cursor:pointer;
                background-color:#e7e7e7;
                color: black;
            }
        </style>
</head>
<body onLoad="startTime()">
    <body style="background-color:#f0f7f4;">


<div class="col-md-12"  style="background-color:#ad2134;">
<br>
 <!-- <h1 class="text-center">INTERVIEWEE BEHAVIOUR ANALYSIS SYSTEM</h1> -->
   <h1 class="text-center" style="color:#f2e6e8;">Intelligent Talent Acquisition System
</h1>
            <hr>
			
                   
           
</div>
<div style=" background-image: url('a.jpeg') !important; background-repeat: no-repeat; background-size: cover; background-position: center">


    <div class="content pure-u-1 pure-u-md-3-4">
        <div>
            <!-- A wrapper for all the blog posts -->
            <div class="posts">
                <h1 class="content-subhead">Pinned Board</h1>

                <!-- A single blog post -->
                <section class="post">
                    <header class="post-header">
                       
                        <script>
                            function startTime() {
                                var today = new Date();
                                var h = today.getHours();
                                var m = today.getMinutes();
                                var s = today.getSeconds();
                                m = checkTime(m);
                                s = checkTime(s);
                                document.getElementById('txt').innerHTML =
                                h + ":" + m + ":" + s;
                                var t = setTimeout(startTime, 500);
                            }
                            function checkTime(i) {
                                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                                return i;
                            }
                            </script>
                                
                        <h2 class="post-title">Time <div id="txt"></div></h2>

                        
                        <a class="pure-button" href="./start.php?id=<?php echo $_REQUEST['id'];?>">Interview Info</a>
                  
                        <!-- <a class="pure-button" href="index.php">Home</a> -->
                        <a class="pure-button" href="index.php">Logout</a>

                    </header>

                </section>
                <section>
                    <!-- 
                        PHP code for fetching candidate data and display
                    -->
                    <h2>Information</h2>
                    <?php
                        $db->sql('SELECT name,photo,degree,resume FROM pb_candidate_details WHERE c_id=' . $_GET['id']);
                        $res = $db->getResult();
                        $row = $res[0]; // array of paramenter

                        $html = '<div class="row">
                                  <div class="column_1">';
                        $html .= '
                                  <div id="photoBanner">
                                  
                                    <h2>Candidate Profile:</h2>
                                    <img id=height:100px","width:100px" src="'. $row["photo"] . '"/>
                                </div>
                                </div>';

                                 
                                


                        $html .= "<div class=\"column_2\">
                                    <h4>Name:</h4>&nbsp;&nbsp;" . $row["name"] .
                                    "<h4>Degree:</h4>&nbsp;&nbsp;" . $row["degree"] . 
                                    "<h4>Resume</h4>&nbsp;&nbsp;<a href=\"" . $row["resume"] . "\">view</a>";


                                 
                        $html .='<h4><br><br><a href="./interview.php?id=' .$_GET["id"]. '" class="button">Proceed to Interview</a></h4>' . "</div></div>";;
                        
                        echo $html;
                    ?>
                </section>
            </div>

      
    </div>
</div>
</body>
</html>
