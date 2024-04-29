<?php 
   include 'config.php';

   if(isset($_POST['updateid'])){
      $user_id=$_POST['updateid'];

      $sql="SELECT * FROM users WHERE id=$user_id";
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
        if(isset($_POST['userId'])){
            $uniqueid=$_POST['userId'];
            $username=$_POST['editUsername'];
            $password=$_POST['editPassword'];

            

            $sql="UPDATE users SET username='$username',password='$password' WHERE id=$uniqueid";

            $result=mysqli_query($conn,$sql);

        }
?>