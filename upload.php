<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
$target_name = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_name,PATHINFO_EXTENSION));
$target_dir = "uploads/$name." . $imageFileType;
$target_file = $target_dir;
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
include("deleteall.php");
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$lines = file('names.txt');
		$rand = $lines[array_rand($lines)];
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
		$content = "<html>\n<head>\n<script>\nfunction getVote(int) {\n  var xmlhttp=new XMLHttpRequest();\n  xmlhttp.onreadystatechange=function() {\n    if (this.readyState==4 && this.status==200) {\n      document.getElementById(\"poll\").innerHTML=this.responseText;\n    }\n  }\n  xmlhttp.open(\"GET\",\"poll_vote.php?vote=\"+int,true);\n  xmlhttp.send();\n}\n</script>\n</head>\n<body>\n<div id=\"poll\">\n<h3>Who is it?</h3>\n<img src=\"uploads/$name.$imageFileType\"/>\n<form>\n$name: <input type=\"radio\" name=\"vote\" value=\"0\" onclick=\"getVote(this.value)\"><br>\n$rand: <input type=\"radio\" name=\"vote\" value=\"1\" onclick=\"getVote(this.value)\">\n</form>\n<br>\n";
		$fh = fopen('index.php', 'w');
		fwrite($fh, $content);
		fclose($fh);
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>