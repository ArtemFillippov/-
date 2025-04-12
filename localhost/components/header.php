<?php
session_start();
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
    <?php if(isset($currentPage)) { ?>
    <link rel="stylesheet" href="/css/<?php echo $currentPage; ?>.css">
    <?php } ?>
    <script src="/components/script.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">
                <i class="fas fa-balance-scale"></i>
                LexAdvice
            </a>
            <nav>
                <ul id="nav-links">
                    <li><a href="/" <?php echo ($currentPage === 'index') ? 'class="active"' : ''; ?>>Главная</a></li>
                    <li><a href="/about.php" <?php echo ($currentPage === 'about') ? 'class="active"' : ''; ?>>О нас</a></li>
                    <li><a href="/services.php" <?php echo ($currentPage === 'services') ? 'class="active"' : ''; ?>>Услуги</a></li>
                    <li><a href="/practices.php" <?php echo ($currentPage === 'practices') ? 'class="active"' : ''; ?>>Практики</a></li>
                    <li><a href="/contacts.php" <?php echo ($currentPage === 'contacts') ? 'class="active"' : ''; ?>>Контакты</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fas fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/profile.php">Личный кабинет</a></li>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <li><a href="/admin/index.php">Админ-панель</a></li>
                                <?php endif; ?>
                                <li><a href="/logout.php">Выход</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/login.php" <?php echo ($currentPage === 'login') ? 'class="active"' : ''; ?>>Вход</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="burger" id="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </div>
    </header>
</body>
</html> 