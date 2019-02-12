<style>
svg rect{
	stroke:black;
	fill:yellow;
}

table, td, th {
	border:thin solid black;
        width:auto;	
}

.fixedWidth {
        width:8em;
}




</style>
<script src="jquery-2.2.2.js"></script>
<script>
  //TODO:  Prevent adding duplicates (i.e., refreshing after "add" readds
  //TODO:  Add input validation
var  saveChangeToProject = function(id){
        var proj={};

        proj["id"]=id;
        proj["name"]=$('#clientName').val();
        proj["description"]=$('#projectDescription').val();
        proj["projMgr"]=$('#projectManager').val();
        proj["type"]=$('#type option:selected').val();
        proj["status"]=$('#status option:selected').val();
        $.post("updateProject.php",JSON.stringify(proj));
  }

var  saveChangeToTask = function(id){
        var task={};

        task["id"]=id;
        task["taskDescription"]=$('#taskDescription'+id).val();
        task["startDate"]=$('#startDate'+id).val();
        task["endDate"]=$('#endDate'+id).val();
        task["respEmployee"]=$('#respEmployee'+id).val();
        task["completed"]=$('#completed'+id).prop('checked');
        $.post("updateTask.php",JSON.stringify(task));
  }


  var deleteEmployee = function(id){
     $.post("deleteEmployee.php",JSON.stringify(id));      
     $('#row'+id).remove();
  }

</script>

<?php
     $projId = $_GET["projId"];
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
             }
             else if (isset($_POST['btnSaveChanges']))
             {
             }
          }
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection

          $sql = "SELECT * FROM projects WHERE id=$projId";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();

?>
          <form method="post">
              <table>
                <tr>
                   <td>Id:</td>
                   <td><?php echo $row["id"];?></td>
                </tr>
                <tr>
                   <td>Client Name:</td>
                   <td><input type="text" id="clientName" value="<?php echo $row["clientName"];?>" onchange="saveChangeToProject(<?php echo $row["id"];?>)"></td>
                </tr>
                <tr>
                   <td>Project Description:</td>
                   <td><input type="text" id="projectDescription" value="<?php echo $row["projectDescription"];?>" onchange="saveChangeToProject(<?php echo $row
["id"];?>)"></td>
                </tr>
                <tr>
                   <td>Project Manager</td>
                   <td>
                       <select id="projectManager" name="projectManager" onchange="saveChangeToProject(<?php echo $row["id"];?>)">
 <?php 
                         $sql = "SELECT * FROM employees ORDER BY shortName";
                         $employees = $conn->query($sql);
                         $empArr = array();
                         while($employee = $employees->fetch_assoc())
                         {
                           array_push($empArr,$employee);
                           $short = $employee["shortName"];
                           $id = $employee["id"];
                           if ($id==$row["projectManager"])
                              echo "<option value=\"$id\" selected>$short</option>"; 
                           else
                              echo "<option value=\"$id\">$short</option>"; 

                         }
?>
                       </select>
                   </td>
                </tr>
                <tr>
                   <td>Project Type</td>
                   <td>
                       <select id="type" name="type" onchange="saveChangeToProject(<?php echo $row["id"];?>)">
 <?php 
                         $sql = "SELECT * FROM types ORDER BY description";
                         $types = $conn->query($sql);
                         while($type = $types->fetch_assoc())
                         {
                           $desc = $type["description"];
                           $id = $type["id"];
                           if ($id==$row["projectType"])
                              echo "<option value=\"$id\" selected>$desc</option>"; 
                           else
                              echo "<option value=\"$id\">$desc</option>"; 

                         }
?>
                       </select>
                   </td>
                </tr>
                <tr>
                   <td>Status</td>
                   <td>
                       <select id="status" name="status" onchange="saveChangeToProject(<?php echo $row["id"];?>)">
 <?php 
                         $sql = "SELECT * FROM status ";
                         $statuses = $conn->query($sql);
                         while($status = $statuses->fetch_assoc())
                         {
                           $desc = $status["description"];
                           $id = $status["id"];
                           if ($id==$row["projectStatus"])
                              echo "<option value=\"$id\" selected>$desc</option>"; 
                           else
                              echo "<option value=\"$id\">$desc</option>"; 

                         }
?>
                       </select>
                   </td>
                </tr>
                <tr>
                   <td>Date Created</td>
                   <td><?php echo $row["dateCreated"];?></td>
                </tr>
                <tr>
                   <td>Date Completed</td>
                   <td><?php echo $row["dateCompleted"];?></td>
                </tr>
              </table>
           </form>

           <form id="tasksForm">
              <table id="tasksTable" width="100%">
              <tr>
                <th>ID</th>
                <th>Description</th>
                <th width="8em" class="fixedWidth">Start Date</th>
                <th width="8em" class="fixedWidth">End Date</th>
                <th width="7em" class="fixedWidth">Done</th>
                <th width="10em" class="fixedWidth">Resp</th>
                <th id="ganntHeader" >
                    <div id="svgDates" width="500" height="10" ></div>
                </th>
              </tr>
<?php
                 $sql = "SELECT * FROM tasks WHERE project=$projId ORDER BY startDate";
                 $tasks = $conn->query($sql);
                 while($task = $tasks->fetch_assoc())
                 {
                     $start= new DateTime($task["startDate"]);
                     $end=new DateTime($task["endDate"]);
                     if(!isset($projstart))
                        $projstart=$start;
                     else if($start<$projstart)
                        $projstart=$start;
                     if(!isset($projend))
                        $projend=$end;
                     else if($end>$projend)
                        $projend=$end;
?>
                 <tr id="taskrow<?php echo $task["id"];?>">
                   <td class="fixedWidth">
                     <?php echo $task["id"];?>
                   </td>
                   <td>
                     <input type="text" id="taskDescription<?php echo $task["id"];?>" value="<?php echo $task["taskDescription"];?>" onchange="saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth">
                     <input type="text" id="startDate<?php echo $task["id"];?>" value="<?php echo $task["startDate"];?>" onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth">
                     <input type="text" id="endDate<?php echo $task["id"];?>" value="<?php echo $task["endDate"];?>" onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td  class="fixedWidth">
                     <input type="checkbox" id="completed<?php echo $task["id"];?>" <?php if($task["completed"] == 1) echo "checked";?> onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth">
                       <select id="respEmployee<?php echo $task["id"];?>" onchange="saveChangeToTask(<?php echo $task["id"];?>)">

<?php
                      foreach($empArr as $emp)
                      {
                           $desc = $emp["shortName"];
                           $id = $emp["id"];
                           if ($id==$task["respEmployee"])
                              echo "<option value=\"$id\" selected>$desc</option>"; 
                           else
                              echo "<option value=\"$id\">$desc</option>"; 
                      }

?>
                       </select>

                   </td>
                   <td>
                       <div id="gannt<?php echo $task["id"];?>" class="gannt" width="500px">
                          <svg id="svg<?php echo $task["id"];?>" class="ganntSVG" height="20" width="500">
                             <rect id="ganntrect<?php echo $task["id"];?>" class="ganntRect" x="10" y="0"  height="20" width="300">
                             </rect>
                             <line class="today" x1="10" x2="10" y1="0" y2="20" stroke="red"></line>
                          </svg>
                       </div>
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

/*
     function insertEmployee($first, $last, $short, $email)
     {
          $servername = "db1.cs.uakron.edu";
          $username = "mar64";
          $password = "goong8Ut";
          $dbname = "ISP_mar64";
          try
          {
               $conn = new mysqli($servername, $username, $password, $dbname);
               $sql= "INSERT INTO  employees (firstName, lastName, shortName, email) VALUES ('$first', '$last', '$short', '$email')" ;
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

*/
?>


<script>

var projStart = new Date("2200-01-01");
var projEnd = new Date("1971-01-01");
var width = 500;
var projLength;

$(document).ready(function(){
    drawGanntBars();
    var today = Date.now();
    var todayX =(today-projStart)/projLength*width;
    $('.today').attr('x1', todayX);
    $('.today').attr('x2', todayX);

});

var getProjectStartAndEndDates=function(){
    //get overall project start and end date
    $('.gannt').each( function(){
       
       var id = $(this).attr('id').slice(5);
       var start = new Date($('#startDate'+id).val());
       var end = new Date($('#endDate'+id).val());
       if (start < projStart)
           projStart = start;
       if (end < projStart)
           projStart = end;
       if (end > projEnd)
           projEnd = end;
       if (start > projEnd)
           projEnd = start;
       var diff = end-start;
    });

}
var drawGanntBars=function()
{
    getProjectStartAndEndDates();
    projLength=projEnd-projStart;
    $('.ganntRect').each(function(){
       var id = $(this).attr('id').slice(9);
       var start = new Date($('#startDate'+id).val());
       var end = new Date($('#endDate'+id).val());
       var done = $('#completed'+id).prop('checked');
       console.log(done);
       var startX = (start-projStart)/projLength*width;
       var barWidth;
       barWidth = (end-start)/projLength*width; 
       if(barWidth < 1)
         barWidth = 1 ;
       if(done)
         $(this).css('fill', "blue");
       else
         $(this).css('fill', "yellow");
       $(this).attr('width', barWidth);
       $(this).attr('x', startX);
    });
    setGanntDates();
}

var setGanntDates=function()
{
   var myWidth=$('#svgDates').attr("width");
   var numDates = myWidth/100;
   var interval = projLength/numDates;
   for(var i=0;i<numDates;++i)
   {
      var date = new Date(projStart.valueOf()+i*interval);
      //console.log (date);
      $('#svgDates').append((date.getMonth()+1) + "/" + date.getDate() + " ");
   }
}
</script>
