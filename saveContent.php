<?php
session_start();
$target_dir = "assets/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$_SESSION['target_file'] = $target_file;
$fileName = basename($_FILES["fileToUpload"]["name"]);
$_SESSION['fileName'] = $fileName;
//echo 'Filename is : '.$fileName;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
}

$description = $_POST['description'];
$id = $_SESSION['id'];
include('conn.php');
if(!isset($_SESSION['saveContentID'])){
	$sql = "INSERT INTO `userContent` values('',$id,'$description','$target_file','')";
	$conn->query($sql);
//echo "Inserted id Last : ".mysqli_insert_id($conn);
	$_SESSION['saveContentID'] = mysqli_insert_id($conn);
}
else{
	$saveContentID = $_SESSION['saveContentID'];
	$sql = "UPDATE `userContent` SET description='$description',picture_url='$target_file' WHERE id='$saveContentID'";
	$conn->query($sql);
	//if($conn->query($sql))
		//echo "Success";
	//else
		//echo "Failure";
}
mysqli_close($conn);
// echo $description;
// var_dump($_POST);
// var_dump($_FILES);

//header('location:showPreview.php?contentId='.$_SESSION['saveContentID']."&target_file=".$target_file."&description=".$description);
header('location:showPreview.php?contentId='.$_SESSION['saveContentID']);
?>
