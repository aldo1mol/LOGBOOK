<?php 
   include 'config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM device WHERE id=$user_id";
      $result=mysqli_query($conn,$sql);
      $response=array();
      while($row=mysqli_fetch_assoc($result)){
          $response=$row;
      }
      echo json_encode($response);
      }else{
          $response['status']=200;
          $response['message']="Invalid or data not found";
      }
      

      // update query
        if(isset($_POST['deviceId'])){
            $uniqueid=$_POST['deviceId'];
            $devicename=$_POST['editDevicename'];
            
            $sql="UPDATE device SET device_name='$devicename' WHERE id=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>