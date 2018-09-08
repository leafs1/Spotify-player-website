<?php

$confirm = "";

/*
 * Once the form submission is clicked, the page is reloaded, with all the data submitted as a POST request.
 * PHP has some background handling, and rebrands all the POST data into a super-variable, named $_POST . This is basically a dictionary
 * (remember that dictionaries map keys -> values). in this case, where the form have an input with name="test", the values is then stored
 * to $_POST['test'].
 */

//Check if the file has been sent to the server
if(isset($_FILES['image'])){
    echo "yo home dog";
    // Check if there was a password sent

    if(isset($_POST["key"])){
        // Check if the password is valid
        if($_POST["key"] == "[REDACTED]"){

            // Create a funtion to add a file to the database.
            function addFile($name){
                global $confirm;
                include "databasequery.php";

                $type_array = array(
                    "SChoir" => "Senior Choir",
                    "JuniorChoir" => "Junior Choir",
                    "ElemChoir" => "Elementary Choir",
                    "TBChoir" => "Tenor/Bass Choir",
                    "Mass" => "Mass Responses and Chant",
                    "Hymn" => "Hymn & Hymn-songs",
                    "Piano" => "Piano",
                    "CusSec" => ""
                );
                $fileName = $_POST['fileName'];
                $composer = $_POST['composer'];
                $parts = $_POST['parts'];
                $extinfo = $_POST['exinfo'];
                $section = $_POST['section'];
                $customName = $_POST['custSec'];


                //The following few lines that call "real_escape_string" are just a safety mechanism, removing certain characters
                // from the user given inputs. This is important for security, because certain string can completely break a database.
                // If you want to read more on this type of breaking, look up SQL Injection Attack.
                $conn = conn_db();
                $fileName = $conn->real_escape_string($fileName);
                $composer = $conn->real_escape_string($composer);
                $parts = $conn->real_escape_string($parts);
                $extinfo = $conn->real_escape_string($extinfo);
                $section = $conn->real_escape_string($section);
                $customName = $conn->real_escape_string($customName);
                $fname = substr($name, 0, -4);
                $conn->close();

                if($section == "CusSec"){
                    $section = $customName;
                } else {
                    $section = $type_array[$section];
                }

                $sql = "INSERT INTO `musix` (`Piece Name`, `Composer`, `Parts`, `Copy Type`, `Extra Info`, `Section`, `Copy Link`, `Audio File`) VALUES ('$fileName', '$composer', '$parts', 'SOFT', '$extinfo', '$section', '$fname', '')";
                query_db($sql, "musix");
                $confirm = "<div class='alert alert-success' role='alert' style='text-align: center;'><strong>Well Done!</strong> The file was successfully uploaded to DMF's Music Lib</div>";
            }


            // Create an empty list. it shall be used to store errors and send them to the user
            $errors= array();
            // File vars, just store basic file info from the sent .pdf file.
            $file_name = $_FILES['image']['name']; //Stores the name
            $file_size = $_FILES['image']['size']; // Stores the file size
            $file_tmp = $_FILES['image']['tmp_name']; // Stores the temporary name - ie, the direct path (eg C:\Folder\AnotherFolder\temp\)
            $file_type = $_FILES['image']['type']; // Stores the file type. I don't use this variable, but it can be used to check if it's a pdf
            $file_ext = strtolower(end(explode('.',$_FILES['image']['name']))); // Breaks the file name at the '.', and returns whatever's to the right

            $expensions= array("pdf"); // a list that only contains "pdf"

            if(in_array($file_ext, $expensions)=== false){  // Check if the file ending is exactly .pdf
                $errors[]="extension not allowed, please choose a PDF file."; // otherwise save the error
            }

            if($file_size > 20971520) { //check if the file is the right size for uploading
                $errors[]='File size must be excately 20 MB'; // otherwise save the error
            }

            if(empty($errors)==true) { // if there are no saved errors
                //Process the file, move it into the correct folder, and add it to the database
                move_uploaded_file($file_tmp,"pdf/".$file_name);
                addFile($file_name);
            }else{
                // We have an error! Print that out to the user, in a funny message blocks.
                $stin = implode(' ',$errors);
                $confirm = "<div class='alert alert-danger' role='alert' style='text-align: center;'><strong>Something went wrong!</strong> $stin</div>";
            }
        }
    }
}
?>

<!--
        CREATE THE WEBPAGE
        You don't need to read below here, unless you want to understand how the
        website is displayed and designed. If you do go into here, just know it's all a bunch of formatting,
        around a simple <form></form>.
-->
<head>
    <title>DMF's Music Lib - Add File</title>

    <style>
        body {
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 400px;
            padding: 15px;
            margin: 0 auto;
        }

    </style>
    <script>
        function stuff(){
            var label = document.getElementById("filer").value.replace(/\\/g, '/').replace(/.*\//, '');
            document.getElementById("fileloader").value = label;
        };
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">


</head>
<body>
<div class ="container-fluid">
    <div class ="row">
        <div class ="col-md-4 col-sm-4">
            <a href="index.php"><img src="Title.png" alt="Banner Image"></a>
        </div>
    </div>
    <br/><br/>
</div>

<script>
    function check() {
        if(document.getElementById("cust").value == "CusSec"){
            document.getElementById("custSec").type = 'text';
        }else{
            document.getElementById("custSec").type = 'hidden';
        }
    }
</script>
<?php
echo $confirm;
?>

<div class="container">

    <form class="form-signin" action = "" method = "POST" enctype = "multipart/form-data">

        <div class="form-group row">
            <div class="col-sm-10">
                <label>Piece Name:</label>
                <input type="text" class="form-control" name="fileName">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label>Composer:</label>
                <input type="text" class="form-control" name="composer">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label>Parts:</label>
                <input type="text" class="form-control" name="parts">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label>Extra Info:</label>
                <input type="text" class="form-control" name="exinfo">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <label>Section:</label>
                <select class="form-control" onchange="check()" id="cust" name="section">
                    <option value="SChoir">Senior Choir</option>
                    <option value="JuniorChoir">Junior Choir</option>
                    <option value="ElemChoir">Elementary Choir</option>
                    <option value="TBChoir">Tenor/Bass Choir</option>
                    <option value="Mass">Mass Responses and Chant</option>
                    <option value="Hymn">Hymns and Hymn-Songs</option>
                    <option value="Piano">Piano Sheet Music</option>
                    <option value="CusSec">Custom Section</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <input type="hidden" class="form-control" id="custSec" placeholder="Custom Section" name="custSec">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-10">
                <input class="form-control" type="password" name="key" placeholder="Upload Key" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <div class="input-group">
                    <label class="input-group-btn">
                    		<span class="btn btn-primary">
                        		Browse<input type="file" style="display: none;" name="image" id="filer" onchange="stuff()">
                    		</span>
                    </label>
                    <input type="text" class="form-control" style="height: 34px;" id="fileloader" disabled>
                </div>
            </div>
        </div>
        <br/>
        <input class="btn btn-primary" type="submit" value="Submit Music"/>
    </form>
</div>
</body>
