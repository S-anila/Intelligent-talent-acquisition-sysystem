<?php
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
    <title>Test</title>
    
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
            background-color: #1fa1a3;
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
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body onLoad="startTime()">
     <body style="background-color:#f0f7f4;">


<div class="col-md-12"  style="background-color:#ad2134;">
<br>
   <h1 class="text-center" style="color:#f2e6e8;">Intelligent Talent Acquisition System</h1>
            <hr>
			
                   
           
</div>


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
                                document.getElementById('txt').innerHTML =h + ":" + m + ":" + s;
                                var t = setTimeout(startTime, 500);
                            }
                            function checkTime(i) {
                                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                                return i;
                            }
                            </script>
                                
                        <h2 class="post-title">Time <div id="txt"></div></h2>

                        <a class="pure-button " href="./start.php?id=<?php echo $_REQUEST['id'];?>">Interview Info</a>
                  
                        <a class="pure-button" href="index.php">Home</a>
                        
                    </header>

                   
                </section>
                <section >
                    <div class="container">
                        <div class="container-wrapper">
                            <!-- candidate photo -->
                            <div id="results" class="card" >
                                <?php 
                                    $db->sql('SELECT photo FROM pb_candidate_details WHERE c_id=' . $_GET['id']);
                                    $res = $db->getResult();

                                    $html = '<h2>Candidate Profile:</h2>' . 
                                            '<img src="' . $res[0]["photo"] . '"/>';
                                    echo $html;
                                ?>
                            </div>
                            
                            <!-- Interview Controls-->
                            <div class="card">
                                <button id="start" class='btn btn-success' >start Interview</button>
                                <button id="stop"  class='btn btn-danger'>stop Interview</button>
                              <button  class='btn btn-info' > <a href="getFeatures.php?id=<?php echo $_REQUEST['id']; ?>"> Get Analysis </a></button>
                                <div id="log">Here your log comes</div>
                            </div>
                        </div>

                    </div>
                    <div class="container">
                    <div class="container-wrapper">
                        <div id="myProgress" class="card">
                            <div id="myBar">10%</div>
                        </div>
                    </div>
<!--
                    <div class="container-wrapper">
                        <div class="graphs">
                            <ul class="graph-list">
                                <li class="graph-number">
                                        <div id="chart-smile">
                                        <h2 style="text-align: center">Smile Score Variation</h2>
                                        </div>
                                </li>
                            </ul>
                        </div>
                    </div>
					-->
                    </div>
                    
                </section>

                <section class="ratings-container" id="final_Score">
                </section>
            </div>
        </div>
    </div>
</div>

<script>
	var graph=null;
    var stop=false;
    var started=false;
    var isLastModifiedSet = false;
    var lastModified = 0;
	// Generate a graph
	
    $(document).ready(function(){
        $(".graphs").hide();
        $("#myProgress").hide();
        $(".ratings-container").hide();

        $("#start").click(function(){
            if(!started){
                started=true;
                $("#myProgress").show();
                progressBar();
                $.get("./driver.php",{"id":1},function(data) {
                    console.log(data);
                    $("#log").append("<br><p>" + data + "</p>");
                });

                getBackgroundStatus();
            }
            else{
                alert("Backend is starting soon...");
            }
        });

        $("#stop").click(function(){
            $.get("./driver.php",{"id":2},function(data) {
                
                stop = true;
                $("#log").append("<br><p>" + data + "</p>");
                $(".graphs").hide();
                
               
                
            });
        });

        $("#fetch").click(function(){
            $.get("./getFeatures.php",{"id":<?php echo $_GET["id"] ?>,"fetch":1},function(data) {
                    //$("#log").html("<br><p>" + data + "</p>");
                    var obj = data;
                    console.log(obj);
                    var content = "<h2 id=\"analysis_results\">Analysis Results</h2><br><hr/>" + data;
                    $(".ratings-container").html(content);
                    $(".ratings-container").show();
                });
        });
    });

    function initiate(){
        console.log("setting up graph and flooding data");
        graph_flood();

        console.log("displaying graphs");
        $(".graphs").show();
        
        console.log("hiding rating container");
        $(".ratings-container").hide();

        console.log("creating new connection");
        fetch_data();
    }

	function graph_flood(){
        console.log("graph instance created");

        graph = new Rickshaw.Graph( {
        element: document.getElementById("chart-smile"),
        width: 600,
        height: 240,
        renderer: 'line',
        series: new Rickshaw.Series.Sliding([{ name: 'smile'}], undefined, {
            maxDataPoints: 100,
            })
        });

        console.log("graph:"+graph);
	    // Render the graph

        console.log("rendering started");

	    graph.render();
	    
        console.log("Graph setup complete");
	 }

    function progressBar() {
        var elem = document.getElementById("myBar");   
        var width = 10;
        var id = setInterval(frame, 700);
        function frame() {
            if (width >= 100) {
            clearInterval(id);
            } else {
            width++; 
            elem.style.width = width + '%'; 
            elem.innerHTML = width * 1  + '%';
            }
        }
    }

    function fetch_data() {
        console.log("Data fetch started");
		  $.ajax({
		  	type: "GET",
		    url: "./stream.php",
		    success: function(e) {
		        var obj = JSON.parse(e);
		      	console.log(obj);
		      	graph.series.addData(obj.series, obj.x);
		        graph.render();
		    }

          });
          console.log("added to graph");

          if(stop != true)
		    {
                setTimeout(fetch_data, 200);
            }else{
                console.log("User stopped");
            }
        }
    
    function loadData(){
        console.log("showing smile score");
        $("#myProgress").hide();
        initiate();
    }

    function getBackgroundStatus() {
        $.ajax({
            type: "GET",
            url: "./backgroundStatus.php",
            success: function(e) {
                console.log(e);
                if(lastModified < parseInt(e) && isLastModifiedSet){
                    console.log("data changed");
                }else{
                    lastModified = parseInt(e);
                    isLastModifiedSet = true;
                }

                if(lastModified == parseInt(e)){
                    console.log("last modified is same");
                    setTimeout(getBackgroundStatus,500);
                }else{
                    console.log("calling load data");
                    loadData();
                }
            }
        });
    }
</script>
</body>
</html>
