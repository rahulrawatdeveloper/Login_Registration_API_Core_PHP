<?php

//getting the database connection.
require_once 'DbConnect.php';

//an array to display response.
$response = array();

// if it is an api call.
//that means a get parameter named apicall is set in the URL.
//and with this parameter we are concluding that it is an api call.

if(isset($_GET['apicall'])) {
	
	switch($_GET['apicall']) {
		
		case 'login':
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		$stmt = $conn->prepare("select id, username, email, gender from users where username = ? AND password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows > 0) {
		
		$stmt->bind_result($id,$username,$email,$gender);
		$stmt->fetch();
		
		$user = array(
		'id'=>$id,
		'username'=>$username,
		'email'=>$email,
		'gender'=>$gender,
		
		);
				$response['error'] = false;
			$response['message'] = "Login successfully";
				$response['user'] = $user;
		
		
		} else {
					$response['error'] = true;
			$response['message'] = "Invalid username and password";
	
		}
		
		
		break;
		case 'registration' :
		
		//getting the values from POST.
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$gender = $_POST['gender'];
		
		$stmt = $conn->prepare("select id from users where username = ? OR email = ?");
		$stmt->bind_param("ss", $username, $email);
		$stmt->execute();
		$stmt->store_result();
		
		//if the user already exits in the database
		if($stmt->num_rows > 0) {
				$response['error'] = true;
			$response['message'] = "user already registered";
			$stmt->close();
		} else {
		
		$stmt = $conn->prepare("INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)");
 $stmt->bind_param("ssss", $username, $email, $password, $gender);
 	
			//if the user is successfully added to the database.
			if($stmt->execute()) {
				$response['error'] = false;
			$response['message'] = "User registered successfully";
				
			} else {
				$response['error'] = true;
				$response['message'] = "required parameters are not available";
			}
		}
		 break;
		
	}
} else {
	//if it is not api call.
	//pusing error values.
	$response['error'] = true;
	$response['message'] = "invalid api call";
	
}
echo json_encode($response);

?>