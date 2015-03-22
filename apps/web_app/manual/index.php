<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css" />
<title>Step by Step</title>

<link rel="stylesheet" type="text/css" href="demo.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>

<!--[if lte IE 7]>
<style type="text/css">
ul li{
	display:inline;
	/*float:left;*/
}
</style>
<![endif]-->

</head>

<body>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#appId=146472442045328&amp;amp;xfbml=1"></script>
<div id="fblogin" align="right" style="display:none;margin:10px 10px 10px 10px;">
<fb:login-button onlogin="window.location='../index.php';" size="large" show-faces="false" width="300" max-rows="1" perms="offline_access,email,user_status,user_website,user_birthday,user_location,user_hometown,publish_stream,read_stream,
						friends_birthday,friends_status,friends_hometown,friends_location,friends_website,user_photos,friends_photos">
</fb:login-button>
<script type="text/javascript">
	FB.init({appId: '146472442045328', status: true,
               cookie: true, xfbml: true});
	FB.getLoginStatus(function(response) {
	  if (!response.session) {
			document.getElementById('fblogin').style.display = 'block';
	}
	});
</script>
</div>
<div id="main">

  <h1>Manual</h1> 
  <div id="gallery">
	
    <div id="slides">
    
    <div class="slide"><img src="img/sample_slides/intro.jpg" width="700"  height="400" alt="side" /></div>
    <div class="slide"><img src="img/sample_slides/web1.jpg" width="700"  height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web2.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web3.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web4.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web5.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web6.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web7.jpg" width="700"   height="400" alt="side" /></div>
	<div class="slide"><img src="img/sample_slides/web8.jpg" width="700"   height="400" alt="side" /></div>
    <div class="slide"><a href="../step1.php" target="_self"><img src="img/sample_slides/web9.jpg" width="700"   height="400" alt="side" /></a></div>
      
    </div>
    
    <div id="menu">
    
    <ul>
        <li class="fbar">&nbsp;</li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/intro-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web1-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web2-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web3-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web4-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web5-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web6-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web7-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web8-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
		<li class="menuItem"><a href=""><img src="img/sample_slides/web9-tn.jpg" width="45"  height="29" alt="thumbnail" /></a></li>
    </ul>
    
    
    </div>
    
  </div>
    
</div>
<div id="lets_go" align=center><a href="../step1.php"  target="_self">Skip</a></div>
</body>
</html>
