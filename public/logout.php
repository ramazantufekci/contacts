<?php
session_start();
unset($_SESSION["kull"]);
unset($_SESSION["id"]);
header("Location:http://".$_SERVER["HTTP_HOST"]."/");
?>