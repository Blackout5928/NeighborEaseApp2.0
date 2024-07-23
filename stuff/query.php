<?php 

    session_start();
    include 'connection.php';


    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql ="SELECT * FROM `accounts` WHERE `username` = '$username' and `password` ='$password'";

        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($result->num_rows > 0){

            $_SESSION['id'] = $row['id'];

            if ($row['role'] === 'admin') {
                header('location: a-index.php');
            } else {
                header("location: g-index.php");
            }
            exit();
        }
        else{
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
        }
        $con->close();
    }

    if (isset($_POST['ann-post'])) {
        $formControl = $_POST['formControl'];
        $editContainer = $_POST['editorContainers'];
        
        $sql = "INSERT INTO `announcement`(`title`, `content`) VALUES ('$formControl', '$editContainer')";
        $result = mysqli_query($con, $sql);
    
        if ($result) {
            echo "<script>alert('Successfully Inserted')</script>";
            header('a-cpost.php');
        } else {
            echo "<script>alert('Oops, something went wrong')</script>";
        }
        $con->close();
    }


?>