<?php

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

	//setting a variable with the results from latitude
	$lat = $maps_array['results'][0]['geometry']['location']['lat'];
	
	//setting a variable with the results from longitude
	$lng = $maps_array['results'][0]['geometry']['location']['lng'];


	//Setting the number of results to be returned per api request
	$perPage = 50;

	//------------------------
	//Flickr API
	//------------------------
	//Setting a variable for the api key for easy management
	$api_key = "96f95c0cbbbb5053776b4d3f3a78c967";

	//Setting the url for the flicker api request url containing the $lat and $lng variables set above
	$flickr_url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$api_key.'&lat='.$lat.'&lon='. $lng .'&accuracy=1&sort=relevance&format=json&per_page='.$perPage .'$safe_search=1&has_geo=&nojsoncallback=1';

	//Decoding the json response into a useable array of information
	$response = json_decode(file_get_contents($flickr_url));
	
	//Setting the response from to an array and pulling the photo variable
	$photo_array = $response->photos->photo;

	//------------------------
	//Instagram API
	//------------------------
	//Setting the url for the instagram api request url containing the $lat and $lng variables set above
	$instagram_url = 'https://'.
    'api.instagram.com/v1/media/search' .
    '?lat=' . $lat .
    '&lng=' . $lng .
    '&distance=1000&count='.$perPage.'&client_id=abdb20b1e5a14794b31666c76d5f6f64';
	
	//Decoding the json response into a useable array of information
    $instagram_json = file_get_contents($instagram_url);

    //decoding the json file into an array, true = results into an array and not into an object
    $instagram_array = json_decode($instagram_json, true);

 ?>