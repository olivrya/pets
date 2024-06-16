<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $login = $_POST['login'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $repeatpass = $_POST['repeatpass'];

  if (empty($login) || empty($pass) || empty($repeatpass) || empty($email)) {
    echo "<script>alert('Заполните все поля'); window.history.back();</script>";
  } else {
    if ($pass != $repeatpass) {
      echo "<script>alert('Пароли не совпадают :('); window.history.back();</script>";
    } else {
      // Проверка на наличие пользователя с таким же логином или email
      $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? OR email = ?");
      $stmt->bind_param("ss", $login, $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<script>alert('Пользователь с таким логином или email уже существует :('); window.history.back();</script>";
      } else {
        // Хеширование пароля
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Вставка нового пользователя
        $stmt = $conn->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $email, $hashed_pass);

        if ($stmt->execute()) {
          $_SESSION['user_id'] = $conn->insert_id;
          $_SESSION['login'] = $login;
          $_SESSION['last_activity'] = time();
          echo "<script>window.location.href = 'account.php';</script>";
        } else {
          echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
      }
    }
  }
}
?>

<?php include 'doctype.php';
?>

<body>
  <?php include 'header.php' ?>

  <header>
    <h1>Регистрация</h1>
  </header>
  <main>
    <div class="d-flex justify-content-center">
      <div>
        <form action=" register.php" method="post" class="my-form">
          <input type="text" placeholder="login" name="login" required>
          <input type="email" placeholder="email" name="email" required>
          <input type="password" placeholder="password" name="pass" required>
          <input type="password" placeholder="repeat password" name="repeatpass" required>
          <button class="btn btn-primary mt-3" type="submit">Зарегистрироваться</button>
        </form>

        <a class="btn btn-secondary m-2" href="login.php" role="button">У меня есть аккаунт</a>
      </div>
    </div>

  </main>
  <?php include 'footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="scripts/main.js"></script>
</body>

</html>