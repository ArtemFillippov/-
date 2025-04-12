<?php
session_start();
include '../components/core.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_user') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];
            
            $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssss", $username, $email, $password, $role);
            $stmt->execute();
        } 
        elseif ($_POST['action'] === 'update_user') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            
            $queryParts = [];
            $paramTypes = "";
            $paramValues = [];
            
            
            if (!empty($username)) {
                $queryParts[] = "username = ?";
                $paramTypes .= "s";
                $paramValues[] = $username;
            }
            
           
            if (!empty($email)) {
                $queryParts[] = "email = ?";
                $paramTypes .= "s";
                $paramValues[] = $email;
            }
            
            
            $queryParts[] = "role = ?";
            $paramTypes .= "s";
            $paramValues[] = $role;
            
            
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $queryParts[] = "password = ?";
                $paramTypes .= "s";
                $paramValues[] = $password;
            }
            
            
            $paramTypes .= "i";
            $paramValues[] = $id;
            
            
            if (!empty($queryParts)) {
                $query = "UPDATE users SET " . implode(", ", $queryParts) . " WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                
                
                if ($stmt) {
                    $bindParamArgs = [];
                    $bindParamArgs[] = $paramTypes;
                    
                    foreach ($paramValues as &$value) {
                        $bindParamArgs[] = &$value;
                    }
                    
                    
                    call_user_func_array([$stmt, 'bind_param'], $bindParamArgs);
                    $stmt->execute();
                }
            }
        }
        elseif ($_POST['action'] === 'delete_user') {
            $id = $_POST['id'];
            if ($id != $_SESSION['user_id']) {
                $query = "DELETE FROM users WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
        }
    }
}


$result = $mysqli->query("SELECT * FROM users ORDER BY id DESC");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями | LexAdvice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
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
                <li><a href="users.php" class="active"><i class="fas fa-users"></i> Пользователи</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h1>Управление пользователями</h1>
                <button class="btn-add" onclick="showAddUserModal()">Добавить пользователя</button>
            </div>
            
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя пользователя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo $user['role']; ?>">
                                    <?php 
                                    $role_labels = [
                                        'admin' => 'Администратор',
                                        'manager' => 'Менеджер',
                                        'user' => 'Пользователь'
                                    ];
                                    echo $role_labels[$user['role']];
                                    ?>
                                </span>
                            </td>
                            <td><?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <button class="btn-edit" onclick="editUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-delete" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Модальное окно добавления/редактирования пользователя -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Добавить пользователя</h2>
            <form id="userForm" method="POST">
                <input type="hidden" name="action" id="formAction" value="add_user">
                <input type="hidden" name="id" id="userId">
                
                <div class="form-group">
                    <label for="username">Имя пользователя:</label>
                    <input type="text" id="username" name="username">
                    <small id="usernameHelp" style="display: none;">Оставьте пустым, если не хотите менять имя</small>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <small id="emailHelp" style="display: none;">Оставьте пустым, если не хотите менять email</small>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                    <small id="passwordHelp">Оставьте пустым, если не хотите менять пароль</small>
                </div>
                
                <div class="form-group">
                    <label for="role">Роль:</label>
                    <select id="role" name="role" required>
                        <option value="user">Пользователь</option>
                        <option value="manager">Менеджер</option>
                        <option value="admin">Администратор</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-save">Сохранить</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('userModal');
        const closeBtn = document.querySelector('.close');
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');
        
        function showAddUserModal() {
            document.getElementById('modalTitle').textContent = 'Добавить пользователя';
            document.getElementById('formAction').value = 'add_user';
            document.getElementById('userId').value = '';
            document.getElementById('userForm').reset();
            
            // При добавлении нового пользователя все поля обязательны
            document.getElementById('username').required = true;
            document.getElementById('email').required = true;
            passwordInput.required = true;
            
            // Скрываем подсказки при добавлении нового пользователя
            passwordHelp.style.display = 'none';
            document.getElementById('usernameHelp').style.display = 'none';
            document.getElementById('emailHelp').style.display = 'none';
            
            modal.style.display = 'block';
        }
        
        function editUser(id) {
            document.getElementById('modalTitle').textContent = 'Редактировать пользователя';
            document.getElementById('formAction').value = 'update_user';
            document.getElementById('userId').value = id;
            passwordInput.required = false;
            passwordHelp.style.display = 'block';
            
            // Показываем подсказки для имени пользователя и email
            document.getElementById('usernameHelp').style.display = 'block';
            document.getElementById('emailHelp').style.display = 'block';
            
            // Очищаем поля, чтобы пользователь мог ввести только то, что хочет изменить
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            
            // Находим выбранного пользователя и устанавливаем его роль
            const userRows = document.querySelectorAll('table tbody tr');
            for (const row of userRows) {
                const userId = row.cells[0].textContent;
                if (userId == id) {
                    const roleText = row.cells[3].querySelector('.role-badge').textContent.trim();
                    const roleSelect = document.getElementById('role');
                    
                    // Устанавливаем значение выпадающего списка на основе текста
                    for (const option of roleSelect.options) {
                        if (option.text === roleText) {
                            option.selected = true;
                            break;
                        }
                    }
                    break;
                }
            }
            
            modal.style.display = 'block';
        }
        
        function deleteUser(id) {
            if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
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
</body>
</html> 