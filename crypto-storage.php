<?php

# GENERAL INTERFACE
// GENERAL 
echo "<html><head><link href='css/bootstrap.min.css' rel='stylesheet'></head><body>";
echo "<div class='p-3 mb-2 bg-secondary text-white'>Our project allows you to safely exchange files</div>";
echo "<center>";
echo "<h1>Encrypted File Sharing</h1>";
echo "<br><br>";
echo "<h2>Upload files</h2>";
echo "<br>";
echo "<form action='' method='POST' enctype='multipart/form-data'>";
echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
echo "<br><br><br>";
echo "<input type='submit' value='Upload' name='submit'>";
echo "</form>";
echo "<hr><br><br>";
echo "<h2>Download files</h2>";
echo "<br>";
echo "<h4>Enter secret name file</h4>";
echo "<form action='' method='POST'>";
echo "<input type='text' name='fileToDownload' id='fileToDownload'>";
echo "<br><br>";
echo "<h4>Enter key for file</h4>";
echo "<input type='text' name='fileDecryptoKey' id='fileDecryptoKey'>";
echo "<br><br><br>";
echo "<input type='submit' value='download' name='download'>";
echo "</form>";
echo "<br><hr>";

# GENERAL DATA 

$mysqli = mysqli_connect("localhost", "user", "1", "storage");

$upload_directory = "uploads/";

$beginURL =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

#UPLOAD

if(isset($_FILES['fileToUpload'])) {

$file = $_FILES['fileToUpload'];

if( $file['error'] !== UPLOAD_ERR_OK ) { die("Error.Try again."); }

# CHECK EXTENSION FILES | SUPPORT ONLY RAR
$fullFileName = $file['name'];
$file_extension = substr($fullFileName, -4);
$rar = '.rar';
if (strcasecmp($file_extension, $rar) !== 0) { 
    echo "<br>";
    echo "You are trying to upload a non-RAR archive. The system only works with RAR archives";
    break;
}

# CREATE NEW FILE NAME
$filename = uniqid();
$destination = $upload_directory . $filename;
$name = 'crypto_' . $filename;

# CREATE RANDOM FUNCTION FOR KEY
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

$genkey = generate_string($permitted_chars, 20);
$hex = bin2hex($genkey);

#UPLOAD FILE ON SERVER
if(move_uploaded_file($file["tmp_name"], $destination)) {

    echo "<h3>Upload comlete: </h3>";
    echo "<br>";
    echo "secret file id: $name";
    echo "<br>";
    echo "secret file key: $hex";

    $request_encrypt = 'cd uploads && openssl enc -aes-256-cbc -a -K ' . $hex . ' -iv 0000 -nosalt -in ' .$filename . ' -out crypto_' .$filename;
    $request_delete = 'cd uploads && rm -rf ' .$filename;
    shell_exec($request_encrypt);
    shell_exec($request_delete);

    mysqli_query($mysqli, "INSERT INTO info (txt) VALUES ('$name');");

    echo "<br>";
} else {

    die("Error uopload, try again");

}

}

# DOWNLOAD

if (isset($_POST['download'])) {

    $id = $_POST['fileToDownload'];
    
    $result = mysqli_query($mysqli, "SELECT txt FROM info WHERE txt = '$id';");
    $row = mysqli_fetch_assoc($result);
    $idtxt = $row['txt'];

    if ( !empty($idtxt)) {

        $key = $_POST['fileDecryptoKey'];

        $url= "http://" . $beginURL . "uploads/" . $idtxt;

        $request_encrypt = 'cd uploads && openssl enc -aes-256-cbc -d -a -K ' . $key . ' -iv 0000 -nosalt -in ' .$idtxt . ' -out ' .$idtxt . '.rar';
        shell_exec($request_encrypt);

        echo "<p><a href='" . $url .".rar' download>Download found file</a>";
        echo "<br>";
        echo "Attention: if the downloaded archive is damaged, it means that you entered the wrong decryption key";
    } else {
        echo "<h3>File not found</h3>";
    }
	
}

echo "</body></html>";
?>


