<?php
session_start();
include 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Ambil user dari database berdasarkan email
    $query = "SELECT * FROM author WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $user['password'] === $password) { // Ganti dengan password_verify jika sudah hash
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['nickname'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Email atau password salah!';
    }
}

// Ambil semua email dari tabel author untuk autocomplete
$q_suggestion = mysqli_query($conn, "SELECT email FROM author ORDER BY id DESC");
$suggestions = [];
while ($row = mysqli_fetch_assoc($q_suggestion)) {
    $suggestions[] = $row['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Web Artikel</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card p-4 shadow" style="min-width:350px;">
            <h3 class="mb-3 text-center">Login</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" id="loginForm">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="username" id="emailInput" class="form-control" autocomplete="off" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('emailInput');
        // Ambil email yang pernah login dari localStorage
        const usedEmails = JSON.parse(localStorage.getItem('usedEmails') || '[]');
        emailInput.addEventListener('focus', function() {
            if (usedEmails.length > 0) {
                // Jika ada email yang pernah login, tampilkan rekomendasi di bawah input
                let list = document.getElementById('email-recommend');
                if (!list) {
                    list = document.createElement('div');
                    list.id = 'email-recommend';
                    list.style.position = 'absolute';
                    list.style.background = '#fff';
                    list.style.border = '1px solid #ccc';
                    list.style.width = emailInput.offsetWidth + 'px';
                    list.style.zIndex = 1000;
                    list.style.cursor = 'pointer';
                    emailInput.parentNode.appendChild(list);
                }
                list.innerHTML = '';
                usedEmails.forEach(function(email, idx) {
                    const item = document.createElement('div');
                    item.style.display = 'flex';
                    item.style.alignItems = 'center';
                    item.style.justifyContent = 'space-between';
                    item.style.padding = '6px 12px';

                    const emailSpan = document.createElement('span');
                    emailSpan.textContent = email;
                    emailSpan.style.flex = '1';
                    emailSpan.style.cursor = 'pointer';
                    emailSpan.onmousedown = function() {
                        emailInput.value = email;
                        list.style.display = 'none';
                    };

                    const removeBtn = document.createElement('span');
                    removeBtn.textContent = '✕';
                    removeBtn.style.color = '#888';
                    removeBtn.style.marginLeft = '10px';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.title = 'Hapus email ini';
                    removeBtn.onmousedown = function(e) {
                        e.stopPropagation();
                        usedEmails.splice(idx, 1);
                        localStorage.setItem('usedEmails', JSON.stringify(usedEmails));
                        item.remove();
                    };

                    item.appendChild(emailSpan);
                    item.appendChild(removeBtn);
                    list.appendChild(item);
                });
                list.style.display = 'block';
            }
        });
        emailInput.addEventListener('blur', function() {
            setTimeout(() => {
                const list = document.getElementById('email-recommend');
                if (list) list.style.display = 'none';
            }, 200);
        });
        // Setelah login sukses, simpan email ke localStorage
        document.getElementById('loginForm').addEventListener('submit', function() {
            const email = emailInput.value.trim();
            if (email && !usedEmails.includes(email)) {
                usedEmails.unshift(email);
                localStorage.setItem('usedEmails', JSON.stringify(usedEmails.slice(0, 5)));
            }
        });
    });
    </script>
</body>
</html>