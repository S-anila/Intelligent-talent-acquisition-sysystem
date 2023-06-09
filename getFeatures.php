<?php
error_reporting(0);
    include './serverScript/class/Database.php';

    $db = new Database();
    $db->connect();

    $db->sql("SELECT count(*) as num FROM pb_candidate_list;");

    $num_conducted = $db->getResult();

    $db->sql("SELECT count(*) as num FROM pb_candidate_details;");
    $num_total = $db->getResult();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="New Intelligent System">
    <title>HRA</title>
    
    <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <!-- JS -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/plot/d3.min.js"></script>
    <script type="text/javascript" src="./js/plot/d3.layout.min.js"></script>
    <script type="text/javascript" src="./js/plot/rickshaw.min.js"></script>
    <script type="text/javascript" src="./js/plot/Rickshaw.Series.Sliding.js"></script>
    <script type="text/javascript" src="./js/plot/d3.v2.js"></script>
    
    
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <link rel="stylesheet" href="css/layouts/blog.css">
    
    <style type="text/css">
  
        form { margin-top: 15px; }
        form > input { margin-right: 15px; }
        #results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
        #myProgress {
            width: 750px;
            background-color: #ddd;
        }

        #analysis_results{
            margin-bottom:0;
            margin-top:20px;
            text-align:center;
        }

        #myBar {
            width: 10%;
            height: 30px;
            background-color: #8C0E0ED6;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        .container {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        flex-wrap: wrap;
        box-sizing: border-box;
        }

        .container-wrapper {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        max-width: 750px;
        margin: 0 auto;
        flex-wrap: wrap;
        }

        .card {
            margin-top:10px;
            margin-right:10px;
            padding:5px;
            border: 1px solid #ddd;
        }

        .rating_label{
            background-color:#56776e;
            color:white;
            padding:5px;
        }
        hr{
            margin:0;
            height: 12px;
            border: 0;
            box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body onLoad="startTime()" >

<div class="col-md-12" style="background-color:#ad2134;">
<br>
   <h1 class="text-center" style="color:#f2e6e8;">Intelligent Talent Acquisition System</h1>
            <hr>
            
                   
           
</div>
<div style=" background-image: url('coverbgrnd.jpeg') !important; background-repeat: no-repeat; background-size: cover; background-position: center">
        <div class="content pure-u-1 pure-u-md-3-4 ">
            <div>
                <!-- A wrapper for all the blog posts -->
                <div class="posts">
                    <h1 class="content-subhead">ANALYSIS RESULT</h1>

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
                  
                        <a class="pure-button" href="interview.php?id=<?php echo $_REQUEST['id'];?>">Back</a>
                         <a class="pure-button" href="index.php">Logout</a> 
                            
                        </header>

                        
                    </section>
                </div>

                <?php
                                    $db->sql('SELECT * FROM pb_candidate_details WHERE c_id=' . $_GET['id']);
                                    $res = $db->getResult();
                                    $row = $res[0];
                                    $li = "";
                                    foreach ($row as $key => $value) {
                                        # code...
                                        if($key == 'c_id')
                                            $key = 'candidate ID:';
                                        if($key == 'photo')
                                            continue;

                                        if($key == 'resume')
                                        {
                                            $myFile = "input.txt";
                                            $fh = fopen($myFile, 'w') or die("can't open file");
                                            
                                            fwrite($fh, $value);

                                            fclose($fh);
                                            $value = "<a href=\"" . $value . "\">View</a>";
                                           
                                        }
                                            
                                        $li .= "<li class=\"candidate-item-1\"><h5 style='text-transform: uppercase; display: inline;'>" . $key."</h5>";
                                        $li .= " &nbsp; &nbsp;  " . $value . "<br></li><br><br>";
                                    }
                ?>

                <div class="posts">
                    <h1 class="content-subhead">Statistical Analysis</h1>

                    <section class="post">
                        <header class="post-header">
                            <?php
                                echo "<img width=\"300\" height=\"300\" alt=\"Eric Ferraiuolo&#x27;s avatar\" class=\"post-avatar\" src=\"" . $row["photo"] . "\">";
                            ?>
                            <h2 class="post-title">Candidate Details</h2>
                            
                        </header>

                        <div class="candidate details">
                            <p>
                                <ul class="candidate-gen-info" >
                                    <?php echo $li; ?>
                                </ul>
                            </p>
                        </div>
                    </section>

                    <br/>
                    
                    <section class="ratings-container">
   <h2 class="post-title">RESULT</h2>
                        <?php 
                             //file locaton
            $filePath = './data_save/predictedFeatures.json';

            //get the content of thea json file
            //$jsonStringData  = file_get_contents($filePath);

            //get json data in associative array
           // $json = json_decode($jsonStringData,true);
           // $json["c_id"]=$_GET["id"];
            //echo $json;

           $data = file_get_contents ($filePath);
        $json = json_decode($data, true);
        foreach ($json as $key => $value) {
            if (!is_array($value)) {
              
        
       
                $html .= '<div class="card">
                    <h3 class="">' . str_replace("_"," ",$key) . '</h3>
                    <fieldset class="rating">';

                    if($key == 'Recommend_Rating' && $value>3.5){
                        $value = 3;
                    }else if($key == 'Overall_Rating' && $value>3.5){
                        $value = 2.5;
                    }else if($key == 'Not_Stressed' && $value>3.5){
                        $value =  3;
                    }

                    if($value>4){
                        $value -= 0.5;
                    }
                    
                    if($value>4.5)
                        {

                            $html .='<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" ' . 'checked="checked"' . ' /><label class = "full" for="star5" title="Awesome - 5 stars"></label>

                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                        }
                    elseif ($value >4) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }
                    elseif ($value>3.5) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" ' . 'checked="checked"' . '  /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }
                    elseif ($value>3) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }elseif ($value >2.5) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3"  ' . 'checked="checked"' . '  /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }elseif ($value >2) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }elseif ($value>1.5) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" ' . 'checked="checked"' . '  /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }elseif ($value>1) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }elseif ($value>0.5) {
                        # code...
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" ' . 'checked="checked"' . '  /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }else{
                        $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                    title="Awesome - 5 stars"></label>
                                <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half"  ' . 'checked="checked"' . ' /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }
                
                $html .=' </fieldset><br></div><br><br>';
         } else {
                foreach ($value as $key => $val) {
                    echo "<div style='font-weight: bold;text-transform: uppercase;'>".$key . '&&' . $val . '<br/></div>';
                }
            }
        }
            
           echo '<div class="container"><div class="container-wrapper">' . $html . '</div></div>';
           $python = "C:\\ProgramData\\Anaconda3\\python.exe";
        
          
               

?>

                    </section>
                    
               
            </div>
        </div>
    </div>
   
</body>
</html>
<?php
$db->disconnect();
?>