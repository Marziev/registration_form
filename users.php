<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>USERS</title>
</head>
<body>
    <div class="form-group container row">
        <h2 class="mx-auto ">Вы успешно авторизовались</h2>
    </div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">email</th>
            <th scope="col">Пол</th>
            <th scope="col">Страна</th>
            <th scope="col">Характеристика</th>
            <th scope="col">Файл</th>
            <th scope="col">Пароль</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user) : ?>
          <tr>
            <th scope="row"><?php echo $user['id']; ?></th>
            <td><?php echo $user['first_name']; ?></td>
            <td><?php echo $user['last_name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['gender']; ?></td>
            <td><?php echo $user['country']; ?></td>
            <td><?php echo $user['summary']; ?></td>
            <td><?php echo $user['file_address']; ?></td>
            <td><?php echo $user['password']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <a href="?mode=admin_panel&page=2">2</a>
      <?php
          require('sen.php');
          if ($_GET['page']) {
            $page = $_GET['page']; 
          } else {
            $page = 1;
          }
            if ($users) {
                  $notesOnPage = 3;
                  $from = ($page - 1) * $notesOnPage;
                  $result = mysqli_query($conn, "SELECT * FROM customers LIMIT $from, $notesOnPage");
                  
      
                  while($answer = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                      $users[] = $answer;        
                  }
                  require('users.php');
          }
      

      ?>
</body>
</html>