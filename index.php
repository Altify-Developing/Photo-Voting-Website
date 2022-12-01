<html>
<head>
<script>
function getVote(int) {
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("poll").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","poll_vote.php?vote="+int,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<div id="poll">
<h3>Who is it?</h3>
<img width="50%" height="50%" src="uploads/nicolas.png"/>
<form>
nicolas: <input type="radio" name="vote" value="0" onclick="getVote(this.value)"><br>
Quinton
: <input type="radio" name="vote" value="1" onclick="getVote(this.value)">
</form>
</div>