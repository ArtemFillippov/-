<?php 
$pageTitle = "Личный кабинет";
$currentPage = "profile";
include 'components/core.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$query = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


$query = "SELECT * FROM applications WHERE email = ? ORDER BY created_at DESC";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $user['email']);
$stmt->execute();
$result = $stmt->get_result();
$applications = $result->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $new_email = $_POST['email'] ?? '';
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    $errors = [];
    

    if (!empty($current_password) && !password_verify($current_password, $user['password'])) {
        $errors[] = "Неверный текущий пароль";
    }
    

    if (!empty($new_email) && $new_email !== $user['email']) {
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Некорректный формат email";
        } else {

            $query = "SELECT COUNT(*) FROM users WHERE email = ? AND id != ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("si", $new_email, $user['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->fetch_row()[0] > 0) {
                $errors[] = "Пользователь с таким email уже существует";
            }
        }
    }
    

    if (!empty($new_password)) {
        if (strlen($new_password) < 6) {
            $errors[] = "Новый пароль должен содержать не менее 6 символов";
        } elseif ($new_password !== $confirm_password) {
            $errors[] = "Пароли не совпадают";
        }
    }
    

    if (empty($errors)) {
        $updates = [];
        $params = [];
        $types = "";
        
        if (!empty($new_email) && $new_email !== $user['email']) {
            $updates[] = "email = ?";
            $params[] = $new_email;
            $types .= "s";
        }
        
        if (!empty($new_password)) {
            $updates[] = "password = ?";
            $params[] = password_hash($new_password, PASSWORD_DEFAULT);
            $types .= "s";
        }
        
        if (!empty($updates)) {
            $query = "UPDATE users SET " . implode(", ", $updates) . ", updated_at = NOW() WHERE id = ?";
            $types .= "i";
            $params[] = $user['id'];
            
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                $success_message = "Данные успешно обновлены";
                

                $query = "SELECT * FROM users WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            } else {
                $errors[] = "Ошибка при обновлении данных";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | LexAdvice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/components/header.css">
    <link rel="stylesheet" href="/css/components/footer.css">
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="profile-section">
    <div class="container">
        <h1>Личный кабинет</h1>
        
        <div class="profile-container">
            <div class="profile-sidebar">
                <div class="profile-user">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-info">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
                <ul class="profile-menu">
                    <li><a href="#profile" class="active" data-tab="profile-tab">Профиль</a></li>
                    <li><a href="#applications" data-tab="applications-tab">Мои заявки</a></li>
                    <li><a href="#password" data-tab="password-tab">Смена пароля</a></li>
                </ul>
            </div>
            
            <div class="profile-content">
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <div class="profile-tab active" id="profile-tab">
                    <h2>Мой профиль</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="form-group">
                            <label for="username">Имя пользователя</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="current_password">Текущий пароль</label>
                            <input type="password" id="current_password" name="current_password" placeholder="Введите для подтверждения изменений">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
                
                <div class="profile-tab" id="applications-tab">
                    <h2>Мои заявки</h2>
                    <?php if (empty($applications)): ?>
                        <p class="no-data">У вас еще нет заявок</p>
                    <?php else: ?>
                        <div class="applications-list">
                            <?php foreach ($applications as $app): ?>
                                <div class="application-card">
                                    <div class="application-header">
                                        <h3>Заявка #<?php echo $app['id']; ?></h3>
                                        <span class="status-badge status-<?php echo $app['status']; ?>">
                                            <?php 
                                            $status_labels = [
                                                'new' => 'Новая',
                                                'in_progress' => 'В работе',
                                                'completed' => 'Завершена',
                                                'rejected' => 'Отклонена'
                                            ];
                                            echo $status_labels[$app['status']];
                                            ?>
                                        </span>
                                    </div>
                                    <div class="application-body">
                                        <p><strong>Услуга:</strong> 
                                            <?php 
                                            $service_types = [
                                                'corporate' => 'Корпоративное право',
                                                'litigation' => 'Судебные споры',
                                                'realestate' => 'Недвижимость',
                                                'tax' => 'Налоговое право'
                                            ];
                                            
                                            $serviceType = $app['service_type'] ?? null;
                                            echo $serviceType && isset($service_types[$serviceType]) 
                                                ? $service_types[$serviceType] 
                                                : 'Неизвестная услуга';
                                            ?>
                                        </p>
                                        <p><strong>Сообщение:</strong> <?php echo nl2br(htmlspecialchars($app['message'])); ?></p>
                                        <p><strong>Дата:</strong> <?php echo date('d.m.Y H:i', strtotime($app['created_at'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-tab" id="password-tab">
                    <h2>Смена пароля</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="form-group">
                            <label for="current_password_change">Текущий пароль</label>
                            <input type="password" id="current_password_change" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Новый пароль</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Подтверждение пароля</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Сменить пароль</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.profile-menu a');
    const tabContents = document.querySelectorAll('.profile-tab');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
           
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(t => t.classList.remove('active'));
            

            const targetTab = this.getAttribute('data-tab');
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});
</script>
</body>
</html> 