<?php 
$pageTitle = "Услуги";
$currentPage = "services";
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
    <link rel="stylesheet" href="/css/services.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="services-hero">
    <div class="container">
        <h1>Наши услуги</h1>
        <p>Комплексные юридические решения для вашего бизнеса</p>
    </div>
</section>

<section class="services-list">
    <div class="container">
        <div class="services-grid">
            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Корпоративное право</h3>
                <ul>
                    <li>Регистрация юридических лиц</li>
                    <li>Внесение изменений в учредительные документы</li>
                    <li>Сопровождение сделок M&A</li>
                    <li>Корпоративные споры</li>
                    <li>Реорганизация компаний</li>
                </ul>
                <a href="#" class="btn btn-secondary">Подробнее</a>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <h3>Судебная практика</h3>
                <ul>
                    <li>Представительство в арбитражных судах</li>
                    <li>Разрешение коммерческих споров</li>
                    <li>Взыскание задолженности</li>
                    <li>Банкротство</li>
                    <li>Медиация</li>
                </ul>
                <a href="#" class="btn btn-secondary">Подробнее</a>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Недвижимость</h3>
                <ul>
                    <li>Сопровождение сделок купли-продажи</li>
                    <li>Due Diligence объектов</li>
                    <li>Оформление прав собственности</li>
                    <li>Земельные споры</li>
                    <li>Строительные споры</li>
                </ul>
                <a href="#" class="btn btn-secondary">Подробнее</a>
            </div>

            <div class="service-item">
                <div class="service-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3>Налоговое право</h3>
                <ul>
                    <li>Налоговое консультирование</li>
                    <li>Налоговые споры</li>
                    <li>Оптимизация налогообложения</li>
                    <li>Сопровождение налоговых проверок</li>
                    <li>Возврат НДС</li>
                </ul>
                <a href="#" class="btn btn-secondary">Подробнее</a>
            </div>
        </div>
    </div>
</section>

<section class="why-choose-service">
    <div class="container">
        <div class="section-title">
            <h2>Почему выбирают наши услуги</h2>
            <p>Мы предлагаем комплексный подход к решению ваших задач</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-item">
                <i class="fas fa-check-circle"></i>
                <h4>Индивидуальный подход</h4>
                <p>Разрабатываем решения под конкретные задачи клиента</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-clock"></i>
                <h4>Оперативность</h4>
                <p>Быстрое реагирование на запросы и соблюдение сроков</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-star"></i>
                <h4>Качество услуг</h4>
                <p>Гарантируем высокий уровень предоставляемых услуг</p>
            </div>
        </div>
    </div>
</section>

<section class="contact-form">
    <div class="container">
        <div class="section-title">
            <h2>Заказать услугу</h2>
            <p>Оставьте заявку, и мы поможем выбрать оптимальное решение для вас</p>
        </div>
        <div class="form-container">
            <form id="serviceForm" action="#" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="name" required placeholder="Ваше имя">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" required placeholder="Ваш телефон">
                    </div>
                    <div class="form-group full-width">
                        <select name="service" required>
                            <option value="">Выберите услугу</option>
                            <option value="corporate">Корпоративное право</option>
                            <option value="litigation">Судебная практика</option>
                            <option value="realestate">Недвижимость</option>
                            <option value="tax">Налоговое право</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <textarea name="message" required placeholder="Опишите вашу задачу"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary">Отправить заявку</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>
</html> 