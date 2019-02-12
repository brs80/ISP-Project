<script src="jquery-2.2.2.js"></script>

<?php
     $servername = "db1.cs.uakron.edu";
     $username = "mar64";
     $password = "goong8Ut";
     $dbname = "ISP_mar64";
     try
     {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          {
             if (isset($_POST['btnAdd']))
             {
                 insertEmployee($_POST['newFirst'],$_POST['newLast'],$_POST['newShort'],$_POST['newEmail']);
             }
             else if (isset($_POST['btnSaveChanges']))
             {

             }
          }
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection

          $sql = "SELECT * FROM projects ORDER BY clientName";
          $result = $conn->query($sql);
?>
          <form method="post">
              <table>
                <tr>
                    <th>
                       ID
                    </th>
                    <th>
                       Client Name
                    </th>
                    <th>
                       Project Description
                    </th>
                    <th>
                       Project Manager
                    </th>
                    <th>
                      Type 
                    </th>
                    <th>
                       Status
                    </th>
                </tr>
<?php
              // output data of each row
              while($row = $result->fetch_assoc()) 
              {
?>
                 <tr id="row<?php echo $row["id"];?>">
                    <td> 
                        <?php echo $row["id"]; ?>
                    </td>
                    <td>
                        <?php echo $row["clientName"];?> 
                    </td>
                    <td>
                        <?php echo $row["projectDescription"];?> 
                    </td>
                    <td>
                        <?php echo lookupEmployee($row["projectManager"]);?> 
                    </td>
                    <td>
                        <?php echo lookupType($row["projectType"]);?> 
                    </td>
                    <td>
                        <?php echo lookupStatus($row["projectStatus"]);?> 
                    </td>
                    <td>
                        <a href="gannt.php?projId=<?php echo $row["id"];?>">View Gannt</a>
                    </td>
                  </tr>
<?php
              }
?>

              </table>
         </form>
<?php
     }
     catch (Exception $ex)
     {
        echo "error connecting to database";
     }
     finally
     {
           $conn->close();
     }
?> 


<?php

     function lookupEmployee($empId)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql= "select id, shortName from employees where id=$empId" ;
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               return $row["shortName"];
              
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

     function lookupType($typeId)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql= "select id, description from types where id=$typeId" ;
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               return $row["description"];
              
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

     function lookupStatus($statusId)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql= "select id, description from status where id=$statusId" ;
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               return $row["description"];
              
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
