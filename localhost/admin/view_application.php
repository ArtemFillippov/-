<?php
include '../components/core.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/template.php';

$id = $_GET['id'] ?? 0;


$stmt = $mysqli->prepare("
    SELECT a.*, s.title as service_title 
    FROM applications a 
    LEFT JOIN services s ON a.service_id = s.id 
    WHERE a.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$application = $result->fetch_assoc();

if (!$application) {
    header('Location: applications.php');
    exit;
}


ob_start();
?>
<link rel="stylesheet" href="../css/admin.css">
<div class="admin-content">
    <div class="page-header">
        <h2>Заявка #<?php echo $application['id']; ?></h2>
        <div class="page-actions">
            <a href="applications.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к заявкам
            </a>
            <a href="edit_application.php?id=<?php echo $application['id']; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        </div>
    </div>
    
    <div class="application-details">
        <div class="status-badge status-<?php echo $application['status']; ?>">
            <?php 
            $status_labels = [
                'new' => 'Новая',
                'in_progress' => 'В работе',
                'completed' => 'Завершена',
                'rejected' => 'Отклонена'
            ];
            echo $status_labels[$application['status']] ?? 'Новая';
            ?>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <h3><i class="fas fa-user"></i> Клиент</h3>
                <p><?php echo htmlspecialchars($application['name']); ?></p>
                <p><?php echo htmlspecialchars($application['phone']); ?></p>
                <p><?php echo htmlspecialchars($application['email']); ?></p>
            </div>
            
            <div class="info-item">
                <h3><i class="fas fa-briefcase"></i> Услуга</h3>
                <p><?php echo htmlspecialchars($application['service_title'] ?? 'Не указана'); ?></p>
            </div>
            
            <div class="info-item">
                <h3><i class="fas fa-comment"></i> Сообщение</h3>
                <p><?php echo nl2br(htmlspecialchars($application['message'])); ?></p>
            </div>
            
            <div class="info-item">
                <h3><i class="fas fa-calendar"></i> Дата создания</h3>
                <p><?php echo date('d.m.Y H:i', strtotime($application['created_at'])); ?></p>
            </div>
            
            <?php if (!empty($application['comment'])): ?>
            <div class="info-item">
                <h3><i class="fas fa-comment-dots"></i> Комментарий администратора</h3>
                <p><?php echo nl2br(htmlspecialchars($application['comment'])); ?></p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="status-actions">
            <h3>Изменить статус</h3>
            <div class="status-buttons">
                <button class="btn btn-success" onclick="updateStatus(<?php echo $application['id']; ?>, 'completed')">
                    <i class="fas fa-check"></i> Завершить
                </button>
                <button class="btn btn-warning" onclick="updateStatus(<?php echo $application['id']; ?>, 'in_progress')">
                    <i class="fas fa-spinner"></i> Взять в работу
                </button>
                <button class="btn btn-danger" onclick="updateStatus(<?php echo $application['id']; ?>, 'rejected')">
                    <i class="fas fa-times"></i> Отклонить
                </button>
                <button class="btn btn-light" onclick="updateStatus(<?php echo $application['id']; ?>, 'new')">
                    <i class="fas fa-sync"></i> Сбросить до "Новая"
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(id, status) {
        if (confirm('Вы уверены, что хотите изменить статус заявки?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'applications.php';
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
<?php
$content = ob_get_clean();
renderAdminTemplate("Просмотр заявки", $content);
?> 