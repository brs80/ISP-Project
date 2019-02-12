<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php
  $employees=loadEmployees();
  $statuses=loadStatuses();
  $types=loadTypes();

  function createSelector($arr,$name, $id, $class)
  {
    echo "<select name=\"$name\" class=\"$class\">";
    foreach($arr as $key => $value)
    {
      echo "<option value=\"$key\">$value</option>";
    }
  
    echo "</select>";
  }


  function loadEmployees()
  {
     $servername = "db1.cs.uakron.edu";
     $username = "mar64";
     $password = "goong8Ut";
     $dbname = "ISP_mar64";
     try
     {
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection

          $sql = "SELECT * FROM employees ";
          $result = $conn->query($sql);
          $emp=array();
          while($row = $result->fetch_assoc())
             $emp[$row["id"]]=$row["shortName"];
          return $emp;
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

 function loadStatuses()
  {
     $servername = "db1.cs.uakron.edu";
     $username = "mar64";
     $password = "goong8Ut";
     $dbname = "ISP_mar64";
     try
     {
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection

          $sql = "SELECT * FROM status ";
          $result = $conn->query($sql);
          $statuses=array();
          while($row = $result->fetch_assoc())
             $statuses[$row["id"]]=$row["description"];
          return $statuses;
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

 function loadTypes()
  {
     $servername = "db1.cs.uakron.edu";
     $username = "mar64";
     $password = "goong8Ut";
     $dbname = "ISP_mar64";
     try
     {
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection

          $sql = "SELECT * FROM types ";
          $result = $conn->query($sql);
          $types=array();
          while($row = $result->fetch_assoc())
             $types[$row["id"]]=$row["description"];
          return $types;
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





<html>
    <head>
        <title>ISP Project Project Plan</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="newcss.css">
    </head>
    <body>
        <form action="addPlan.php">
            <div id="wrapper">
                <div id='upwrapper'>


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

                    <table id='table1'>
                        <tr>
                            <td>Client Name: <input type="text" id="cname" name="clientName"></td>
                        </tr>

                        <tr>
                            <td>Description:    <input type="text" id="desc" name="projectDescription"></td>
                        </tr>

                        <tr>
                            <td>
                                Status: 
  <?php createSelector($statuses,"status","",""); ?>
                                Project Manager:    
  <?php CreateSelector($employees,"projectManager", "manager", ""); ?>


                            </td>
                        </tr>

                        <tr>
                            <td> Project Type:
  <?php CreateSelector($types,"projectType", "projecttype", ""); ?>
                            </td>
                        </tr>
                    </table>

                </div>
                    <div id="tabs" style='margin:'>
                         <ul class="tab">
                            <li><a href="#" class="tablinks" onclick="openTab(event, 'Tasks')">Tasks</a></li>
                            <li><a href="#" class="tablinks" onclick="openTab(event, 'Other')">Other Information</a></li>
                          </ul>

                          <div id='Tasks' class="tabcontent">
                              <table id='tasktable'>
                                  
                                  <!-- First Table row -->
                                  <tr class="tablehead" id='toptablehead'>
                                       <td class='tdspace'>Task</td>
                                       <td class='tdspace'>Start Date</td>
                                       <td class='tdspace'>Due Date <br>
                                           Original Due Date</td>
                                       <td class='tdspace'>Resp Indv Extensions</td>
                                       <td class='tdspace'>Current Status</td>
                                       <td class='tdspace'>Completed</td>
                                       <td class='tdspace'></td>
                                       
                                  </tr>
                                  
                                  <!-- This is the beginning of 7 copies for the first tab -->
                                
<?php
   for($i=1;$i<6;++$i)
   {
?>
                                  <tr class="tablehead">
                                      <td class='tdspace'><textarea name="taskDescription<?php echo $i;?>" class='taskfield'></textarea></td>
                                       <td class='tdspace'><input name="startDate<?php echo $i;?>" type="text" class='startdate'></td>
                                       <td class='tdspace'><input name="endDate<?php echo $i;?>" type="text" class='duedate'><br>
                                       <td class='tdspace'>
  <?php CreateSelector($employees,"respEmployee$i", "respEmployee$i", "selectfield"); ?>
                                            <br>
                                       <td class='tdspace'><textarea name="comments<?php echo $i;?>" class='statusfield'></textarea></td>
                                       <td class='tdspace'>
                                           <input name="completed<?php echo $i;?>" type="checkbox" class='completedbox'><br>
                                       </td>
                                  </tr>
                                  
<?php
   }
?>
                                  
                          
                                  <!-- End of the copies for the first tab-->
                              </table>
                          </div>

                          <div id='Other' class="tabcontent">
                              Extra Information:<br>
                            <textarea id='extradata'>
                            </textarea>
                          </div>
                            <input type="submit" value="Submit" id="submitbutton">
                            <input type="reset" value="Reset" id="resetbutton">
                            <!-- JS Script to give our tabs functionality-->
                        <script>
                            function openTab(evt, tabName) {
                                var a, tabcontent, tablinks;
                                tabcontent = document.getElementsByClassName("tabcontent");
                                for (a = 0; a < tabcontent.length; a++) {
                                    tabcontent[a].style.display = "none";
                                }
                                tablinks = document.getElementsByClassName("tablinks");
                                for (a = 0; a < tabcontent.length; a++) {
                                    tablinks[a].className = tablinks[a].className.replace(" active", "");
                                }
                                document.getElementById(tabName).style.display = "block";
                                evt.currentTarget.className += " active";
                            }
                        </script>
                    </div>
        </form>
    </body>
</html>
