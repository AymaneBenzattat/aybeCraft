<?php

if(isset($_GET["username"])){
    $pieces = explode(".", $_GET["username"]);
    $username= $pieces[0];
    echo $username;
}
else{
    echo "404";
}
echo "<br>";
$url = explode("/", $_GET["url"]);
foreach($url as $piece){
    echo $piece."=>";
}

?>