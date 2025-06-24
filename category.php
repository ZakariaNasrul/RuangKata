<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

// Handle tambah/edit/hapus kategori
$edit = null;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$name) {
        $error = "Nama kategori wajib diisi!";
    } else {
        if (isset($_POST['id']) && $_POST['id']) {
            // Edit
            $id = intval($_POST['id']);
            $sql = "UPDATE category SET name=?, description=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);
            if (mysqli_stmt_execute($stmt)) {
                $success = "Kategori berhasil diupdate!";
            } else {
                $error = "Gagal update kategori!";
            }
        } else {
            // Tambah
            $sql = "INSERT INTO category (name, description) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $name, $description);
            if (mysqli_stmt_execute($stmt)) {
                $success = "Kategori berhasil ditambahkan!";
            } else {
                $error = "Gagal menambah kategori!";
            }
        }
    }
}

// Handle hapus
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM category WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $success = "Kategori berhasil dihapus!";
    } else {
        $error = "Gagal menghapus kategori!";
    }
}

// Handle edit (ambil data)
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = "SELECT * FROM category WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit = mysqli_fetch_assoc($result);
}

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM category ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar start -->
    <div class="main-navbar-container">
        <div class="navbar-wrapper">
            <nav class="custom-navbar">
                <a href="index.php" class="navbar-brand-custom">
                    <img src="img/Logo.png" alt="Ruang Kata" class="logo-navbar">
                </a>

                <button class="navbar-toggler-custom" type="button" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="navbar-collapse-custom" id="navbarCollapse">
                    <div class="navbar-nav-custom">
                        <a href="index.php" class="nav-item-custom nav-link-custom">Home</a>
                        <a href="article.php" class="nav-item-custom nav-link-custom">Artikel</a>
                        <a href="category.php" class="nav-item-custom nav-link-custom active">Kategori</a>
                        <a href="penulis.php" class="nav-item-custom nav-link-custom">Penulis</a>
                    </div>

                    <div class="navbar-actions-custom">
                        <div class="search-box-wrapper-custom">
                            <form id="search-form" autocomplete="off">
                                <div class="search-box-inner-custom">
                                    <input type="text" id="search-article" class="search-input-custom"
                                        placeholder="Cari tokoh, topik atau peristiwa">
                                    <button type="submit" class="search-btn-custom" tabindex="-1">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                            <circle cx="11" cy="11" r="7" stroke="#19b3b3" stroke-width="2"
                                                fill="none" />
                                            <line x1="16" y1="16" x2="21" y2="21" stroke="#19b3b3" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="search-suggestions" class="list-group-custom"></div>
                            </form>
                        </div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <span class="user-status-custom">Logged as
                                <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <a href="logout.php" class="btn-logout-custom">Logout</a>
                        <?php else: ?>
                            <a href="login.php" class="btn-login-custom">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.querySelector('.navbar-toggler-custom');
            const collapseDiv = document.getElementById('navbarCollapse');

            if (toggler && collapseDiv) {
                toggler.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true' || false;
                    this.setAttribute('aria-expanded', !isExpanded);
                    if (isExpanded) {
                        collapseDiv.classList.remove('show');
                    } else {
                        collapseDiv.classList.add('show');
                    }
                });
            }
        });
    </script>
    <!-- Navbar End -->
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manajemen Kategori</h2>
            <!-- Tombol untuk membuka modal tambah kategori -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                Tambah Kategori
            </button>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Modal Tambah Kategori -->
        <div class="modal fade" data-bs-backdrop="static" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content category-card">
                    <div class="category-card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Kategori -->
        <?php if ($edit): ?>
            <div class="category-card mb-4">
                <div class="category-card-body">
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($edit['name']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($edit['description']); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="category.php" class="btn btn-secondary me-2">Batal</a>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tabel Kategori -->
        <div class="container py-5">
            <div class="category-card">
                <div class="category-card-body">
                    <table class="category-table">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop data kategori di sini -->
                            <?php while ($row = mysqli_fetch_assoc($kategori)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td>
                                        <a href="category.php?edit=<?php echo $row['id']; ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="category.php?delete=<?php echo $row['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus kategori ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>