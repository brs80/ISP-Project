 <link rel="stylesheet" type="text/css" href="newcss.css">

<style>
svg rect{
        stroke:black;
        fill:yellow;
}

table, td, th {
        border:thin solid black;
        border-collapse:collapse;
}

.fixedWidth {
        max-width:8em;
        width:7em;
}
.Invalid {

        border-color:red;
}
.Overdue {

        background-color:red;
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


<script src="jquery-2.2.2.js"></script>
<script src="validator.js"></script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
var updateList = function(){
        $('#taskList').empty();
        $('#taskList').html("loading . . . ");
        var emp={};
        emp["id"]=$('#empSelect').val();
        $.get("getTasks.php",emp,function(data){
        $('#taskList').html(data);

        });
}

$(document).ready(function(){
    updateList();

});
</script>




<?php
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
?>
     <select id="empSelect" name="projectManager" onchange="updateList()">
 
 <?php
                         $sql = "SELECT * FROM employees ORDER BY shortName";
                         $employees = $conn->query($sql);
                         $empArr = array();
                         while($employee = $employees->fetch_assoc())
                         {
                           array_push($empArr,$employee);
                           $short = $employee["shortName"];
                           $id = $employee["id"];
                           echo "<option value=\"$id\">$short</option>";

                         }

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
   </select>
<div id="taskList"></div>
