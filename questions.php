<?php
require_once 'functions.php';
session_start();
require_once 'db.php';

// Determine if the user is online
if (online()) {
    $showStartButton = false;
    $user_id = $_SESSION['user_id'];
} else {
    $showStartButton = true;
    $user_id = null;
}

// Handle form submission for adding a new question
if (isset($_POST['submit_question']) && $user_id) {
    $question = $conn->real_escape_string($_POST['question']);

    $sql = "INSERT INTO questions (user_id, question) VALUES ('$user_id', '$question')";
    if ($conn->query($sql) === TRUE) {
        $message = "Ваш вопрос был успешно отправлен!";
    } else {
        $message = "Ошибка: " . $conn->error;
    }
}
?>

<?php include 'doctype.php'; ?>

<body>
    <?php include 'header.php'; ?>
    <header>
        <h1>Частые вопросы</h1>
    </header>
    <main>
        <div class="container">
            <!-- FAQ sections go here -->
            <!-- I'll just include one section for demonstration purposes -->
            <div class="faq-section">
                <h3>1. Как часто нужно делать прививки моему питомцу?</h3>
                <p>Прививки обычно делаются в зависимости от вида животного и его возраста. Котята и щенки получают
                    основные прививки в возрасте 6-8 недель с последующими ревакцинациями через 3-4 недели до достижения
                    16 недель. Взрослым животным необходимо делать ревакцинацию ежегодно или раз в несколько лет в
                    зависимости от типа вакцины и рекомендаций ветеринара.</p>
            </div>

            <div class="faq-section">
                <h3>2. Как часто нужно проводить осмотры у ветеринара?</h3>
                <p>Рекомендуется проводить осмотры у ветеринара как минимум раз в год для взрослых животных и каждые 6
                    месяцев для пожилых животных. Щенки и котята должны проходить осмотры чаще, особенно в первый год
                    жизни.</p>
            </div>

            <div class="faq-section">
                <h3>3. Как узнать, что мой питомец заболел?</h3>
                <p>Признаки болезни могут включать изменение аппетита, потерю веса, вялость, изменения в поведении,
                    кашель, чихание, рвоту, диарею и другие симптомы. Если вы заметили что-то необычное, рекомендуется
                    обратиться к ветеринару.</p>
            </div>

            <div class="faq-section">
                <h3>4. Нужно ли стерилизовать/кастрировать моего питомца?</h3>
                <p>Стерилизация или кастрация может предотвратить нежелательные беременности и снизить риск некоторых
                    заболеваний. Обсудите этот вопрос с вашим ветеринаром, чтобы определить наилучшее время и подход для
                    вашей ситуации.</p>
            </div>

            <div class="faq-section">
                <h3>5. Какие продукты нельзя давать моему питомцу?</h3>
                <p>Некоторые продукты могут быть токсичными для домашних животных. Избегайте шоколада, лука, чеснока,
                    винограда, изюма, авокадо, алкогольных напитков и продуктов с высоким содержанием жира. Всегда
                    консультируйтесь с ветеринаром перед введением новых продуктов в рацион питомца.</p>
            </div>

            <div class="faq-section">
                <h3>6. Как часто нужно чистить зубы моему питомцу?</h3>
                <p>Чистка зубов важна для поддержания здоровья полости рта. Идеально чистить зубы ежедневно или как
                    минимум несколько раз в неделю. Используйте специальную зубную пасту и щетку для животных.
                    Регулярные осмотры у ветеринара помогут предотвратить заболевания зубов и десен.</p>
            </div>

            <div class="faq-section">
                <h3>7. Какие игрушки безопасны для моего питомца?</h3>
                <p>Выбирайте игрушки, соответствующие размеру и активности вашего питомца. Избегайте игрушек с мелкими
                    деталями, которые могут быть проглочены, и острых краев, которые могут поранить. Регулярно
                    проверяйте состояние игрушек и заменяйте их при необходимости.</p>
            </div>

            <div class="faq-section">
                <h3>8. Как часто нужно купать моего питомца?</h3>
                <p>Частота купания зависит от типа шерсти и активности вашего питомца. Собакам с короткой шерстью обычно
                    достаточно купания раз в месяц, в то время как длинношерстных собак может понадобиться купать чаще.
                    Кошек часто купать не требуется, так как они сами хорошо ухаживают за своей шерстью. Используйте
                    специальный шампунь для животных.</p>
            </div>

            <div class="faq-section">
                <h3>9. Как предотвратить блох и клещей у моего питомца?</h3>
                <p>Используйте профилактические средства, такие как ошейники, капли или таблетки от блох и клещей,
                    которые можно приобрести у ветеринара. Регулярно осматривайте питомца на наличие паразитов, особенно
                    после прогулок на улице.</p>
            </div>

            <div class="faq-section">
                <h3>10. Как правильно кормить моего питомца?</h3>
                <p>Рацион вашего питомца должен быть сбалансированным и соответствовать его возрасту, размеру и
                    активности. Кормите питомца качественным кормом, следуйте рекомендациям на упаковке и
                    консультируйтесь с ветеринаром по поводу специальных диет или добавок.</p>
            </div>

            <div class="faq-section">
                <h3>Дополнительные советы</h3>
                <ul>
                    <li>Установите график регулярных осмотров и прививок у ветеринара.</li>
                    <li>Обеспечьте питомцу доступ к чистой питьевой воде.</li>
                    <li>Регулярно ухаживайте за шерстью, когтями и зубами питомца.</li>
                    <li>Следите за весом и уровнем активности питомца, чтобы поддерживать его здоровье.</li>
                </ul>
            </div>

            <div class="faq-section">
                <h3>Задать вопрос</h3>
                <?php if (isset($message)): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if ($user_id): ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="question" class="form-label">Ваш вопрос</label>
                            <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                        </div>
                        <button type="submit" name="submit_question" class="btn btn-primary">Задать вопрос</button>
                    </form>
                <?php else: ?>
                    <p>Чтобы задать вопрос, необходимо <a href="register.php">зарегистрироваться</a> или <a
                            href="login.php">войти в систему</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
</body>

</html>