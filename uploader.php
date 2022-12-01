<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
	<p><span title='Required' class="error">* required field</span></p>
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
	<br><br>
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span title='Required' class="error">* <?php echo $nameErr;?></span>
  <br><br>
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>