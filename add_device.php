<?php 
   include 'config.php';
    
   
   extract($_POST);

   if (isset($_POST['devicenameSend'])){
   
      $sql="INSERT INTO device(device_name)
      VALUES ('$devicenameSend')";

      $result=mysqli_query($conn,$sql);
   };
?>