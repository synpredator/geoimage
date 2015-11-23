<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Geo Image Search - Find Images taken in a location quick and Easy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/main.css" />

</head>
<body>
<a href="javascript:" id="return-to-top"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>


<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom:50px;">
  <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a href="index.php" class="navbar-brand">Geo Image Search</a><p class="navbar-text ">Find images based on Geo Location via Flickr & Instagram</p>
        </div>
        </div>
    </nav>
<div class="col-lg-12" style="margin-bottom:30px;margin-top:70px;">
	
 

          <form class="col-lg-12" action="" method="get" accept-charset="utf-8">
            <div class="input-group input-group-lg col-sm-offset-4 col-sm-4">
              <input type="text" class="center-block form-control input-lg" title="Enter A Loaction Name." name="location" placeholder="Enter A Location Name (E.g. Dublin)" required="">
              <span class="input-group-btn"><button class="btn btn-lg btn-primary" type="submit">Find Images!</button></span>
            </div>
          </form>


</div>

 
 <p style="text-align:center; padding-top:40px;"> Simply enter a location in the input box above and click 'Find Images', Quick and Easy way to find images geo tagged in a location.</p>

<?php
//check if the user input is empty
//Pulling the API.php file which does all the restful commands

if(!empty($_GET['location'])){

	require ('api.php');
?>

 <div class="container">
 	<div class="row">


<?php
	//Pulling and displaying the data from the API.php returns
	//Make sure the Instagram URL is not empty
    if(!empty($instagram_array)){
    	foreach($instagram_array['data'] as $key=>$image){
    		print '<a href="'.$image['images']['standard_resolution']['url'].'"   data-toggle="lightbox"  data-footer="'.$image['caption']['text'].'"><div class="image-block col-sm-3" style="background: url('.$image['images']['standard_resolution']['url'].') no-repeat center top;background-size:cover;"><p style="font-size:12px;"> '.$image['caption']['text'].' </p></div></a>';
    	}
    }
 	
 	if(!empty($photo_array)){
 		foreach ($photo_array as $single_photo){
 			$farm_id = $single_photo->farm;
 			$server_id = $single_photo->server;
 			$photo_id = $single_photo->id;
 			$secret_id = $single_photo->secret;
 			$size = 'c';
 			$title = $single_photo->title;

 			$photo_url = 'https://farm'.$farm_id.'.staticflickr.com/'.$server_id.'/'.$photo_id.'_'.$secret_id.'_'.$size.'.'.'jpg';
    	 

    	print '<a href="'.$photo_url.'"  data-toggle="lightbox" data-footer="'.$title.'"><div class="image-block col-sm-3" style="background: url('.$photo_url.') no-repeat center top;background-size:cover;"><p style="font-size:12px;"> '.$title.' </p></div></a>';



    	}
	}

?>


    </div>
</div>

<?php
}
 ?>


<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap/js/lightbox.min.js"></script>
<script type="text/javascript" src="js/scrollToTop.js"></script> 
<script type="text/javascript" src="js/lightbox.js"></script>

</body>
</html>