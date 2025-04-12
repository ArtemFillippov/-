<?php
session_start();
include '../components/core.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $application_id = $_POST['application_id'] ?? 0;
    $new_status = $_POST['status'] ?? '';
    
    if ($application_id && $new_status) {
        $query = "UPDATE applications SET status = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $new_status, $application_id);
        $stmt->execute();
    }
}


$result = $mysqli->query("
    SELECT a.*, s.title as service_title 
    FROM applications a 
    LEFT JOIN services s ON a.service_id = s.id 
    ORDER BY a.created_at DESC
");
$applications = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заявками | LexAdvice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
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
                <li><a href="testimonials.php"><i class="fas fa-comments"></i> Отзывы</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> Пользователи</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Управление заявками</h1>
            </div>
            
            <div class="applications-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Услуга</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?php echo $app['id']; ?></td>
                            <td><?php echo htmlspecialchars($app['name']); ?></td>
                            <td><?php echo htmlspecialchars($app['phone']); ?></td>
                            <td><?php echo htmlspecialchars($app['email']); ?></td>
                            <td><?php echo htmlspecialchars($app['service_title'] ?? 'Не указана'); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $app['status']; ?>">
                                    <?php 
                                    $status_labels = [
                                        'new' => 'Новая',
                                        'in_progress' => 'В работе',
                                        'completed' => 'Завершена',
                                        'rejected' => 'Отклонена'
                                    ];
                                    echo $status_labels[$app['status']] ?? 'Новая';
                                    ?>
                                </span>
                            </td>
                            <td><?php echo date('d.m.Y H:i', strtotime($app['created_at'])); ?></td>
                            <td class="actions-cell">
                                <a href="edit_application.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-primary" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="view_application.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-info" title="Просмотреть">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-success" title="Отметить как завершенную" onclick="updateStatus(<?php echo $app['id']; ?>, 'completed')">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Взять в работу" onclick="updateStatus(<?php echo $app['id']; ?>, 'in_progress')">
                                    <i class="fas fa-spinner"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Отклонить" onclick="updateStatus(<?php echo $app['id']; ?>, 'rejected')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(id) {
            const details = document.getElementById(`details-${id}`);
            details.classList.toggle('active');
        }

        function updateStatus(id, status) {
            if (confirm('Вы уверены, что хотите изменить статус заявки?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'update_status';
                form.appendChild(actionInput);
                
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'application_id';
                idInput.value = id;
                form.appendChild(idInput);
                
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    
</body>
</html> 