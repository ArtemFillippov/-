<?php 
$pageTitle = "Практики";
$currentPage = "practices";
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
    <link rel="stylesheet" href="/css/practices.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<section class="practices-hero">
    <div class="container">
        <h1>Наши практики</h1>
        <p>Специализированные направления юридической практики</p>
    </div>
</section>

<section class="practices-areas">
    <div class="container">
        <div class="practices-grid">
            <div class="practice-card">
                <div class="practice-image" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3')"></div>
                <div class="practice-content">
                    <h3>Разрешение споров</h3>
                    <p>Представление интересов клиентов в судебных и арбитражных разбирательствах любой сложности.</p>
                    <ul>
                        <li>Досудебное урегулирование</li>
                        <li>Арбитражные споры</li>
                        <li>Медиация</li>
                        <li>Исполнительное производство</li>
                    </ul>
                    <a href="#" class="btn btn-secondary">Подробнее</a>
                </div>
            </div>

            <div class="practice-card">
                <div class="practice-image" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3')"></div>
                <div class="practice-content">
                    <h3>Банкротство</h3>
                    <p>Комплексное сопровождение процедур банкротства юридических и физических лиц.</p>
                    <ul>
                        <li>Защита интересов кредиторов</li>
                        <li>Сопровождение должников</li>
                        <li>Оспаривание сделок</li>
                        <li>Субсидиарная ответственность</li>
                    </ul>
                    <a href="#" class="btn btn-secondary">Подробнее</a>
                </div>
            </div>

            <div class="practice-card">
                <div class="practice-image" style="background-image: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3')"></div>
                <div class="practice-content">
                    <h3>Антимонопольное право</h3>
                    <p>Защита интересов бизнеса в сфере конкурентного права.</p>
                    <ul>
                        <li>Согласование сделок с ФАС</li>
                        <li>Антимонопольные споры</li>
                        <li>Проверки ФАС</li>
                        <li>Консультации по комплаенсу</li>
                    </ul>
                    <a href="#" class="btn btn-secondary">Подробнее</a>
                </div>
            </div>

            <div class="practice-card">
                <div class="practice-image" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3')"></div>
                <div class="practice-content">
                    <h3>Интеллектуальная собственность</h3>
                    <p>Защита прав на результаты интеллектуальной деятельности.</p>
                    <ul>
                        <li>Регистрация товарных знаков</li>
                        <li>Патентование</li>
                        <li>Авторское право</li>
                        <li>Доменные споры</li>
                    </ul>
                    <a href="#" class="btn btn-secondary">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="expertise">
    <div class="container">
        <div class="section-title">
            <h2>Наша экспертиза</h2>
            <p>Ключевые показатели нашей практической деятельности</p>
        </div>
        <div class="expertise-grid">
            <div class="expertise-item">
                <div class="expertise-number">500+</div>
                <h4>Успешных дел</h4>
                <p>в судах различных инстанций</p>
            </div>
            <div class="expertise-item">
                <div class="expertise-number">15+</div>
                <h4>Отраслей права</h4>
                <p>специализации наших юристов</p>
            </div>
            <div class="expertise-item">
                <div class="expertise-number">100+</div>
                <h4>Компаний</h4>
                <p>на постоянном обслуживании</p>
            </div>
        </div>
    </div>
</section>

<section class="team-experts">
    <div class="container">
        <div class="section-title">
            <h2>Ведущие эксперты практик</h2>
            <p>Профессионалы с обширным опытом в различных отраслях права</p>
        </div>
        <div class="experts-grid">
            <div class="expert-card">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3" alt="Эксперт">
                <div class="expert-info">
                    <h4>Александр Петров</h4>
                    <p class="position">Руководитель практики разрешения споров</p>
                    <p class="experience">Опыт работы: 15 лет</p>
                </div>
            </div>
            <div class="expert-card">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3" alt="Эксперт">
                <div class="expert-info">
                    <h4>Елена Соколова</h4>
                    <p class="position">Руководитель практики банкротства</p>
                    <p class="experience">Опыт работы: 12 лет</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>
</html> 