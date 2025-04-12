<?php
session_start();
include '../components/core.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_practice') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image'] ?? null;
            
            if ($image && $image['error'] === 0) {
                $uploadDir = '../uploads/practices/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($image['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $query = "INSERT INTO practices (title, description, image) VALUES (?, ?, ?)";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("sss", $title, $description, $fileName);
                    $stmt->execute();
                }
            } else {
                $query = "INSERT INTO practices (title, description) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ss", $title, $description);
                $stmt->execute();
            }
        } 
        elseif ($_POST['action'] === 'update_practice') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image'] ?? null;
            
            if ($image && $image['error'] === 0) {
                $uploadDir = '../uploads/practices/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($image['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $query = "UPDATE practices SET title = ?, description = ?, image = ? WHERE id = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("sssi", $title, $description, $fileName, $id);
                    $stmt->execute();
                }
            } else {
                $query = "UPDATE practices SET title = ?, description = ? WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ssi", $title, $description, $id);
                $stmt->execute();
            }
        }
        elseif ($_POST['action'] === 'delete_practice') {
            $id = $_POST['id'];
            $query = "DELETE FROM practices WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
}


$result = $mysqli->query("SELECT * FROM practices ORDER BY id DESC");
$practices = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление практиками | LexAdvice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>LexAdvice</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fas fa-home"></i> Главная</a></li>
                <li><a href="applications.php"><i class="fas fa-list"></i> Заявки</a></li>
                <li><a href="services.php"><i class="fas fa-cog"></i> Услуги</a></li>
                <li><a href="practices.php" class="active"><i class="fas fa-briefcase"></i> Практики</a></li>
                <li><a href="testimonials.php"><i class="fas fa-comments"></i> Отзывы</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> Пользователи</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Управление практиками</h1>
                <button class="btn-add" onclick="showAddPracticeModal()">Добавить практику</button>
            </div>
            
            <div class="practices-grid">
                <?php foreach ($practices as $practice): ?>
                <div class="practice-card">
                    <?php if ($practice['image']): ?>
                    <img src="/uploads/practices/<?php echo htmlspecialchars($practice['image']); ?>" alt="<?php echo htmlspecialchars($practice['title']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($practice['title']); ?></h3>
                    <p><?php echo htmlspecialchars($practice['description']); ?></p>
                    <div class="practice-actions">
                        <button class="btn-edit" onclick="editPractice(<?php echo $practice['id']; ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" onclick="deletePractice(<?php echo $practice['id']; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно добавления/редактирования практики -->
    <div id="practiceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Добавить практику</h2>
            <form id="practiceForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_practice">
                <input type="hidden" name="id" id="practiceId">
                
                <div class="form-group">
                    <label for="title">Название:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Описание:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Изображение:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <div id="imagePreview"></div>
                </div>
                
                <button type="submit" class="btn-save">Сохранить</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('practiceModal');
        const closeBtn = document.querySelector('.close');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        
        function showAddPracticeModal() {
            document.getElementById('modalTitle').textContent = 'Добавить практику';
            document.getElementById('formAction').value = 'add_practice';
            document.getElementById('practiceId').value = '';
            document.getElementById('practiceForm').reset();
            imagePreview.innerHTML = '';
            modal.style.display = 'block';
        }
        
        function editPractice(id) {
            document.getElementById('modalTitle').textContent = 'Редактировать практику';
            document.getElementById('formAction').value = 'update_practice';
            document.getElementById('practiceId').value = id;
            
            // Здесь можно добавить AJAX-запрос для получения данных практики
            modal.style.display = 'block';
        }
        
        function deletePractice(id) {
            if (confirm('Вы уверены, что хотите удалить эту практику?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_practice">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; margin-top: 10px;">`;
                }
                reader.readAsDataURL(file);
            }
        });
        
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html> 