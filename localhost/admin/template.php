<?php
function renderAdminTemplate($title, $content) {
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($title); ?> | LexAdvice</title>
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
                    <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> Главная</a></li>
                    <li><a href="applications.php" <?php echo basename($_SERVER['PHP_SELF']) == 'applications.php' ? 'class="active"' : ''; ?>><i class="fas fa-list"></i> Заявки</a></li>
                    <li><a href="services.php" <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'class="active"' : ''; ?>><i class="fas fa-cog"></i> Услуги</a></li>
                    <li><a href="practices.php" <?php echo basename($_SERVER['PHP_SELF']) == 'practices.php' ? 'class="active"' : ''; ?>><i class="fas fa-briefcase"></i> Практики</a></li>
                    <li><a href="testimonials.php" <?php echo basename($_SERVER['PHP_SELF']) == 'testimonials.php' ? 'class="active"' : ''; ?>><i class="fas fa-comments"></i> Отзывы</a></li>
                    <li><a href="users.php" <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'class="active"' : ''; ?>><i class="fas fa-users"></i> Пользователи</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
                </ul>
            </div>
            <div class="main-content">
                <div class="header">
                    <h1><?php echo htmlspecialchars($title); ?></h1>
                    <div>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
                </div>
                
                <?php echo $content; ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?> 