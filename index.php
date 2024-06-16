<?php
require_once 'functions.php';
session_start();
if (online()) {

  $showStartButton = false;
} else {
  $showStartButton = true;
}
?>

<?php include 'doctype.php';
?>

<body>
  <?php include 'header.php' ?>
  <header>
    <h1>Мониторинг домашних животных</h1>

  </header>
  <main>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <p class="text-left">
          Данное приложение поможет вам внимательно отслеживать здоровье вашего питомца. Вы не пропустите важные
          прививки и
          сможете быстро добавлять заметки о состоянии животного. Это позволит вам не забыть все важные детали при
          встрече с
          ветеринаром. Наше приложение создано, чтобы сделать заботу о вашем питомце простой и удобной, обеспечивая ему
          долгую и здоровую жизнь.
        </p>
        <?php if ($showStartButton): ?>
          <a href="register.php"><button id="registerButton" class="btn btn-primary">Начать</button></a>
        <?php endif; ?>
        <!-- <img src="images/pet.jpg" alt=""> -->
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