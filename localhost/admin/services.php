<?php
include '../components/core.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/template.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $title = $mysqli->real_escape_string($_POST['title']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    
    $query = "INSERT INTO services (title, description, price) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssd", $title, $description, $price);
    
    if ($stmt->execute()) {
        header("Location: services.php?success=1");
        exit();
    } else {
        $error = "Ошибка при добавлении услуги";
    }
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM services WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: services.php?success=2");
    exit();
}


$query = "SELECT * FROM services ORDER BY created_at DESC";
$result = $mysqli->query($query);
$services = $result->fetch_all(MYSQLI_ASSOC);


ob_start();
?>
<div class="admin-content">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 1:
                    echo "Услуга успешно добавлена";
                    break;
                case 2:
                    echo "Услуга успешно удалена";
                    break;
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="header">
        <h1>Управление услугами</h1>
        <button class="btn-add" onclick="showAddServiceModal()">Добавить услугу</button>
    </div>

    <div class="admin-list">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo $service['id']; ?></td>
                        <td><?php echo htmlspecialchars($service['title']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td><?php echo number_format($service['price'], 2); ?> ₽</td>
                        <td>
                            <a href="edit_service.php?id=<?php echo $service['id']; ?>" class="btn btn-sm btn-warning">Редактировать</a>
                            <a href="services.php?delete=<?php echo $service['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<div id="serviceModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Добавить новую услугу</h2>
        <form method="POST" id="serviceForm">
            <input type="hidden" name="add_service" value="1">
            
            <div class="form-group">
                <label for="title">Название услуги:</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Цена:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            
            <button type="submit" class="btn-save">Сохранить</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('serviceModal');
    const closeBtn = document.querySelector('.close');
    
    function showAddServiceModal() {
        modal.style.display = 'block';
    }
    
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }
    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
<?php
$content = ob_get_clean();
renderAdminTemplate("Управление услугами", $content);
?> 