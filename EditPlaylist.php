<?php
include "databasequery.php";
    if(isset($_POST['tony'])) {
        $playlist_selected = $_GET['playlist'];

        $rob = query_db("SELECT `id` FROM `playlists` WHERE `playlist_name` = '$playlist_selected'");

        $playlist_id = $rob->fetch_array()[0];


        $song_id = $_POST['tony'];

        query_db("INSERT INTO `playlist_id_to_song_id` (`playlist_id`, `song_id`) VALUES ($playlist_id, $song_id)");
    }
?>

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
                        <a href="EditPlaylist.php?playlist=first" style="color: black" class="list-group-item">First Playlist</a>
                        <a href="EditPlaylist.php?playlist=second" style="color: black" class="list-group-item">Second Playlist</a>
                        <a href="EditPlaylist.php?playlist=third" style="color: black" class="list-group-item">Third Playlist</a>
                        <a href="EditPlaylist.php?playlist=fourth" style="color: black" class="list-group-item">Fourth Playlist</a>
                        <a href="EditPlaylist.php?playlist=fifth" style="color: black" class="list-group-item">Fifth Playlist</a>
                        <a href="EditPlaylist.php?playlist=sixth" style="color: black" class="list-group-item">Sixth Playlist</a>
                        <a href="EditPlaylist.php?playlist=seventh" style="color: black" class="list-group-item">Seventh Playlist</a>
                        <a href="EditPlaylist.php?playlist=eighth" style="color: black" class="list-group-item">Eighth Playlist</a>
                        <a href="EditPlaylist.php?playlist=ninth" style="color: black" class="list-group-item">Ninth Playlist</a>
                        <a href="EditPlaylist.php?playlist=tenth" style="color: black" class="list-group-item">Tenth Playlist</a>
                    </ul>
                </form>
            </ul>

        </div>
        <div class="col-9">
            <div class="card-columns">
                <?php

                $sql_command = "SELECT * FROM `songs`";

                $result = query_db($sql_command);

                if($result->num_rows > 0) {
                    $res_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($res_array as $row) {
                        $song_name = $row['song_name'];
                        $artist = $row['artist'];
                        $location = $row['location'];
                        $link = $row['link'];
                        $id = $row['id'];

                        $imgName = str_replace(" ","", $song_name);
                        echo "                
                                <div class='card' style='width: 18rem;'>
                                    <img class='card-img-top' src='img/$imgName.jpg' style=''>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$song_name</h5>
                                        <p class='card-text'>Composer: $artist</p>";

                        echo "<form class='form-inline my-2 my-lg-0 ' action='' method = 'POST'>
                                <button type = 'submit' class='btn btn-primary' value = '$id'name = 'tony'>Add to Playlist</button>
                              </form>";


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



<?php
/*
    $id_of_playlist = query_db("SELECT `id` FROM `playlists` WHERE 1");
    $playlist_id_str = mysqli_fetch_all($id_of_playlist, MYSQLI_ASSOC);
    foreach($playlist_id_str as $play_id_str){
        $id_str = $play_id_str['id'];
        echo $id_str . ", ";
    }

    $id_of_the_songs = query_db("SELECT `song_id` FROM `playlist_id_to_song_id` WHERE `playlist_id` = $id_str");
    $id_of_the_songs_str = mysqli_fetch_all($id_of_the_songs, MYSQLI_ASSOC);
    foreach($id_of_the_songs_str as $id_of_the_songs_two){
        $id_des_chansons = $id_of_the_songs_two['song_id'];
        echo $id_des_chansons . ", ";
    }
?>






