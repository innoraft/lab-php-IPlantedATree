<?php
if(isset($_SESSION['facebook_access_token'])){
  if($_SESSION['role'] == 2){
    header('location:index.php');  
  }
}
else{
  header('location:index.php');
}
include('conn.php');
$sql = "SELECT * from user WHERE role NOT IN(0,1)";
$rs = $conn->query($sql);
$fieldArray = array();
$i = 0;
while ($i < mysqli_num_fields($rs)){
   $field = mysqli_fetch_field_direct($rs, $i);
   array_push($fieldArray,$field->name);
   $i++;
}
$i = 0;
$dataArray = array();
while($row = mysqli_fetch_assoc($rs)){
  array_push($dataArray, $row);
  $i++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
  function makeAdmin(id){
    var request = $.ajax({
      url : 'changeUserRole.php',
      method : 'POST',
      data : {id : id}
    });

    request.done(function(response){
      console.log(response);
      response = parseInt(response);
      if(response == 1){
        var toRemove = document.getElementById(id);
        toRemove.parentNode.removeChild(toRemove);
      }
      else{

      }
    });

    request.fail(function( jqXHR, textStatus){
      console.log("Failed to complete AJAX request.");
    });
  }
</script>
</head>
<body>
<div class="container">
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead>
      <tr>
        <?php
          for($i=0;$i<count($fieldArray);$i++){
            echo "<th>".$fieldArray[$i]."</th>";
          }
          echo '<th>Admin Privelege</th>';
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
        for($i=0;$i<count($dataArray);$i++){
          echo "<tr id=".$dataArray[$i]['fb_id'].">";
            for($j=0;$j<count($dataArray[0]);$j++){
              echo "<td>".$dataArray[$i][$fieldArray[$j]]."</td>";
            }
            ?>
            <td><button onclick="makeAdmin(<?php echo $dataArray[$i]['fb_id']?>)">Make Admin</button></td>
            <?php
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>
