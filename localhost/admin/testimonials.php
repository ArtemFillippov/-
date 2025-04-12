<?php
session_start();
include '../components/core.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_testimonial') {
            $name = $_POST['name'];
            $text = $_POST['text'];
            $rating = $_POST['rating'];
            $image = $_FILES['image'] ?? null;
            
            if ($image && $image['error'] === 0) {
                $uploadDir = '../uploads/testimonials/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($image['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $query = "INSERT INTO testimonials (name, text, rating, image) VALUES (?, ?, ?, ?)";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("ssis", $name, $text, $rating, $fileName);
                    $stmt->execute();
                }
            } else {
                $query = "INSERT INTO testimonials (name, text, rating) VALUES (?, ?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ssi", $name, $text, $rating);
                $stmt->execute();
            }
        } 
        elseif ($_POST['action'] === 'update_testimonial') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $text = $_POST['text'];
            $rating = $_POST['rating'];
            $image = $_FILES['image'] ?? null;
            
            if ($image && $image['error'] === 0) {
                $uploadDir = '../uploads/testimonials/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($image['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $query = "UPDATE testimonials SET name = ?, text = ?, rating = ?, image = ? WHERE id = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("ssisi", $name, $text, $rating, $fileName, $id);
                    $stmt->execute();
                }
            } else {
                $query = "UPDATE testimonials SET name = ?, text = ?, rating = ? WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ssii", $name, $text, $rating, $id);
                $stmt->execute();
            }
        }
        elseif ($_POST['action'] === 'delete_testimonial') {
            $id = $_POST['id'];
            $query = "DELETE FROM testimonials WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
}


$result = $mysqli->query("SELECT * FROM testimonials ORDER BY id DESC");
$testimonials = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление отзывами | LexAdvice</title>
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
                <li><a href="practices.php"><i class="fas fa-briefcase"></i> Практики</a></li>
                <li><a href="testimonials.php" class="active"><i class="fas fa-comments"></i> Отзывы</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> Пользователи</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Управление отзывами</h1>
                <button class="btn-add" onclick="showAddTestimonialModal()">Добавить отзыв</button>
            </div>
            
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <?php if ($testimonial['image']): ?>
                    <img src="/uploads/testimonials/<?php echo htmlspecialchars($testimonial['image']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p><?php echo htmlspecialchars($testimonial['text']); ?></p>
                    <div class="testimonial-actions">
                        <button class="btn-edit" onclick="editTestimonial(<?php echo $testimonial['id']; ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" onclick="deleteTestimonial(<?php echo $testimonial['id']; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно добавления/редактирования отзыва -->
    <div id="testimonialModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Добавить отзыв</h2>
            <form id="testimonialForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add_testimonial">
                <input type="hidden" name="id" id="testimonialId">
                
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="text">Текст отзыва:</label>
                    <textarea id="text" name="text" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="rating">Рейтинг:</label>
                    <div class="rating-input">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star" data-rating="<?php echo $i; ?>" onclick="setRating(<?php echo $i; ?>)"></i>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating" value="5">
                </div>
                
                <div class="form-group">
                    <label for="image">Фото:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <div id="imagePreview"></div>
                </div>
                
                <button type="submit" class="btn-save">Сохранить</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('testimonialModal');
        const closeBtn = document.querySelector('.close');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const ratingInput = document.getElementById('rating');
        const stars = document.querySelectorAll('.rating-input .fa-star');
        
        function showAddTestimonialModal() {
            document.getElementById('modalTitle').textContent = 'Добавить отзыв';
            document.getElementById('formAction').value = 'add_testimonial';
            document.getElementById('testimonialId').value = '';
            document.getElementById('testimonialForm').reset();
            imagePreview.innerHTML = '';
            setRating(5);
            modal.style.display = 'block';
        }
        
        function editTestimonial(id) {
            document.getElementById('modalTitle').textContent = 'Редактировать отзыв';
            document.getElementById('formAction').value = 'update_testimonial';
            document.getElementById('testimonialId').value = id;
            
            // Здесь можно добавить AJAX-запрос для получения данных отзыва
            modal.style.display = 'block';
        }
        
        function deleteTestimonial(id) {
            if (confirm('Вы уверены, что хотите удалить этот отзыв?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_testimonial">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function setRating(rating) {
            ratingInput.value = rating;
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
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