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
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $comment = $_POST['comment'] ?? '';
    
    if (in_array($status, ['new', 'in_progress', 'completed', 'rejected'])) {
        $stmt = $mysqli->prepare("UPDATE applications SET status = ?, comment = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $comment, $id);
        $stmt->execute();
        
        header('Location: index.php');
        exit;
    }
}


ob_start();
?>
<div class="admin-content">
    <div class="application-details">
        <h2>Редактирование заявки #<?php echo $application['id']; ?></h2>
        
        <div class="info-grid">
            <div class="info-item">
                <h3>Клиент</h3>
                <p><?php echo htmlspecialchars($application['name']); ?></p>
                <p><?php echo htmlspecialchars($application['phone']); ?></p>
                <p><?php echo htmlspecialchars($application['email']); ?></p>
            </div>
            
            <div class="info-item">
                <h3>Услуга</h3>
                <p><?php echo htmlspecialchars($application['service_title'] ?? 'Не указана'); ?></p>
            </div>
            
            <div class="info-item">
                <h3>Сообщение</h3>
                <p><?php echo nl2br(htmlspecialchars($application['message'])); ?></p>
            </div>
            
            <div class="info-item">
                <h3>Дата создания</h3>
                <p><?php echo date('d.m.Y H:i', strtotime($application['created_at'])); ?></p>
            </div>
        </div>
        
        <form method="POST" class="status-form">
            <div class="form-group">
                <label for="status">Статус заявки</label>
                <select name="status" id="status" required>
                    <option value="new" <?php echo $application['status'] === 'new' ? 'selected' : ''; ?>>Новая</option>
                    <option value="in_progress" <?php echo $application['status'] === 'in_progress' ? 'selected' : ''; ?>>В работе</option>
                    <option value="completed" <?php echo $application['status'] === 'completed' ? 'selected' : ''; ?>>Завершена</option>
                    <option value="rejected" <?php echo $application['status'] === 'rejected' ? 'selected' : ''; ?>>Отклонена</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea name="comment" id="comment" rows="4"><?php echo htmlspecialchars($application['comment'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="index.php" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
renderAdminTemplate("Редактирование заявки", $content);
?>

<link rel="stylesheet" href="../css/admin.css"> 