<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <img src="img/mypic.png" style="width: 50%; height: 50%">
            </div>
            <div class="col-4">
                <form action = "Songs.php" method = "POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="1">Song Name</label>
                            <input class="form-control" type = "text" id = "1" name = "songs" placeholder="Song Name">
                        </div>
                    </div>
                    <br/>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="2">Composer</label>
                            <input class="form-control" type = "text" id = "2" name = "composers" placeholder="Composer">
                        </div>
                    </div>
                    <button type = "submit" class="btn btn-primary" name = "submit">Submit</button>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row">
            <div class="col-6">
                <p>HELLO!</p>
            </div>
            <div class="col-6">
                <h1>THE THING</h1>
            </div>
        </div>
    </div>
</body>

<?php
if(isset($_POST['songs'])) {

    $songs = $_POST['songs'];
    $composers = $_POST['composers'];

    if($songs != '' and $composers != '') {
        include "databasequery.php";
        $conn = conn_db();
        $songsclean = $conn->real_escape_string($songs);
        $composersclean = $conn->real_escape_string($composers);
        $conn->close();

        query_db("INSERT INTO `songs`(`song_name`, `artist`) VALUES ('$songsclean', '$composersclean')");
    }

}

?>