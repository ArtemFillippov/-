<?php 
$pageTitle = "О нас";
$currentPage = "about";
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
    <link rel="stylesheet" href="/css/about.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="about-hero">
    <div class="container">
        <h1>О компании LexAdvice</h1>
        <p>Ваш надежный партнер в мире юридических услуг с 2005 года</p>
    </div>
</section>

<section class="about-info">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <h2>Наша история</h2>
                <p>Компания LexAdvice была основана в 2005 году группой опытных юристов, объединенных общей целью - предоставлять качественные юридические услуги, основанные на глубоком понимании бизнеса клиентов и современных правовых тенденций.</p>
                <p>За 15+ лет работы мы выросли из небольшой юридической фирмы в одного из лидеров рынка юридических услуг, сохранив при этом индивидуальный подход к каждому клиенту.</p>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3" alt="Офис LexAdvice">
            </div>
        </div>
    </div>
</section>

<section class="about-values">
    <div class="container">
        <h2>Наши ценности</h2>
        <div class="values-grid">
            <div class="value-card">
                <i class="fas fa-handshake"></i>
                <h3>Доверие</h3>
                <p>Строим долгосрочные отношения с клиентами на основе взаимного доверия и уважения</p>
            </div>
            <div class="value-card">
                <i class="fas fa-chart-line"></i>
                <h3>Развитие</h3>
                <p>Постоянно совершенствуем наши знания и профессиональные навыки</p>
            </div>
            <div class="value-card">
                <i class="fas fa-balance-scale"></i>
                <h3>Этика</h3>
                <p>Следуем высоким стандартам профессиональной этики и конфиденциальности</p>
            </div>
        </div>
    </div>
</section>

<section class="team-extended">
    <div class="container">
        <h2>Ключевые специалисты</h2>
        <div class="team-grid">
            <div class="team-member">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3" alt="Александр Петров">
                <div class="member-info">
                    <h3>Александр Петров</h3>
                    <p class="position">Управляющий партнер</p>
                    <p class="experience">Опыт работы: 20 лет</p>
                    <p class="description">Специализируется на корпоративном праве и M&A. Имеет успешный опыт сопровождения крупных сделок.</p>
                </div>
            </div>
            <div class="team-member">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3" alt="Елена Соколова">
                <div class="member-info">
                    <h3>Елена Соколова</h3>
                    <p class="position">Старший юрист</p>
                    <p class="experience">Опыт работы: 15 лет</p>
                    <p class="description">Эксперт в области судебных споров и арбитража. Успешно представляет интересы клиентов в судах всех инстанций.</p>
                </div>
            </div>
            <div class="team-member">
                <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?ixlib=rb-4.0.3" alt="Михаил Волков">
                <div class="member-info">
                    <h3>Михаил Волков</h3>
                    <p class="position">Ведущий юрист</p>
                    <p class="experience">Опыт работы: 12 лет</p>
                    <p class="description">Специализируется на недвижимости и земельном праве. Имеет обширный опыт структурирования сделок с недвижимостью.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="office-location">
    <div class="container">
        <h2>Наш офис</h2>
        <div class="location-grid">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.5887633096694!2d37.617564315930226!3d55.75721998055643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a50b315e573%3A0xa886bf5a3d9b2e68!2sThe%20Ritz-Carlton%2C%20Moscow!5e0!3m2!1sen!2sru!4v1635838425889!5m2!1sen!2sru" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <div class="office-info">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Адрес</h3>
                        <p>Москва, ул. Примерная, 123</p>
                        <p>Бизнес-центр "Премиум"</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Часы работы</h3>
                        <p>Пн-Пт: 9:00 - 19:00</p>
                        <p>Сб-Вс: По записи</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Контакты</h3>
                        <p>+7 (999) 123-45-67</p>
                        <p>info@lexadvice.ru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?> 
</body>
</html> 