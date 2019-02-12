<link rel="stylesheet" type="text/css" href="newcss.css">

<script src="jquery-2.2.2.js"></script>
<style>
  table, th, tr, td{
  }
</style>
                  <div id='banner'>
                        <div class="fpic">
                            <img  class="fpic" src="https://cdn3.iconfinder.com/data/icons/medcare/512/table-512.png">
                        </div>

                        <div id="abanner">
                            <table id="bannertable">
                                <tr>
                                    <td class="tdbanner"><a href="addNewProjectPlan.php"><h2>Add A Project</h2></a></td>
                                    <td class="tdbanner"><a href="projectSearch.php"><h2>View/Edit Projects</h2></a></td>
                                    <td class="tdbanner"><a href="taskList.php"><h2>View Task List</h2></a></td>
                                    <td class="tdbanner"><a href="employees.php"><h2>Add/Edit Employees</h2></a></td>

                                </tr>
                            </table>
                        </div>

                    </div>

    <script>
        var FindMatches=function()
        {
            var searchstring = $("#SearchBox").val().toLowerCase();
            console.log(searchstring);
            $('.DataRow').each(function () {
                var clientName = $(this).children('.ClientName').html().toLowerCase();
                var projectDescription = $(this).children('.ProjectDescription').html().toLowerCase();
                //console.log(value);
                if((clientName.search(searchstring)==-1)&&(projectDescription.search(searchstring)==-1))
                    $(this).hide()
                else
                    $(this).show()
            });

        }

	var deleteProject = function(id){
     	$.post("deleteProject.php",JSON.stringify(id));      
     	$('#row'+id).remove();
  }
    </script>

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
	<div id="searchdiv">
             Find:  <input id="SearchBox" oninput="FindMatches()">
	</div>
              <table id="employeetable">
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
                    <th>
                    </th>
                </tr>
<?php
              // output data of each row
              while($row = $result->fetch_assoc()) 
              {
?>
                 <tr class="DataRow tdspace" id="row<?php echo $row["id"];?>">
                    <td> 
                        <?php echo $row["id"]; ?>
                    </td>
                    <td class="ClientName tdspace">
                        <?php echo $row["clientName"];?> 
                    </td>
                    <td class="ProjectDescription tdspace">
                        <?php echo $row["projectDescription"];?> 
                    </td>
                    <td class="tdspace">
                        <?php echo lookupEmployee($row["projectManager"]);?> 
                    </td>
                    <td class="tdspace">
                        <?php echo lookupType($row["projectType"]);?> 
                    </td>
                    <td class="tdspace">
                        <?php echo lookupStatus($row["projectStatus"]);?> 
                    </td>
                    <td class="tdspace">
                        <a href="projectPlan.php?projId=<?php echo $row["id"];?>">View Project Plan</a>
                    </td>
                    <td class="tdspace">
                        <button type="button" id="btnDelete" name="btnDelete"  onclick="deleteProject(<?php echo $row["id"];?>)">Delete</button>
                    </td>
                  </tr>
<?php
              }
?>

              </table>
         </form>
         
<?php 
    function deleteEmployee($statusId) { 
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
