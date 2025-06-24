<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
date_default_timezone_set('Asia/Jakarta');
include 'db.php';

// Inisialisasi variabel
$edit = null;
$error = '';
$success = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // 1. Dapatkan nama gambar sebelum menghapus artikel untuk menghapus file terkait
    $stmt_get_picture = mysqli_prepare($conn, "SELECT picture FROM article WHERE id = ?");
    mysqli_stmt_bind_param($stmt_get_picture, "i", $id);
    mysqli_stmt_execute($stmt_get_picture);
    $result_picture = mysqli_stmt_get_result($stmt_get_picture);
    $row_picture = mysqli_fetch_assoc($result_picture);
    $old_picture_filename = $row_picture['picture'] ?? ''; // Nama file gambar lama

    // 2. Hapus artikel dari database menggunakan prepared statement
    $stmt_delete = mysqli_prepare($conn, "DELETE FROM article WHERE id = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    if (mysqli_stmt_execute($stmt_delete)) {
        // 3. Hapus file gambar dari folder 'img/' jika ada dan file tersebut ada
        if (!empty($old_picture_filename) && file_exists('img/' . $old_picture_filename)) {
            unlink('img/' . $old_picture_filename); // Hapus file
        }
        $success = "Artikel berhasil dihapus!";
    } else {
        $error = "Gagal menghapus artikel: " . mysqli_error($conn);
    }
    // Redirect setelah operasi selesai
    header('Location: article.php');
    exit;
}

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $content = strip_tags($content); // Hapus semua tag HTML
    $picture_to_save = ''; // Ini adalah nama file gambar yang akan disimpan ke database

    // Validasi dasar input teks
    if (empty($title) || empty($content)) {
        $error = "Judul dan konten wajib diisi!";
    } else {
        $uploadDir = 'img/';
        $current_picture_in_db = ''; // Untuk menyimpan nama gambar yang ada di DB saat ini (khusus mode edit)

        // Jika dalam mode edit, ambil nama gambar yang sudah ada di database terlebih dahulu
        if (isset($_POST['id']) && $_POST['id']) {
            $id_edit_post = intval($_POST['id']);
            $stmt_get_current_pic = mysqli_prepare($conn, "SELECT picture FROM article WHERE id = ?");
            mysqli_stmt_bind_param($stmt_get_current_pic, "i", $id_edit_post);
            mysqli_stmt_execute($stmt_get_current_pic);
            $result_current_pic = mysqli_stmt_get_result($stmt_get_current_pic);
            $row_current_pic = mysqli_fetch_assoc($result_current_pic);
            $current_picture_in_db = $row_current_pic['picture'] ?? '';
            $picture_to_save = $current_picture_in_db; // Secara default, pertahankan gambar yang sudah ada
        }

        // --- Penanganan Upload Gambar Baru ---
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
            $fileTmpPath = $_FILES['picture']['tmp_name'];
            $fileName = $_FILES['picture']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validasi jenis MIME file untuk keamanan yang lebih baik
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($fileTmpPath);
            $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];
            $max_file_size = 5 * 1024 * 1024; // Maksimum 5 MB

            if (!in_array($mime_type, $allowed_mimes)) {
                $error = "Jenis file gambar tidak diizinkan. Hanya JPG, PNG, GIF.";
            } elseif ($_FILES['picture']['size'] > $max_file_size) {
                $error = "Ukuran file gambar terlalu besar (maks 5MB).";
            } else {
                // Buat nama file unik untuk gambar yang diupload
                $new_filename = uniqid() . '.' . $fileExtension;
                $destination = $uploadDir . $new_filename;

                if (move_uploaded_file($fileTmpPath, $destination)) {
                    $picture_to_save = $new_filename; // Update $picture_to_save dengan nama file baru

                    // Jika ini operasi UPDATE dan ada gambar lama yang diganti, hapus gambar lama
                    if (!empty($current_picture_in_db) && $current_picture_in_db !== $picture_to_save && file_exists($uploadDir . $current_picture_in_db)) {
                        unlink($uploadDir . $current_picture_in_db); // Hapus file gambar lama
                    }
                } else {
                    $error = "Gagal mengunggah gambar. Terjadi kesalahan saat memindahkan file.";
                }
            }
        }
        // Jika tidak ada file baru diupload dan tidak ada error, $picture_to_save akan tetap berisi
        // nama file gambar lama (jika dalam mode edit) atau kosong (jika mode tambah).

        // Lanjutkan operasi database hanya jika tidak ada error dari validasi/upload
        if (empty($error)) {
            if (isset($_POST['id']) && $_POST['id']) {
                // --- Update Artikel ---
                $id = intval($_POST['id']);
                // Menggunakan Prepared Statement untuk keamanan
                // Kolom 'date' TIDAK diikutkan dalam query UPDATE karena diasumsikan sebagai tanggal pembuatan artikel
                $sql = "UPDATE article SET title=?, content=?, picture=? WHERE id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $picture_to_save, $id);

                if (mysqli_stmt_execute($stmt)) {
                    $success = "Artikel berhasil diupdate!";
                    // Update relasi kategori
                    $category_id = intval($_POST['category'] ?? 0);
                    if ($category_id) {
                        mysqli_query($conn, "DELETE FROM article_category WHERE article_id = $id");
                        $stmt_ac = mysqli_prepare($conn, "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");
                        mysqli_stmt_bind_param($stmt_ac, "ii", $id, $category_id);
                        mysqli_stmt_execute($stmt_ac);
                    }
                    // Refresh data $edit setelah update agar form menampilkan data terbaru
                    $res_refresh = mysqli_query($conn, "SELECT * FROM article WHERE id=$id");
                    $edit = mysqli_fetch_assoc($res_refresh);

                    // Tambahkan ini agar dropdown kategori langsung terpilih sesuai perubahan terakhir
                    $selected_category = $category_id;
                } else {
                    $error = "Gagal update artikel: " . mysqli_error($conn);
                }
            } else {
                // --- Tambah Artikel Baru ---
                // Menggunakan Prepared Statement untuk keamanan
                // Kolom 'date' diisi dengan NOW() oleh MySQL secara otomatis
                $sql = "INSERT INTO article (title, content, picture, date) VALUES (?, ?, ?, NOW())";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $title, $content, $picture_to_save);

                if (mysqli_stmt_execute($stmt)) {
                    $success = "Artikel berhasil ditambahkan!";
                    // Setelah berhasil insert artikel
                    $article_id = mysqli_insert_id($conn);
                    $category_id = intval($_POST['category'] ?? 0);
                    if ($category_id) {
                        mysqli_query($conn, "DELETE FROM article_category WHERE article_id = $article_id");
                        $stmt_ac = mysqli_prepare($conn, "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");
                        mysqli_stmt_bind_param($stmt_ac, "ii", $article_id, $category_id);
                        mysqli_stmt_execute($stmt_ac);
                    }
                    $author_id = $_SESSION['user_id'] ?? null; // Dapatkan ID user dari sesi

                    // Tambahkan entri ke tabel article_author jika user_id tersedia
                    if ($author_id) {
                        $stmt_aa = mysqli_prepare($conn, "INSERT INTO article_author (article_id, author_id) VALUES (?, ?)");
                        mysqli_stmt_bind_param($stmt_aa, "ii", $article_id, $author_id);
                        mysqli_stmt_execute($stmt_aa);
                    }
                    // Kosongkan variabel untuk membersihkan form setelah berhasil ditambahkan
                    $title = '';
                    $content = '';
                    $picture_to_save = ''; // Kosongkan agar input file juga kosong
                } else {
                    $error = "Gagal menambah artikel: " . mysqli_error($conn);
                }
            }
        }
    }
    // Tidak ada header('Location: article.php'); exit; di sini, agar pesan error/sukses bisa ditampilkan
}

// Untuk edit (mengambil data artikel jika parameter 'edit' ada di URL)
// Bagian ini dijalankan saat halaman pertama kali dimuat dengan parameter GET 'edit'
if (isset($_GET['edit'])) {
    $id_edit_get = intval($_GET['edit']);
    // Menggunakan Prepared Statement untuk keamanan
    $stmt_edit = mysqli_prepare($conn, "SELECT * FROM article WHERE id = ?");
    mysqli_stmt_bind_param($stmt_edit, "i", $id_edit_get);
    mysqli_stmt_execute($stmt_edit);
    $res_edit = mysqli_stmt_get_result($stmt_edit);
    $edit = mysqli_fetch_assoc($res_edit);
    if (!$edit) {
        $error = "Artikel tidak ditemukan untuk diedit!";
    }
}

$selected_category = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses simpan
    $selected_category = intval($_POST['category'] ?? 0);
} elseif ($edit) {
    $id_edit = intval($edit['id']);
    $res_cat = mysqli_query($conn, "SELECT category_id FROM article_category WHERE article_id = $id_edit LIMIT 1");
    $row_cat = mysqli_fetch_assoc($res_cat);
    $selected_category = $row_cat['category_id'] ?? '';
}

// Ambil data artikel sesuai user login atau semua artikel jika tidak login
$artikel = null; // Inisialisasi variabel
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $stmt_artikel = mysqli_prepare(
        $conn,
        "SELECT a.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS category_name
         FROM article a
         JOIN article_author aa ON a.id = aa.article_id
         LEFT JOIN article_category ac ON a.id = ac.article_id
         LEFT JOIN category c ON ac.category_id = c.id
         WHERE aa.author_id = ?
         GROUP BY a.id
         ORDER BY a.date DESC"
    );
    mysqli_stmt_bind_param($stmt_artikel, "i", $user_id);
    mysqli_stmt_execute($stmt_artikel);
    $artikel = mysqli_stmt_get_result($stmt_artikel);
} else {
    $artikel = mysqli_query(
        $conn,
        "SELECT a.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS category_name
         FROM article a
         LEFT JOIN article_category ac ON a.id = ac.article_id
         LEFT JOIN category c ON ac.category_id = c.id
         GROUP BY a.id
         ORDER BY a.date DESC"
    );
}

// Fungsi untuk menerjemahkan nama hari ke Bahasa Indonesia
function indo_day($date)
{
    $namahari = date('l', strtotime($date));
    switch ($namahari) {
        case 'Sunday':
            return 'Minggu';
        case 'Monday':
            return 'Senin';
        case 'Tuesday':
            return 'Selasa';
        case 'Wednesday':
            return 'Rabu';
        case 'Thursday':
            return 'Kamis';
        case 'Friday':
            return 'Jumat';
        case 'Saturday':
            return 'Sabtu';
        default:
            return $namahari;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Artikel</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            min-height: 250px;
        }
    </style>
</head>

<body>
    <!-- Navbar start -->
    <div class="main-navbar-container">
        <div class="navbar-wrapper">
            <nav class="custom-navbar">
                <a href="index.php" class="navbar-brand-custom">
                    <img src="img/logo.png" alt="Ruang Kata" class="logo-navbar">
                </a>

                <button class="navbar-toggler-custom" type="button" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="navbar-collapse-custom" id="navbarCollapse">
                    <div class="navbar-nav-custom">
                        <a href="index.php" class="nav-item-custom nav-link-custom">Home</a>
                        <a href="article.php" class="nav-item-custom nav-link-custom active">Artikel</a>
                        <a href="category.php" class="nav-item-custom nav-link-custom">Kategori</a>
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
            <h2>Manajemen Artikel</h2>
            <!-- Tombol untuk membuka modal tambah artikel -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel">
                Tambah Artikel
            </button>
        </div>

        <!-- Modal Tambah Artikel -->
        <div class="modal fade" data-bs-backdrop="static" id="modalTambahArtikel" tabindex="-1" aria-labelledby="modalTambahArtikelLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahArtikelLabel">Tambah Artikel Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $hari = date('l');
                            $hari_indonesia = indo_day($hari);
                            ?>
                            <div class="mb-3 mt-3">
                                <label for="date" class="form-label">Tanggal & Waktu</label>
                                <input type="datetime-local" class="form-control" id="date" name="date"
                                    value="<?php echo $edit ? date('Y-m-d\TH:i:s', strtotime($edit['date'])) : date('Y-m-d\TH:i:s'); ?>" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="name" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="" disabled <?php echo empty($selected_category) ? 'selected' : ''; ?>>Pilih Kategori</option>
                                    <?php
                                    $sql = "SELECT id, name FROM category";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['id'] == $selected_category) ? 'selected' : '';
                                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Isi Artikel</label>
                                <textarea class="form-control" id="isi" rows="8" name="content"></textarea>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="picture" class="form-label">Gambar (upload file)</label>
                                <input class="form-control" type="file" id="picture" name="picture">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("isi"), {
                // https://ckeditor.com/docs/ckeditor5/latest/getting-started/setup/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'exportPDF', 'exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Mulai tulis di sini...',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: false
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                // The "superbuild" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'MultiLevelList',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            });
        </script>

        <!-- Tabel Artikel u\ mengedit dan menghapus -->
        <?php if (isset($_GET['edit']) || isset($_GET['add'])): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $edit ? $edit['id'] : ''; ?>">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo $edit ? htmlspecialchars($edit['title']) : ''; ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" disabled <?php echo empty($selected_category) ? 'selected' : ''; ?>>Pilih Kategori</option>
                                <?php
                                $sql = "SELECT id, name FROM category";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $data_id_kategori = $row['id'];
                                        $data_nama_kategori = $row['name'];
                                ?>
                                        <option value="<?php echo $data_id_kategori; ?>">
                                            <?php echo $data_nama_kategori; ?>
                                        </option>
                                <?php
                                    }
                                } else {
                                    echo '<option disabled>Tidak ada kategori</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi</label>
                            <textarea name="content" class="form-control" id="isi" rows="4" required><?php echo $edit ? strip_tags($edit['content']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="articlePicture" class="form-label">Gambar Artikel</label>
                            <input type="file" name="picture" id="articlePicture" class="form-control">
                            <?php if ($edit && $edit['picture']): ?>
                                <small class="form-text text-muted mt-2">Gambar saat ini: <a href="img/<?php echo htmlspecialchars($edit['picture']); ?>" target="_blank"><?php echo htmlspecialchars($edit['picture']); ?></a></small>
                                <img src="img/<?php echo htmlspecialchars($edit['picture']); ?>" alt="Gambar Artikel" class="img-thumbnail mt-2" style="max-width: 150px;">
                            <?php endif; ?>
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a href="article.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="article-card">
            <div class="article-card-body">
                <table class="article-table">
                    <thead>
                        <tr>
                            <th class="th-title">Judul</th>
                            <th class="th-category">Kategori</th> <!-- Tambahkan ini -->
                            <th class="th-date">Tanggal</th>
                            <th class="th-img">Gambar</th>
                            <th class="th-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($artikel)): ?>
                            <tr>
                                <td class="td-title" title="<?php echo htmlspecialchars($row['title']); ?>">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </td>
                                <td class="td-category">
                                    <?php echo htmlspecialchars($row['category_name'] ?? '-'); ?>
                                </td>
                                <td class="td-date">
                                    <?php echo indo_day($row['date']) . ', ' . date('d-m-Y H:i:s', strtotime($row['date'])); ?>
                                </td>
                                <td class="td-img">
                                    <?php if ($row['picture']): ?>
                                        <img src="img/<?php echo htmlspecialchars($row['picture'] ?? 'default.jpg'); ?>" alt="" class="img-thumb">
                                    <?php endif; ?>
                                </td>
                                <td class="td-action">
                                    <a href="article.php?edit=<?php echo $row['id']; ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="article.php?delete=<?php echo $row['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus artikel ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>