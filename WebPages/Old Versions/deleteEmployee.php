<?php

  $data = json_decode(file_get_contents('php://input'), true);
  echo $data; 
  deleteEmployee($data);
?>

<?php

     function deleteEmployee($id)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql ="DELETE FROM employees WHERE id=$id" ;
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

