<?php

$mysqli = mysqli_connect("localhost", "user", "1", "data");

if (isset($_POST['check'])){

$id = $_POST['id'];
$hash_id = openssl_digest ($id , "md5");
$password = $_POST['password'];
$hash_password = openssl_digest ($password , "md5");

echo "You enter id: ". $id;
echo "<br>";
echo "You enter hash id: ". $hash_id;
echo "<br>";
echo "You enter pass: ". $password;
echo "<br>";
echo "You enter hashpass: ". $hash_password;
echo "<br>";

$result = mysqli_query($mysqli, "SELECT id, pass, msg FROM secret WHERE id = '$hash_id' AND pass = '$hash_password';");

$row = mysqli_fetch_assoc($result);

$dbid = $row['id'];

$dbmsg = $row['msg'];

echo "Crypto text: ". $dbmsg;

$method = "AES-256-CBC";
$key = hex2bin('0000'); # Need change 
$iv = hex2bin('0000'); # Need change

$decryptomsg = openssl_decrypt($dbmsg, $method, $key, 0, $iv);
echo "<br>";
echo "Decrypto text: ". $decryptomsg;

}

?>
