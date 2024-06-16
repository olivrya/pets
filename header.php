<?php
require_once 'functions.php';

// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Мониторинг домашних животных</a>
        <img src="images/dalmation.gif">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php"
                        aria-current="page">Главная страница</a>
                </li>

                <li class="nav-item <?php echo ($current_page == 'questions.php') ? 'active' : ''; ?>">
                    <a class="nav-link <?php echo ($current_page == 'questions.php') ? 'active' : ''; ?>"
                        href="questions.php" aria-current="page">Частые вопросы</a>
                </li>

                <?php if (online()): ?>
                    <li class="nav-item <?php echo ($current_page == 'account.php') ? 'active' : ''; ?>">
                        <a class="nav-link <?php echo ($current_page == 'account.php') ? 'active' : ''; ?>"
                            href="account.php" aria-current="page">Мой аккаунт</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">
                        <a class="nav-link <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>"
                            href="register.php" aria-current="page">Войти</a>
                    <?php endif; ?>
                    
            </ul>
        </div>
    </div>
</nav>