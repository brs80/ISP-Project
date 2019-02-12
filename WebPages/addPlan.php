<?php
  $client = $_GET["clientName"];
  $projDesc = $_GET["projectDescription"];
  $projMgr = $_GET["projectManager"];
  $projType = $_GET["projectType"];
  $projStatus = $_GET["status"];
  $dateCreated = date("Y-m-d"); 
//  $value = json_decode(file_get_contents('php://input'), true);
 
//  addTask($value['taskDescription'],$value['respEmployee'],$value['startDate'], $value['endDate'],$value['completed'],$value['comments'],$value['project']); 
  echo $dateCreated;
  $projid = addProject($client,$projDesc,$projMgr,$projType,$dateCreated,$projStatus);

  for($i=1;$i<7;$i++)
  {
     if($_GET["taskDescription$i"]!="") 
        addTask($_GET["taskDescription$i"],$value["respEmployee$i"],$value["startDate$i"], $value["endDate$i"],$value["completed$i"],$value["comments$i"],$projid); 
  }

?>

<?php

     function addProject($client, $projDesc, $projMgr, $projType,$dateCreated,$projStatus)
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
               $sql = "INSERT INTO projects (clientName, projectDescription, projectManager, dateCreated, projectType,projectStatus) VALUES ( '$client', '$projDesc', '$projMgr','$dateCreated', '$projType', '$projStatus') ";
               echo $sql;
               $conn->query($sql);
               $last_id = $conn->insert_id;
               echo "{\"NewId\":$last_id}";
               echo $resp;
               return $last_id;
 
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

