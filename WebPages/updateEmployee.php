<?php

  $data = json_decode(file_get_contents('php://input'), true);
  foreach($data as $value)
  {
      updateEmployee($value['id'], $value['first'],$value['last'],$value['short'],$value['email']); 
      echo "updated " . $value['id'];
  }

?>


<?php

     function updateEmployee($id,$first, $last, $short, $email)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
            echo "in insertRecord";
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql = "UPDATE employees SET firstName='$first', lastName='$last', shortName='$short',email='$email'   WHERE id=$id";
               $conn->query($sql);
          }
          catch (Exception $ex)
          {
             echo "error connecting to database";
          }
          finally
          {
                $conn->close();
          }

     }

?>

