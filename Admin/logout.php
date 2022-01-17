<?php 
 
 session_start();
 require './helpers/functions.php';

 //require 'checkLogin.php';
 
 session_destroy();

 header("location: ".Url('/login.php'));


?>

