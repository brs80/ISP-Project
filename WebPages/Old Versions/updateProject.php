<?php

  $value = json_decode(file_get_contents('php://input'), true);
  updateProject($value['id'], $value['name'],$value['description'],$value['projMgr'], $value['type'],$value['status']); 

?>


<?php

     function updateProject($id, $name, $desc, $projMgr, $type, $status)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql = "UPDATE projects SET clientName='$name', projectDescription ='$desc', projectManager='$projMgr', projectType='$type',projectStatus='$status'   WHERE id=$id";
               echo $sql;
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

