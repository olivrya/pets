<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $login = $_POST['login'];
  $pass = $_POST['pass'];

  if (empty($login) || empty($pass)) {
    echo '<script>alert("Заполните все поля"); window.history.back();</script>';
  } else {
    // Подготовленный запрос для защиты от SQL-инъекций
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      // Проверка пароля
      if (password_verify($pass, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['login'] = $row['login'];
        $_SESSION['last_activity'] = time();
        echo "<script>window.location.href = 'account.php';</script>";
      } else {
        echo "<script>alert('Неверный логин или пароль'); window.history.back();</script>";
      }
    } else {
      echo "<script>alert('Неверный логин или пароль'); window.history.back();</script>";
    }

    // Закрытие подготовленного выражения
    $stmt->close();
  }
}
?>

<?php include 'doctype.php';
?>

<body>
  <?php include 'header.php' ?>
  <header>
    <h1>Авторизация</h1>
  </header>
  <main>
    <div class="d-flex justify-content-center">
      <div>
        <form action="login.php" method="post" class="my-form">
          <input type="text" placeholder="login" name="login" required>
          <input type="password" placeholder="password" name="pass" required>
          <button class="btn btn-primary mt-3" type="submit">Войти</button>
        </form>

        <a class="btn btn-secondary m-2" href="register.php" role="button">У меня нет аккаунта</a>
      </div>
    </div>
  </main>
  <?php include 'footer.php' ?>
  <script src="scripts/main.js"></script>
</body>

</html>