<?php 
$pageTitle = "Контакты";
$currentPage = "contacts";
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
    <link rel="stylesheet" href="/css/contacts.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="contacts-hero">
    <div class="container">
        <h1>Контакты</h1>
        <p>Свяжитесь с нами удобным для вас способом</p>
    </div>
</section>

<section class="contact-info">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-details">
                <div class="contact-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Адрес</h3>
                    <p>Москва, ул. Примерная, 123</p>
                    <p>Бизнес-центр "Премиум", 15 этаж</p>
                </div>
                <div class="contact-card">
                    <i class="fas fa-phone"></i>
                    <h3>Телефоны</h3>
                    <p>+7 (999) 123-45-67</p>
                    <p>+7 (999) 765-43-21</p>
                </div>
                <div class="contact-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Email</h3>
                    <p>info@lexadvice.ru</p>
                    <p>support@lexadvice.ru</p>
                </div>
                <div class="contact-card">
                    <i class="fas fa-clock"></i>
                    <h3>Режим работы</h3>
                    <p>Пн-Пт: 9:00 - 19:00</p>
                    <p>Сб-Вс: По записи</p>
                </div>
            </div>
            
            <div class="contact-map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.5887633096694!2d37.617564315930226!3d55.75721998055643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a50b315e573%3A0xa886bf5a3d9b2e68!2sThe%20Ritz-Carlton%2C%20Moscow!5e0!3m2!1sen!2sru!4v1635838425889!5m2!1sen!2sru" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    style="border:0;height: 100%;">
                </iframe>
            </div>
        </div>
    </div>
</section>

<section class="contact-form">
    <div class="container">
        <div class="section-title">
            <h2>Напишите нам</h2>
            <p>Заполните форму, и мы свяжемся с вами в ближайшее время</p>
        </div>
        <div class="form-container">
            <form id="contactForm" action="#" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Ваше имя</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Тема</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="message">Сообщение</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="social-connect">
    <div class="container">
        <div class="section-title">
            <h2>Мы в социальных сетях</h2>
            <p>Следите за нашими новостями и обновлениями</p>
        </div>
        <div class="social-grid">
            <a href="#" class="social-card">
                <i class="fab fa-facebook"></i>
                <span>Facebook</span>
            </a>
            <a href="#" class="social-card">
                <i class="fab fa-twitter"></i>
                <span>Twitter</span>
            </a>
            <a href="#" class="social-card">
                <i class="fab fa-linkedin"></i>
                <span>LinkedIn</span>
            </a>
            <a href="#" class="social-card">
                <i class="fab fa-instagram"></i>
                <span>Instagram</span>
            </a>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>
</html> 