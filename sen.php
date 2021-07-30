<?php

require('includes/connect.php');

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $notesOnPage = 3;
    $from = ($page - 1) * $notesOnPage;

    $email = trim($_REQUEST['email']);
    $user = mysqli_query($conn, "SELECT email, password FROM customers where email = '$email' LIMIT 1");
    $user = mysqli_fetch_array($user, MYSQLI_ASSOC);


    if ($user || $page == 1) {
        if (password_verify(trim($_REQUEST['password']), $user['password'])) {
            // $result = mysqli_query($conn, "SELECT * FROM customers");
            $result = mysqli_query($conn, "SELECT * FROM customers LIMIT $from, $notesOnPage");

            while($answer = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $users[] = $answer;
                
            }
            require('users.html');
            
        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo "Пользователь или пароль введен неверно";
            echo '</div>';
            require('auth.html');
        }
    } else {
        $result = mysqli_query($conn, "SELECT * FROM customers LIMIT $from, $notesOnPage");

        while($answer = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $users[] = $answer;
            
        }
        require('users.html');
    }
