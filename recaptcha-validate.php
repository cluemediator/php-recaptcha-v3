<?php 
$name = $_POST['name'];
$email = $_POST['email'];
$token = $_POST['token'];

if(!$token){
	echo '<h2>Please check the captcha form.</h2>';
	exit;
}

$secretKey = "<YOUR_SECRET_KEY>";

// post request to server
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array('secret' => $secretKey, 'response' => $token);

$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data)
	)
);
$context  = stream_context_create($options);
$response = file_get_contents($recaptcha_url, false, $context);
$responseKeys = json_decode($response,true);

if($responseKeys["success"]) {
	// Database connection
	$con = mysqli_connect("localhost", "root", "" , "demo") or die($con);
	// Insert data into database
	$sql = "INSERT INTO user_data (name, email) VALUES ('$name', '$email')";
	mysqli_query($con,$sql);
	$output['success'] = true;
  $output['msg'] = "Your form has been successfully submitted.";
} else {	
	$output['success'] = false;
  $output['msg'] = "You are robot!";
}
echo json_encode($output);
?>
