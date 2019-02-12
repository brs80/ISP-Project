

<?php
     $servername = "db1.cs.uakron.edu";
     $username = "mar64";
     $password = "goong8Ut";
     $dbname = "ISP_mar64";
     try
     {
          $empId = $_GET["id"];
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          $sql = "SELECT * FROM employees ";
          $result = $conn->query($sql);

          $sql = "SELECT * FROM projects RIGHT JOIN tasks on projects.id = tasks.project WHERE respEmployee = '$empId' ORDER BY endDate ";
          $result = $conn->query($sql);
          $now = time();
?>
<table>
  <tr>
     <th>Client</th>
     <th>Project</th>
     <th>Task</th>
     <th>Due Date</th>
     <th>Completed</th>
  </tr>
<?php
          while($row = $result->fetch_assoc())
          {
             $dueDate = strtotime($row["endDate"]);
?>
             <tr class="<?php if ($dueDate<$now && $row["completed"]==false) echo "Overdue";?>">
                   <td>
                       <?php echo $row["clientName"]; ?>
                   </td>
                   <td>
                       <?php echo $row["projectDescription"];?>
                   </td>
                   <td>
                     <textarea rows="3" style="width:100%" class="TaskInput" type="text" id="taskDescription<?php echo $row["id"];?>" onchange=""><?php echo $row[
"taskDescription"]?> </textarea/>
                   </td>
                   <td class="fixedWidth">
                     <input type="text" class="dateValidate TaskInput" style="width:100%"  id="endDate<?php echo $row["id"];?>" value="<?php echo $row["endDate"];?>" 
                      onchange="drawGanntBars();"></td>
                   </td>
                   <td  class="fixedWidth" style="text-align:center">
                     <input type="checkbox" class="TaskInput" id="completed<?php echo $row["id"];?>" <?php if($row["completed"] == 1) echo "checked";?> 
                      onchange="drawGanntBars();"></td>
                   </td>
             </tr>
<?php
          }
?>
</table>
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
