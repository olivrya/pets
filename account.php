<?php
session_start();
require_once 'db.php';

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other desired page
    header("Location: login.php");
    exit;
}

// Handle form submission for adding a new pet
if (isset($_POST['add_pet'])) {
    $user_id = $_SESSION['user_id'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $photo = $_FILES['photo']['name'];
    $age = $_POST['age'];
    $last_vaccination_date = $_POST['last_vaccination_date'];
    $notes = $_POST['notes'];

    // Move uploaded photo to a designated directory
    if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . basename($photo));
    }

    // Insert pet data into the database
    $stmt = $conn->prepare("INSERT INTO pets (user_id, type, name, photo, age, last_vaccination_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiss", $user_id, $type, $name, $photo, $age, $last_vaccination_date, $notes);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show the added pet
    header("Location: account.php");
    exit;
}

// Handle form submission for editing pet notes
if (isset($_POST['edit_notes'])) {
    $pet_id = $_POST['pet_id'];
    $notes = $_POST['notes'];

    // Update pet notes in the database
    $stmt = $conn->prepare("UPDATE pets SET notes = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $notes, $pet_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show the updated pet
    header("Location: account.php");
    exit;
}

// Handle pet deletion
if (isset($_POST['delete_pet'])) {
    $pet_id = $_POST['pet_id'];

    // Delete pet from the database
    $stmt = $conn->prepare("DELETE FROM pets WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $pet_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show the updated list of pets
    header("Location: account.php");
    exit;
}

// Get list of pets from the database
$user_id = $_SESSION['user_id'];
$pets = [];
$stmt = $conn->prepare("SELECT * FROM pets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // Calculate the next vaccination date
    $last_vaccination_date = new DateTime($row['last_vaccination_date']);
    $next_vaccination_date = clone $last_vaccination_date;
    $next_vaccination_date->modify('+1 year');
    $row['next_vaccination_date'] = $next_vaccination_date->format('Y-m-d');
    $pets[] = $row;
}
$stmt->close();
?>
<?php include 'doctype.php';
?>

<body>
    <?php include 'header.php'; ?>
    <header>
        <h1>Мой аккаунт</h1>
    </header>
    <main class="container mt-4">
        <p>Добро пожаловать в ваш аккаунт!</p>
        <p>Здесь вы можете управлять информацией о ваших домашних животных.</p>

        <!-- Button to open the modal for adding a new pet -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPetModal">
            Добавить питомца
        </button>



        <!-- Modal for adding a new pet -->
        <div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPetModalLabel">Добавить нового питомца</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="type" class="form-label">Вид животного</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="Кошка">Кошка</option>
                                    <option value="Собака">Собака</option>
                                    <option value="Грызун">Грызун</option>
                                    <option value="Другое">Другое</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Кличка</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Фотография</label>
                                <input type="file" class="form-control" id="photo" name="photo" required>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Возраст</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_vaccination_date" class="form-label">Дата последней прививки</label>
                                <input type="date" class="form-control" id="last_vaccination_date"
                                    name="last_vaccination_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Заметки</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <button type="submit" name="add_pet" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display list of pets -->
        <h2 class="mt-4">Ваши питомцы</h2>
        <div class="row">
            <?php if ($pets): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="uploads/<?php echo htmlspecialchars($pet['photo']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($pet['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                                <p class="card-text">Вид: <?php echo htmlspecialchars($pet['type']); ?></p>
                                <p class="card-text">Возраст: <?php echo htmlspecialchars($pet['age']); ?> лет</p>
                                <p class="card-text">Дата последней прививки:
                                    <?php echo htmlspecialchars($pet['last_vaccination_date']); ?>
                                </p>
                                <p class="card-text">Дата следующей прививки:
                                    <?php echo htmlspecialchars($pet['next_vaccination_date']); ?>
                                </p>
                                <p class="card-text">Заметки: <?php echo htmlspecialchars($pet['notes']); ?></p>

                                <!-- Button to open the modal for editing pet notes -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editNotesModal<?php echo $pet['id']; ?>">
                                    Изменить заметки
                                </button>

                                <!-- Form to delete pet -->
                                <form method="post" class="mt-2">
                                    <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                    <button type="submit" name="delete_pet" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for editing pet notes -->
                    <div class="modal fade" id="editNotesModal<?php echo $pet['id']; ?>" tabindex="-1"
                        aria-labelledby="editNotesModalLabel<?php echo $pet['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNotesModalLabel<?php echo $pet['id']; ?>">Изменить заметки
                                        для <?php echo htmlspecialchars($pet['name']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Заметки</label>
                                            <textarea class="form-control" id="notes" name="notes"
                                                rows="3"><?php echo htmlspecialchars($pet['notes']); ?></textarea>
                                        </div>
                                        <button type="submit" name="edit_notes" class="btn btn-primary">Сохранить
                                            изменения</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p>У вас еще нет добавленных питомцев.</p>
            <?php endif; ?>
        </div>
        <!-- Logout Button -->
        <form method="post" class="mt-3">
            <button type="submit" name="logout" class="btn btn-danger">Выйти</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
</body>

</html>