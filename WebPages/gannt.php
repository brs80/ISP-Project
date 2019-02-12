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


</style>
<script src="jquery-2.2.2.js"></script>
<script src="validator.js"></script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
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

        var re = new RegExp(/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/);
        var pos=$('#startDate'+id).val().search(re);
        if (pos!=0) return;
        pos=$('#endDate'+id).val().search(re);
        if (pos!=0) return;
        task["id"]=id;
        task["taskDescription"]=$('#taskDescription'+id).val();
        task["startDate"]=$('#startDate'+id).val();
        task["endDate"]=$('#endDate'+id).val();
        task["respEmployee"]=$('#respEmployee'+id).val();
        task["completed"]=$('#completed'+id).prop('checked');
        $.post("updateTask.php",JSON.stringify(task));
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
                <th style="visibility:hidden;width:0px""></th>
                <th>Description</th>
                <th  class="fixedWidth">Start Date</th>
                <th  class="fixedWidth">End Date</th>
                <th  class="fixedWidth">Done</th>
                <th  class="fixedWidth">Resp</th>
                <th id="ganntHeader" style:"width:100%;min-width:500px" >
                    <div> 
                         <svg id="svgDates" width="100%" height="20" >
                         </svg>
                    </div>
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
                   <td style="visibility:hidden;width:0px">
                     <span style="visibility:hidden;"<?php echo $task["id"];?>
                   </td>
                   <td>
                     <input style="width:100%" type="text" id="taskDescription<?php echo $task["id"];?>" value="<?php echo $task["taskDescription"];?>" 
                      onchange="saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth">
                     <input type="text" class="dateValidate" style="width:100%" id="startDate<?php echo $task["id"];?>" value="<?php echo $task["startDate"];?>" 
                      onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth">
                     <input type="text" class="dateValidate" style="width:100%"  id="endDate<?php echo $task["id"];?>" value="<?php echo $task["endDate"];?>" 
                      onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td  class="fixedWidth" style="text-align:center">
                     <input type="checkbox" id="completed<?php echo $task["id"];?>" <?php if($task["completed"] == 1) echo "checked";?> 
                      onchange="drawGanntBars();saveChangeToTask(<?php echo $task["id"];?>)"></td>
                   </td>
                   <td class="fixedWidth" style="text-align:center">
                       <select style="width:100%" id="respEmployee<?php echo $task["id"];?>" onchange="saveChangeToTask(<?php echo $task["id"];?>)">

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
                       <div id="gannt<?php echo $task["id"];?>" class="gannt" width="100%">
                          <svg id="svg<?php echo $task["id"];?>" class="ganntSVG" height="20" width="100%">
                             <rect id="ganntrect<?php echo $task["id"];?>" class="ganntRect" x="10" y="0"  height="20" width="300">
                             </rect>
                             <line class="today" x1="10" x2="10" y1="0" y2="20" stroke="red"></line>
                          </svg>
                       </div>
                   </td>
                 </tr>
                             

<?php
                 }
              $newRowId=time();
?>

              <tr id="taskrow<?php echo $newRowId;?>">
                <td style="visibility:hidden;width:0px""></td>
                <td>
                     <input style="width:100%" type="text" id="Description<?php echo $newRowId;?>" value="" >
                </td>
                <td  class="fixedWidth">
                     <input style="width:100%" type="text" id="StartDate<?php echo $newRowId;?>" value="" >
                </td>
                <td  class="fixedWidth">
                     <input style="width:100%" type="text" id="EndDate<?php echo $newRowId;?>" value="" >
                </td>
                <td  class="fixedWidth">
                     <input style="width:100%" type="checkbox" id="Done<?php echo $newRowId;?>" checked >
                </td>
                <td  class="fixedWidth">
                       <select style="width:100%" id="RespEmployee<?php echo $newRowId;?>" onchange="">

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
                </td>
                   <td>
                       <div id="gannt<?php echo $newRowId;?>" class="gannt" width="100%">
                          <svg id="svg<?php echo $newRowId;?>" class="ganntSVG" height="20" width="100%">
                             <rect id="ganntrect<?php echo $newRowId;?>" class="ganntRect" x="10" y="0"  height="20" width="300">
                             </rect>
                             <line class="today" x1="10" x2="10" y1="0" y2="20" stroke="red"></line>
                          </svg>
                       </div>
                   </td>
              </tr>



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


<script>

var projStart = new Date("2200-01-01");
var projEnd = new Date("1971-01-01");
var width = $("#svgDates").width();// 500;
console.log(width);
var projLength;

$(document).ready(function(){
    drawGanntBars();
    setTodayBars();
    $('.dateValidate').on("blur",mySqlDateValidator);

});

var setTodayBars = function(){

    var today = Date.now();
    var todayX =(today-projStart)/projLength*width;
    $('.today').attr('x1', todayX);
    $('.today').attr('x2', todayX);
}

var getProjectStartAndEndDates=function(){
     projStart = new Date("2200-01-01");
     projEnd = new Date("1971-01-01");
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
    projStart= new Date(projStart.getFullYear(),projStart.getMonth(),1);
    projEnd= new Date(projEnd.getFullYear(),projEnd.getMonth()+1,1);

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
    setTodayBars();
}

var setGanntDates=function()
{
   d3.selectAll('#svgDates > *').remove();
   var numYears=projEnd.getYear()-projStart.getYear();
   var myWidth=$('#svgDates').width();
   var lastYearX=0;
   var lastYearStart=projStart;
   var yearEnd;
   var yearX;
   for(var i=0;i<numYears;++i)
   {
     yearEnd = new Date((projStart.getFullYear()+i)+"-12-31"); 
     yearX =lastYearX+(yearEnd-lastYearStart)/projLength*myWidth;
     d3.select('#svgDates').append("line").attr("x1",yearX).attr("x2",yearX).attr("y1",0).attr("y2",10).attr("stroke","blue");
     var yearTextWidth=getTextWidth(yearEnd.getFullYear(),"12pt Times")
     if (yearTextWidth<yearX)
        d3.select('#svgDates').append("text").text(yearEnd.getFullYear()).attr("x",lastYearX/2+yearX/2-yearTextWidth/2).attr("y",10).attr("stroke","black").attr("stroke-width",0).attr("fill","black").attr("font-size", "12");
     lastYearX=yearX; 
     lastYearStart=yearEnd; 
   }
   yearEnd = projEnd;
   yearX =myWidth;//lastYearX+(yearEnd-lastYearStart)/projLength*myWidth;
   var yearTextWidth=getTextWidth(yearEnd.getFullYear(),"12pt Times")
   if (yearTextWidth<yearX)
     d3.select('#svgDates').append("text").text(yearEnd.getFullYear()).attr("x",lastYearX/2+yearX/2-yearTextWidth/2).attr("y",10).attr("stroke","black").attr("stroke-width",0).attr("fill","black").attr("font-size", "12");

   var numMonths=numYears*12+(projEnd.getMonth()-projStart.getMonth());//+1;
   var startMonth=projStart.getMonth();
   var monthX;
   var monthWidth = myWidth/numMonths
   var year=projStart.getFullYear();
   var longMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
   var medMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
   var shortMonthNames = ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D" ];
   var monthNames;
   var minBuff=5;
   if (monthWidth<(getTextWidth("WWW","8pt Times")-minBuff))
      monthNames = shortMonthNames;
   else if (monthWidth<(getTextWidth("MMMMMMMMM","8pt Times")-minBuff))
      monthNames = medMonthNames;
   else
      monthNames = longMonthNames;
   for (var i=0;i<numMonths;++i)
   {
     monthX =i*monthWidth; //lastMonthX+(monthEnd-lastMonth)/projLength*myWidth;
     var textWidth=getTextWidth(monthNames[(startMonth+i)%12],"8pt Times");
      
     d3.select('#svgDates').append("line").attr("x1",monthX).attr("x2",monthX).attr("y1",12).attr("y2",20).attr("stroke","blue");
     d3.select('#svgDates').append("text").text(monthNames[(startMonth+i)%12]).attr("x",monthX+monthWidth/2-textWidth/2).attr("y",20).attr("stroke","black").attr("stroke-width",0).attr("fill","black").attr("font-size", "8");
   }
   var numDates = myWidth/100;
   var interval = projLength/numDates;
   for(var i=0;i<numDates;++i)
   {
      var date = new Date(projStart.valueOf()+i*interval);
   }
}
//http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript
var getTextWidth = function(text, font) {
    // re-use canvas object for better performance
    var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
    var context = canvas.getContext("2d");
    context.font = font;
    var metrics = context.measureText(text);
    return metrics.width;
};
</script>
