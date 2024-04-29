<?php 
   include 'config.php';
    
   
   extract($_POST);

   if (isset($_POST['usernameSend']) && isset($_POST['passwordSend'])){
   
      $sql="INSERT INTO users(username,`password`
      )
      VALUES ('$usernameSend','$passwordSend'
      )";

      $result=mysqli_query($conn,$sql);
   };
?>