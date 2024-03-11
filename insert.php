<?php
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$email = $_POST['Email'];
$password = $_POST['Password'];

if (!empty($firstname) || !empty($lastname) || !empty($email) ||!empty($password)){
$host="localhost";
$dbusername = "root";
$dbPassword ="";
$dbname = "";

//create connection
$conn = new mysqli($host, $dbusername, $dbPassword, $dbname);
if (mysqli_connect_error()){
die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
}else{
    $SELECT = "SELECT email FROM register WHERE email =? Limit 1";
    $INSERT ="INSERT Into register(firstName, lastname, email, password) values(?,?,?,?)";
    //prepare statement
    $stmt = $conn -> prepare($SELECT);
    $stmt ->bind_param("s", $email);
    $stmt -> execute();
    $stmt ->bind_result($email);
    $stmt ->store_result();
    $rnum =$stmt->num_rows();

    if($rnum==0){
        $stmt->close();

        $stmt =$conn->prepare($INSERT);
        $stmt ->bind_param("ssss",$firstname, $lastname, $email, $password);
        $stmt ->execute();
        echo "New record Inserted successfully";
    }else{
        echo "Someoene already registered with this email";
    }
    $stmt->close();
    $conn->close();
    }

}else{
echo "All fields are required";
die();
}
?>