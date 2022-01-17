<?php 

  if($_SESSION['user']['role_id'] != 2){
     header("Location: ".Url());
  }

?>