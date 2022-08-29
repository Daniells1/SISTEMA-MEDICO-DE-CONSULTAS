<?php 
if(isset($_GET["m"]) && $_GET["m"] !=""){
    echo "<div id='message'>" . base64_decode($_GET["m"]) . "</div>";
}
