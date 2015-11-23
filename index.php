<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Geo Image Search | Flickr, Instagram & Google Maps API Mashup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/lightbox.min.js"></script>


    <style>
    
    /*
    *
    *@Author Keith Holt - x12470008
    *API Mashup Cloud Computing
    * API 1 - Google Maps - Gets GEO Coordinates based on user inputted location
    * API 2 - Instagram - Gets all images that where uploaded from that location based on the geo data
    * API 3 - Flickr - Get all images that were uploaded from the location based on the geo data
    */

.container {
  width: auto;
  max-width: 800px;
  padding: 0 15px;
}
.container .text-muted {
  margin: 20px 0;
}
#return-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.7);
    width: 50px;
    height: 50px;
    display: block;
    text-decoration: none;
    -webkit-border-radius: 35px;
    -moz-border-radius: 35px;
    border-radius: 35px;
    display: none;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top span {
    color: #fff;
    margin: 0;
    position: relative;
    left: 16px;
    top: 13px;
    font-size: 19px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top:hover {
    background: rgba(0, 0, 0, 0.9);
}
#return-to-top:hover span {
    color: #fff;
    top: 5px;
}
.image-block {
    border:  2px solid white ;
    padding: 0px;    
    margin: 0px;
    height:250px;
    text-align: center;
    vertical-align: bottom;
    filter: gray; /* IE6-9 */
    -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
}
.image-block > p {
    width: 100%;
    height: 100%;
    font-weight: normal;
    font-size: 19px;
    padding-top: 180px;
    background-color: rgba(3,3,3,0.0);
    color: rgba(6,6,6,0.0);
}
.image-block:hover{
	    filter: none; /* IE6-9 */
    -webkit-filter: grayscale(0); /* Google Chrome, Safari 6+ & Opera 15+ */
}
.image-block:hover > p {
    background-color: rgba(3,3,3,0.2);    
    color: white;    
}
</style>
</head>
<body>
<a href="javascript:" id="return-to-top"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>


<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom:50px;">
  <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">Geo Image Search</a><p class="navbar-text ">Find images based on Geo Location via Flickr & Instagram</p>
        </div>
        </div>
    </nav>
<div class="col-lg-12" style="margin-bottom:30px;margin-top:70px;">
	
 

          <form class="col-lg-12" action="" method="get" accept-charset="utf-8">
            <div class="input-group input-group-lg col-sm-offset-4 col-sm-4">
              <input type="text" class="center-block form-control input-lg" title="Enter A Loaction Name." name="location" placeholder="Enter A Location Name (E.g. Dublin)">
              <span class="input-group-btn"><button class="btn btn-lg btn-primary" type="submit">Find Images!</button></span>
            </div>
          </form>


</div>

 
 <p style="text-align:center; padding-top:40px;"> Simply enter a location in the input box above and click 'Find Images' and get images that were geo tagged in that location </p>
 
<?php


//check if the user input is empty

if(!empty($_GET['location'])){

	//setting the APII URL using their API but including the location from the user input
	//if its not empty
  $maps_url = 'https://'.
  'maps.googleapis.com/'.
  'maps/api/geocode/json'.
  '?address=' . urlencode($_GET['location']);

  //setting the results to a json file
  $maps_json = file_get_contents($maps_url);
  //decoding the json file into an array, true = results into an array and not into an object
  $maps_array = json_decode($maps_json,true);
  $lat = $maps_array['results'][0]['geometry']['location']['lat'];
  $lng = $maps_array['results'][0]['geometry']['location']['lng'];

  $perPage = 50;
  $api_key = "96f95c0cbbbb5053776b4d3f3a78c967";
  $flickr_url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$api_key.'&lat='.$lat.'&lon='. $lng .'&accuracy=1&sort=relevance&format=json&per_page='.$perPage .'$safe_search=1&has_geo=&nojsoncallback=1';


$response = json_decode(file_get_contents($flickr_url));
$photo_array = $response->photos->photo;


$instagram_url = 'https://'.
    'api.instagram.com/v1/media/search' .
    '?lat=' . $lat .
    '&lng=' . $lng .
    '&distance=1000&count='.$perPage.'&client_id=abdb20b1e5a14794b31666c76d5f6f64'; //replace "CLIENT-ID"


  $instagram_json = file_get_contents($instagram_url);
  $instagram_array = json_decode($instagram_json, true);


?>

 <div class="container">
 <br /><br />
    <div class="row">

<?php


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

    	$photo_url = 'http://farm'.$farm_id.'.staticflickr.com/'.$server_id.'/'.$photo_id.'_'.$secret_id.'_'.$size.'.'.'jpg';
    	$flickr_img= 'http://findicons.com/files/icons/2155/social_media_bookmark/32/flickr.png';

    	print '<a href="'.$photo_url.'"  data-toggle="lightbox" data-footer="'.$title.'"><div class="image-block col-sm-3" style="background: url('.$photo_url.') no-repeat center top;background-size:cover;"><p style="font-size:12px;"> '.$title.' </p></div></a>';



    }
}

    ?>


 
		
    </div>
</div>

<?php
}
 ?>
<!-- Responsive Gallery - END -->
<script>

$(document).delegate('*[data-toggle="lightbox"]','click', function(){

event.preventDefault();
$(this).ekkoLightbox();


});	

// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});
</script>
 

</body>
 
</html>
