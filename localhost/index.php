<?php 
$pageTitle = "Главная";
$currentPage = "index";
include 'components/core.php';


$services_query = "SELECT id, title FROM services ORDER BY title";
$services_result = $mysqli->query($services_query);
$services = [];
if ($services_result) {
    while ($row = $services_result->fetch_assoc()) {
        $services[] = $row;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $service_id = $_POST['service'] ?? '';

    if ($name && $phone && $service_id) {
        try {
            $query = "INSERT INTO applications (name, email, phone, service_id, message, status) VALUES (?, ?, ?, ?, ?, 'new')";
            $stmt = $mysqli->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Ошибка подготовки запроса: " . $mysqli->error);
            }
            
            $stmt->bind_param("sssis", $name, $email, $phone, $service_id, $message);
            
            if (!$stmt->execute()) {
                throw new Exception("Ошибка выполнения запроса: " . $stmt->error);
            }
            
            $success_message = "Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.";
            
        } catch (Exception $e) {
            $error_message = "Ошибка: " . $e->getMessage();
            error_log("Ошибка при отправке заявки: " . $e->getMessage());
        }
    } else {
        $error_message = "Пожалуйста, заполните все обязательные поля.";
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
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Юридическая защита<br>ваших интересов</h1>
        <p>Мы предоставляем комплексные юридические решения для бизнеса и частных лиц с 2005 года</p>
        <a href="#" class="btn btn-primary">Получить консультацию</a>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="section-title">
            <h2>Почему выбирают нас</h2>
            <p>Мы объединяем опыт и инновации для достижения максимальных результатов</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-user-tie"></i>
                <h3>Опытные специалисты</h3>
                <p>Команда профессионалов с опытом работы более 15 лет в различных отраслях права</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-clock"></i>
                <h3>Оперативность</h3>
                <p>Быстрое реагирование на запросы и решение задач в кратчайшие сроки</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Гарантия качества</h3>
                <p>Предоставляем гарантии на все виды юридических услуг</p>
            </div>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="section-title">
            <h2>Наши услуги</h2>
            <p>Предоставляем полный спектр юридических услуг для решения ваших задач</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3')"></div>
                <div class="service-content">
                    <h3>Корпоративное право</h3>
                    <p>Полное юридическое сопровождение бизнеса, регистрация и ликвидация компаний</p>
                </div>
            </div>
            <div class="service-card">
                <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3')"></div>
                <div class="service-content">
                    <h3>Судебные споры</h3>
                    <p>Представительство в судах всех инстанций, арбитраж, медиация</p>
                </div>
            </div>
            <div class="service-card">
                <div class="service-image" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3')"></div>
                <div class="service-content">
                    <h3>Недвижимость</h3>
                    <p>Сопровождение сделок с недвижимостью, оформление прав собственности</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">15+</span>
                <p>Лет опыта</p>
            </div>
            <div class="stat-item">
                <span class="stat-number">2000+</span>
                <p>Выигранных дел</p>
            </div>
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <p>Постоянных клиентов</p>
            </div>
            <div class="stat-item">
                <span class="stat-number">50+</span>
                <p>Профессионалов</p>
            </div>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <div class="section-title">
            <h2>Отзывы наших клиентов</h2>
            <p>Что говорят о нас те, кто уже воспользовался нашими услугами</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <i class="fas fa-quote-left"></i>
                    <p>"Благодаря профессионализму команды LexAdvice мы смогли успешно разрешить сложный корпоративный спор. Очень доволен результатом!"</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3" alt="Андрей Смирнов">
                    <div>
                        <h4>Андрей Смирнов</h4>
                        <p>Генеральный директор, ООО "ТехноПром"</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <i class="fas fa-quote-left"></i>
                    <p>"Отличная команда профессионалов! Оперативно помогли решить все вопросы с оформлением недвижимости. Рекомендую!"</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3" alt="Елена Козлова">
                    <div>
                        <h4>Елена Козлова</h4>
                        <p>Предприниматель</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-form">
    <div class="container">
        <div class="section-title">
            <h2>Получить консультацию</h2>
            <p>Оставьте заявку, и мы свяжемся с вами в ближайшее время</p>
        </div>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <div class="form-container">
            <form id="consultationForm" action="" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="name" required placeholder="Ваше имя">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" required placeholder="Ваш телефон">
                    </div>
                    <div class="form-group full-width">
                        <input type="email" name="email" required placeholder="Ваш email">
                    </div>
                    <div class="form-group full-width">
                        <select name="service" required>
                            <option value="">Выберите услугу</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?php echo $service['id']; ?>"><?php echo $service['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <textarea name="message" required placeholder="Опишите ваш вопрос"></textarea>
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