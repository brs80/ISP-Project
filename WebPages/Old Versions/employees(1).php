<script src="jquery-2.2.2.js"></script>
<script>
  //TODO:  Prevent adding duplicates (i.e., refreshing after "add" readds
  //TODO:  Add input validation
  var saveChange = function(id){
        var updateParams=[];
        var emp={};
        emp["id"]=id;
        emp["first"]=$('#first'+id).val();
        emp["last"]=$('#last'+id).val();
        emp["short"]=$('#short'+id).val();
        emp["email"]=$('#email'+id).val();
        updateParams.push(emp);
        console.log(updateParams); 
        $.post("updateEmployee.php",JSON.stringify(updateParams));
  }

  var deleteEmployee = function(id){
     $.post("deleteEmployee.php",JSON.stringify(id));      
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

          $sql = "SELECT id, firstName, lastName, shortName, email FROM employees ORDER BY lastName";
          $result = $conn->query($sql);

?>
          <form method="post">
              <table>
                <tr>
                    <th>
                       ID
                    </th>
                    <th>
                       First Name
                    </th>
                    <th>
                       Last Name
                    </th>
                    <th>
                       Short Name
                    </th>
                    <th>
                       E-mail
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
                        <input type="text" id="first<?php echo $row["id"];?>" value="<?php echo $row["firstName"];?>" onchange="saveChange(<?php echo $row["id"];?>)"> 
                    </td>
                    <td>
                        <input type="text" id="last<?php echo $row["id"];?>" value="<?php echo $row["lastName"];?>" onchange="saveChange(<?php echo $row["id"];?>)"> 
                    </td>
                    <td>
                        <input type="text" id="short<?php echo $row["id"];?>" value="<?php echo $row["shortName"];?>" onchange="saveChange(<?php echo $row["id"];?>)">  
                    </td>
                    <td>
                        <input type="text" id="email<?php echo $row["id"];?>" value="<?php echo $row["email"];?>" onchange="saveChange(<?php echo $row["id"];?>)"> 
                    </td>
                    <td>
                        <button type="button" id="btnDelete" name="btnDelete"  onclick="deleteEmployee(<?php echo $row["id"];?>)">Delete</button> 
                    </td>
                  </tr>
<?php
              }
?>

              <tr>
                   <td>
                      Add: 
                   </td>
                   <td>
                      <input type="text" name="newFirst">
                   </td>
                   <td>
                      <input type="text" name="newLast">
                   </td>
                   <td>
                      <input type="text" name="newShort">
                   </td>
                   <td>
                      <input type="text" name="newEmail">
                   </td>
                    <td>
                        <button type="submit" id="btnAdd" name="btnAdd" value="Add">Add</button> 
                    </td>
              </tr>
              </table>
              <button type="button" id="btnSaveChanges" onclick="saveChanges()">Save Changes</button>
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

?>
