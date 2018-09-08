<?php


if(isset($_POST['songs'])) {

    $songs = $_POST['songs'];
    $composers = $_POST['artist'];
    $location = $_POST['location'];
    $link = $_POST['link'];

    if($songs != '' and $composers != '' and $location != '') {
        include "databasequery.php";
        $conn = conn_db();
        $songsclean = $conn->real_escape_string($songs);
        $composersclean = $conn->real_escape_string($composers);
        $locationclean = $conn->real_escape_string($location);
        $linkclean = $conn->real_escape_string($link);
        $conn->close();

        if ($locationclean == "COMPUTER"){
            $linkclean = null;


            if(isset($_FILES['mp3'])){

                $file_name = $_FILES['mp3']['name']; //Stores the name
                $file_size = $_FILES['mp3']['size']; // Stores the file size
                $file_tmp = $_FILES['mp3']['tmp_name']; // Stores the temporary name - ie, the direct path (eg C:\Folder\AnotherFolder\temp\)
                $file_type = $_FILES['mp3']['type']; // Stores the file type. I don't use this variable, but it can be used to check if it's a pdf
                $middle = explode('.',$_FILES['mp3']['name']);
                $file_ext = strtolower(end($middle)); // Breaks the file name at the '.', and returns whatever's to the right

                $errors = false;

                $expensions= array("mp3");

                if(in_array($file_ext, $expensions)=== false) {  // Check if the file ending is exactly .pdf
                    $errors = true;

                }

                if($file_size > 20971520) { //check if the file is the right size for uploading
                    $errors = true;

                }

                if(empty($errors)==true) { // if there are no saved errors
                    //Process the file, move it into the correct folder, and add it to the database
                    move_uploaded_file($file_tmp, "music/" . $file_name);



                    $fname = substr($file_name, 0, -4);



                    query_db("INSERT INTO `songs`(`song_name`, `artist`, `location`, `link`, `mp3`) VALUES ('$songsclean', '$composersclean', '$locationclean', '$fname', '')");


                }
            }

        }   elseif ($locationclean == "SPOTIFY"){
            $mp3clean = null;
            query_db("INSERT INTO `songs`(`song_name`, `artist`, `location`, `link`, `mp3`) VALUES ('$songsclean', '$composersclean', '$locationclean', '$linkclean', '')");

        }
    }
}

?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    <script>
        function check() {
            if(document.getElementById("locations").value == "COMPUTER"){
                document.getElementById("4").type = 'hidden';
                document.getElementById("inputGroupFile01").disabled = false;
                document.getElementById("inputGroupFile01").type = 'file';
            }else{
                document.getElementById("inputGroupFile01").type = 'hidden';
                document.getElementById("inputGroupFile01").disabled = true;
                document.getElementById("4").type = 'text';
            }
        }
    </script>
    <script>
        function stuff(){
            var label = document.getElementById("inputGroupFile01").value.replace(/\\/g, '/').replace(/.*\//, '');
            document.getElementById("test").innerText = label;
        };
    </script>
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
                    <a class="nav-link" href="EditPlaylist.php">Edit Playlists</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4">
                <form action = "FormForSpotify.php" method = "POST" enctype = "multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="1">Song Name</label>
                            <input class="form-control" type = "text" id = "1" name = "songs" placeholder="Song Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="2">Artist</label>
                            <input class="form-control" type = "text" id = "2" name = "artist" placeholder="Artist">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="3">Location</label>
                            <select class="form-control" name="location" onchange="check()" id="locations">
                                <option value="COMPUTER">Computer</option>
                                <option value="SPOTIFY">Spotify</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <input class="form-control" type = "hidden" id = "4" name = "link" placeholder="Link">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="mp3" onchange="stuff()">
                                <label class="custom-file-label" for="inputGroupFile01" id="test">mp3</label>
                            </div>
                        </div>
                    </div>
                    <button type = "submit" class="btn btn-primary" name = "submit">Submit</button>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>

