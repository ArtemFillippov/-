<?php
include '../components/core.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/template.php';


$stats = [
    'total_applications' => $mysqli->query("SELECT COUNT(*) FROM applications")->fetch_row()[0],
    'new_applications' => $mysqli->query("SELECT COUNT(*) FROM applications WHERE status = 'new'")->fetch_row()[0],
    'in_progress' => $mysqli->query("SELECT COUNT(*) FROM applications WHERE status = 'in_progress'")->fetch_row()[0],
    'completed' => $mysqli->query("SELECT COUNT(*) FROM applications WHERE status = 'completed'")->fetch_row()[0]
];


$result = $mysqli->query("
    SELECT a.*, s.title as service_title 
    FROM applications a 
    LEFT JOIN services s ON a.service_id = s.id 
    ORDER BY a.created_at DESC LIMIT 5
");
$recent_applications = $result->fetch_all(MYSQLI_ASSOC);


ob_start();
?>
<div class="admin-content">
    <div class="stats-grid">
        <div class="stat-card">
            <h3><i class="fas fa-file-alt"></i> Всего заявок</h3>
            <div class="number"><?php echo $stats['total_applications']; ?></div>
        </div>
        <div class="stat-card">
            <h3><i class="fas fa-bell"></i> Новые заявки</h3>
            <div class="number"><?php echo $stats['new_applications']; ?></div>
        </div>
        <div class="stat-card">
            <h3><i class="fas fa-spinner"></i> В работе</h3>
            <div class="number"><?php echo $stats['in_progress']; ?></div>
        </div>
        <div class="stat-card">
            <h3><i class="fas fa-check-circle"></i> Завершено</h3>
            <div class="number"><?php echo $stats['completed']; ?></div>
        </div>
    </div>

    <div class="recent-applications">
        <h2><i class="fas fa-history"></i> Последние заявки</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Услуга</th>
                    <th>Статус</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recent_applications) > 0): ?>
                    <?php foreach ($recent_applications as $app): ?>
                    <tr>
                        <td><?php echo $app['id']; ?></td>
                        <td><?php echo htmlspecialchars($app['name']); ?></td>
                        <td><?php echo htmlspecialchars($app['phone']); ?></td>
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
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Нет доступных заявок</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
renderAdminTemplate("Панель управления", $content);
?> 