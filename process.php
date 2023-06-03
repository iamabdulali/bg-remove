<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$imageUrl = 'https://d5nunyagcicgy.cloudfront.net/external_assets/hero_examples/hair_beach_v391182663/original.jpeg';
$imageFilePath = 'path/to/image';
$token = '647686db8e8c36.81080366';





$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.removal.ai/3.0/remove',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => array(
   'image_url' => $_POST["base64Data"],
  //  'image_url' => $_POST["base64Data"],
  //  'image_url' => $imageUrl,
  ),
  CURLOPT_HTTPHEADER => array(
    'Rm-Token: ' . $token,
  ),
));

try {
  $response = curl_exec($curl);
  $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  if ($httpCode == 200) {
     $responseData = json_decode($response, true);
    $highResolutionUrl = $responseData['url'];
    $imageData = file_get_contents($highResolutionUrl);
	if ($imageData !== false) {
	  // Convert the image data to base64
	  $base64Data = base64_encode($imageData);
	  echo $base64Data;
	} else {
	  ///echo "Failed to retrieve image data.";
	}
  } else {
    echo 'Unexpected HTTP status: ' . $httpCode;
  }
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}

curl_close($curl);


