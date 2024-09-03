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
                header("location: g-table.php");
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
        
        // Use prepared statements to avoid SQL injection
        $stmt = $con->prepare("INSERT INTO announcement (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $formControl, $editContainer);
    
        if ($stmt->execute()) {
            echo "<script>alert('Successfully Inserted');</script>";
            // Redirect to the same page after insertion
            header("Location: a-cpost.php");
            exit();
        } else {
            echo "<script>alert('Oops, something went wrong');</script>";
        }
    
        $stmt->close();
        $con->close();
    }
    


    if (isset($_POST['delete'])) {
        if (isset($_POST['id'])) {
            // Get the ID of the announcement to delete
            $id = $_POST['id'];
    
            // Prepare and execute the delete query
            $sql = "DELETE FROM announcement WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                // Redirect back to a-post.php
                header('Location: a-post.php');
                exit(); // Important: Prevents further script execution
            } else {
                echo "Error deleting announcement: " . $con->error;
            }
    
            // Close the connection
            $stmt->close();
            $con->close();
        } else {
            echo "No ID provided for deletion.";
        }
    } else {
        echo "Invalid request.";
    }
    


?>