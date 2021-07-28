<?php

require('includes/connect.php');

$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : false;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $email = trim($_REQUEST['email']);
    $password = password_hash(trim($_REQUEST['password']), PASSWORD_BCRYPT);
    $gender = ($_REQUEST['gender']);
    $country = ($_REQUEST['country']);
    $summary = mb_substr($_REQUEST['summary'],0,250, 'utf-8');
    // ЗАГРУЗКА ФАЙЛА
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/registration_form/file/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    $file_address = $uploadfile;

    print_r($_FILES);

    echo '<pre>';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo '<div class="alert alert-success" role="alert">';
        echo "Файл успешно загружен";
        echo '</div>';
    } else {
        // echo "Возможная атака с помощью файловой загрузки!\n";
    }

    // echo 'Некоторая отладочная информация:';
    // print_r($_FILES);
    // print_r(basename($_FILES['userfile']['name']));

    print "</pre>";

        if($mode === 'admin_panel') {
            $email = trim($_REQUEST['email']);
            $user = mysqli_query($conn, "SELECT email, password FROM customers where email = '$email' LIMIT 1");
            $user = mysqli_fetch_array($user, MYSQLI_ASSOC);

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $notesOnPage = 3;
            $from = ($page - 1) * $notesOnPage;
            

            if ($user) {
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
            }
            exit;
        }

    $sql = "INSERT INTO customers (first_name, last_name, email, gender, password, country, summary, file_address)
    VALUES ('$first_name', '$last_name', '$email', '$gender', '$password', '$country', '$summary', '$file_address')";

    if (mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-success" role="alert">';
        echo "Пользователь успешно зарегистрирован";
        echo '</div>';
        
        require_once 'includes/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';


        // Настройки SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        
        $mail->Host = 'ssl://smtp.yandex.ru';
        $mail->Port = 465;
        $mail->Username = '*******@yandex.ru';
        $mail->Password = '********';

        
        // От кого
        $mail->setFrom('Zek-006@yandex.ru', 'yandex.ru');		
        
        // Кому
        $mail->addAddress('*********@mail.ru', 'Администратор');
        
        // Тема письма
        $mail->Subject = $subject;
        
        // Тело письма
        $body = '<p><strong>Пользователь ' .$first_name.' успешно зарегистрирован</strong></p>';
        $mail->msgHTML($body);
        
        
        $mail->send();
        
    } else {
        // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo '<div class="alert alert-primary" role="alert">';
        echo "Вы не зарегистрированы ";
        echo '</div>';
    }
}





if ($mode === 'auth') {
    require('auth.html');
} else {
    require('index.html');
}

// require('index.html');

mysqli_close($conn);
?>