<?php

$servername = "localhost";
$username = "root";
$password = "1234";
$db_name = "treeplant";

$conn = new mysqli($servername, $username, $password, $db_name);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// $sql =  "SELECT * from user";
// $result = $conn->query($sql);


// if($result->num_rows>0){
// 	while($row = $result->fetch_assoc()){
// 		echo "<br>id:".$row['fb_id']."<br>";
// 		echo "name:".$row['fb_name']."<br>";
// 		echo "path:".$row['fb_profile_pic_path']."<br>";
// 	}
// }

// $conn->close();


/*
Insert multiple records
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com');";
$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Mary', 'Moe', 'mary@example.com');";
$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Julie', 'Dooley', 'julie@example.com')";

if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
*/
?>