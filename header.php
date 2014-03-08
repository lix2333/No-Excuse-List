<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html class="no-js" lang="en">
  <?php include_once("includes/functions.php");
      
    $url = mysql_real_escape_string($_REQUEST['url']);
    // Grab url information
      $query = mysql_query("SELECT * FROM links WHERE link='$url'");
      $r = mysql_fetch_array($query);
      $id = $r['id'];
      $title = $r['title'];
      $loves = $r['loves'];
      $icons = array('normal','recommended','paid');
      $type = $icons[$r['type']];
      $cat = strtolower(categoryName($r['category']));
  
  
  ?>
  
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="The best place on the web to learn anything, free." />
    <meta name="keywords" content="no excuse list, learn, free, lectures, resource, classes" />
    <title>No Excuse List</title>
    <link rel="stylesheet" href="css/app.css" />
    <link rel="stylesheet" href="css/main2.css" />
    <link rel="stylesheet" href="css/mm.css" />
    <link type="image/x-icon" href="favicon.ico" rel="icon"></link>
    
    <script src="bower_components/modernizr/modernizr.js"></script>
</head>

  <body>
	  <div class="show-for-medium-up"  style="height: 45px;">
	      <div class="contain-to-grid fixed">
        <nav class="top-bar" data-topbar>

            <ul class="title-area" style='width:10%;'>
                <li class="name">
                    <a href="<?php echo $base_url; ?>">
						<div class="hide-for-medium-only hide-for-small-only">
                        <img src="img/logo.png" alt="" title="" /></div>
                        <div class="hide-for-large-up">
                        <h2 style="color: rgb(255, 255, 255); line-height: 45px; font-weight: 600; padding-left: 5px;">N<span style="color:#ff2a43;">E</span>L</h2></div>
                    </a>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a>
                </li>
            </ul>
            <section class="top-bar-section" style="width: 87%; float: right;">
                <!-- Right Nav Section -->
                <ul class="right">
                    <li class="divider"></li>
                    
                     <?php
          if(isset($_SESSION['username'])){
            $pages = array("home","blog","account","about");
          } else {
            $pages = array("home","blog","about");

          }
          foreach($pages as $p){
            $pretty = ucfirst($p);
            if($p == "home"){
              $p = "";
            }
			if ($p == "blog"){
				$p = "blog/";
			}
            if($p == "account"){
              $p = "forum/profile/".$_SESSION['username'];
            }
            
            echo "<li class='show-for-medium' style='width: 10%;'><a href='$base_url{$p}'"; if(strtolower($pretty) == $title){echo " class='a'";}echo ">$pretty</a></li><li class=\"divider\"></li>";
            echo "<li class='show-for-large-up'><a href='$base_url{$p}'"; if(strtolower($pretty) == $title){echo " class='a'";}echo ">$pretty</a></li><li class=\"divider\"></li>";
          }
        ?>
        
       
        
        
        
                    <li class="has-form show-for-medium" style="width: 48%;">
        <form action='results' method='post' id='searchForm'>
          <div class="row collapse" id='searchHolder'>
			  
            <div class="large-8 small-9 columns">
              <input type='text' name='s' id='searchField' placeholder='What do you want to learn?' size="40"/>
            </div>
            <div class="large-4 small-3 columns">
              
              <a  href="#" onclick="$(this).closest('form').submit()" class="button alert expand">Search</a>
            </div>
          </div>
        </form>
      </li>
      <li class="has-form show-for-large-up">
        <form action='results' method='post' id='searchForm'>
          <div class="row collapse" id='searchHolder'>
			  
            <div class="large-8 small-9 columns">
              <input type='text' name='s' id='searchField' placeholder='What would you like to learn today?'  size="45"/>
            </div>
            <div class="large-4 small-3 columns">
              
              <a  href="#" onclick="$(this).closest('form').submit()" class="button alert expand">Search</a>
            </div>
          </div>
        </form>
      </li>
                   
                </ul>
                <!-- Left Nav Section -->
                <ul class="left">

                </ul>
            </section>
        </nav>
    </div></div>
    
    
    
    
    <div class="show-for-small-only">
    
    <div class="contain-to-grid fixed">
        <nav class="top-bar" data-topbar>

            <ul class="title-area">
                <li class="name" style="width:0px;">
                    <a href="<?php echo $base_url; ?>">
						
                        <h2 style="color: rgb(255, 255, 255); line-height: 45px; font-weight: 600; padding-left: 5px;">N<span style="color:#ff2a43;">E</span>L</h2>
                    </a>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#" style="width:100%"><span>Menu</span></a></li>
            </ul>
            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    <li class="divider"></li>
                    
                     <?php
          if(isset($_SESSION['username'])){
            $pages = array("home","blog","forum","account","about","logout");
          } else {
            $pages = array("home","blog","forum","about","login");

          }
          foreach($pages as $p){
            $pretty = ucfirst($p);
            if($p == "home"){
              $p = "";
            }
			if ($p == "blog"){
				$p = "blog/";
			}
            if($p == "account"){
              $p = "forum/profile/".$_SESSION['username'];
            }
            if($p == "login"){
              $p = "forum/entry/signin?Target=discussions";
            }
            if($p == "logout"){
              $p = "forum".$_SESSION['logoutURL'];
            }
            echo "<li><a href='$base_url{$p}'"; if(strtolower($pretty) == $title){echo " class='a'";}echo ">$pretty</a></li><li class=\"divider\"></li>";
          }
        ?>
        
       
        
        
        
                    <li class="has-form">
        <form action='results' method='post' id='searchForm'>
          <div class="row collapse" id='searchHolder'>
			  
            <div class="large-8 small-9 columns">
              <input type='text' name='s' id='searchField' placeholder='What do you want to learn?'  />
            </div>													   
            <div class="large-4 small-3 columns">
              
              <a  href="#" onclick="$(this).closest('form').submit()" class="button alert expand">Search</a>
            </div>
          </div>
        </form>
      </li>
                    <li class="divider"></li>
                </ul>
                <!-- Left Nav Section -->
                <ul class="left">

                </ul>
            </section>
        </nav>
    </div></div>
    <div id="fullpage">
     <div class="row"><div class="small-12 columns text-center show-for-medium-up" style="padding: 50px 0px 40px;">
		<h2>The best place on the web to learn anything, <span style="color:#ff2a43;font-weight:600;">free.</span></h2>
		</div>
		<div class="small-12 columns text-center show-for-small-only" style="padding: 15px 0px 15px;">
		<h2>The best place on the web to learn anything, <span style="color:#ff2a43;font-weight:600;">free.</span></h2>
		</div>
		
		</div>
	
