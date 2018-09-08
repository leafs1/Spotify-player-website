<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<table class="table table-striped">
  <tr>
    <th>SONG NAME</th>
    <th>ID</th>
  </tr>
<?php
  include "databasequery.php";
  $result = query_db("SELECT `song_name`, `id` FROM `songs` WHERE `artist`='Anton Bruckner'");

  if($result->num_rows > 0) {
    $res_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($res_array as $row) {
      echo "<tr>";
      echo "<td>" . $row['song_name'] . "</td>";
      echo "<td>" . $row['id'] . "</td>";
      echo "</tr>";
    }
  }
 ?>
