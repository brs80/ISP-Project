<?php


  $value = json_decode(file_get_contents('php://input'), true);
  updateTask($value['id'], $value['taskDescription'],$value['respEmployee'],$value['startDate'], $value['endDate'],$value['completed'],$value['comments']); 

?>


<?php

     function updateTask($id, $desc, $resp, $start, $end, $comp, $comments)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          if($comp==1)
            $comp='true';
          else
            $comp='false';
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql = "UPDATE tasks SET taskDescription='$desc', respEmployee ='$resp', startDate='$start', endDate='$end', completed=$comp, comments='$comments' WHERE id=$id";
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

