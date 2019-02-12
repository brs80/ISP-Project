<?php


  $value = json_decode(file_get_contents('php://input'), true);
  addTask($value['taskDescription'],$value['respEmployee'],$value['startDate'], $value['endDate'],$value['completed'],$value['comments'],$value['project']); 

?>


<?php

     function addTask($desc, $resp, $start, $end, $comp, $comments, $proj)
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
               $sql = "INSERT INTO tasks (taskDescription, respEmployee, startDate, endDate, completed, comments, project) VALUES ( '$desc', '$resp', '$start', '$end', $comp, '$comments', '$proj') ";
               //echo $sql;
               $conn->query($sql);
               $last_id = $conn->insert_id;
               echo "{\"NewId\":$last_id}";
 
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

