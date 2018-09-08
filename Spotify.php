<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Spotify Player</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="Spotify.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="FormForSpotify.php">Add Music</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="editPlaylist.php">Edit Playlists</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0 " action="Spotify.php" method = "GET">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="qwerty">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <ul class="list-group list-group-flush">
                <li style="font-size:20px" class="list-group list-group-flush">Playlists</li>
                <form class="form-inline my-2 my-lg-0 " action="Spotify.php" method = "GET">
                    <ul class="list-group list-group-flush">
                        <?php
                        include "databasequery.php";

                        $playlist_name = query_db("SELECT `playlist_name` FROM `playlists` WHERE 1");
                        $playlist_name_str = mysqli_fetch_all($playlist_name, MYSQLI_ASSOC);
                        foreach($playlist_name_str as $play_name_str){
                            $name_str = $play_name_str['playlist_name'];

                            echo"<a href='Spotify.php?playlist=$name_str' style='color: black' class='list-group-item'>$name_str</a>";
                        }

                        ?>

                    </ul>
                </form>
            </ul>

        </div>
        <div class="col-9">
            <div class="card-columns">
                <?php

                $sql_command = "SELECT * FROM `songs`";


                if(isset($_GET['qwerty'])){
                    $adder = $_GET['qwerty'];
                    $sql_command = "SELECT * FROM `songs` WHERE `song_name` LIKE '%$adder%'";

                }
                if(isset($_GET['playlist'])){
                    $pizza = $_GET['playlist'];
                    $plate = query_db("SELECT `id` FROM `playlists` WHERE `playlist_name` = '$pizza'");
                    $fork = $plate->fetch_array()[0]; //converts query array into a string
                    $song_id = query_db("SELECT `song_id` FROM `playlist_id_to_song_id` WHERE playlist_id = $fork");
                    //$song_id_not_complete = print_r($song_id);
                    // echo $song_id_not_complete;

                    $james = "(";
                    foreach($song_id as $song_id_str){
                        $id_of_song = $song_id_str['song_id'];
                        $james = $james . $id_of_song . ", ";
                    }
                    $james = $james . "0)";
                    //echo "SELECT `song_name` FROM `songs` WHERE `id` IN $james";

                    $sql_command = "SELECT * FROM `songs` WHERE `id` IN $james";

                }

                $result = query_db($sql_command);

                if($result->num_rows > 0) {
                $res_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($res_array as $row) {
                        $song_name = $row['song_name'];
                        $artist = $row['artist'];
                        $location = $row['location'];
                        $link = $row['link'];

                        $imgName = str_replace(" ","", $song_name);
                         echo "                
                                <div class='card' style='width: 18rem;'>
                                    <img class='card-img-top' src='img/$imgName.jpg' style=''>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$song_name</h5>
                                        <p class='card-text'>Composer: $artist</p>";
                         if ($location == "COMPUTER"){
                             echo "<audio controls style='width: 50%'>
                                    <source src='music/$link.mp3' type='audio/mpeg'>
                                    YOU DUN GOOFED GET A BETTER BROWSER.
                                    </audio>";
                         }  else{
                             echo "<a href='$link' class='btn btn-primary'>Play Song</a>";
                         }
                         echo " </div>
                                </div>
                         ";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>







