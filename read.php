<?php
session_start();
include 'db.php';

// Ambil ID artikel dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Query artikel + penulis
$query = "
    SELECT a.*, au.nickname as author
    FROM article a
    LEFT JOIN article_author aa ON a.id = aa.article_id
    LEFT JOIN author au ON aa.author_id = au.id
    WHERE a.id = $id
    LIMIT 1
";
$result = mysqli_query($conn, $query);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    echo "<h2>Artikel tidak ditemukan.</h2>";
    exit;
}

// Query kategori
$category_query = "
    SELECT c.name
    FROM category c
    INNER JOIN article_category ac ON c.id = ac.category_id
    WHERE ac.article_id = $id
";
$category_result = mysqli_query($conn, $category_query);
$categories = [];

while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row['name'];
}
?>

<?php
function highlight_keyword($text, $keyword)
{
    if (!$keyword) return $text;
    return preg_replace(
        '/(' . preg_quote($keyword, '/') . ')/i',
        '<span class="highlight-keyword">$1</span>',
        $text
    );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['title']); ?> - RuangKata</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .highlight-keyword {
            background: yellow;
            color: #222;
            padding: 0 2px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <!-- Button kembali -->
        <a href="index.php" class="btn btn-secondary mb-3">&larr; Kembali ke Beranda</a>
        <div class="row">
            <!-- Kolom Artikel Utama -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-body pb-0">
                        <!-- Judul di atas sendiri -->
                        <h1 class="article-title mb-2"><?php echo htmlspecialchars($article['title']); ?></h1>
                        <!-- Info penulis, tanggal, jam -->
                        <div class="article-meta-info mb-2">
                            <em>
                                <?php
                                function indo_day($date)
                                {
                                    $namahari = date('l', strtotime($date));
                                    $daftar_hari = [
                                        'Sunday' => 'Minggu',
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu'
                                    ];
                                    return $daftar_hari[$namahari] ?? $namahari;
                                }
                                $hari = indo_day($article['date']);
                                $tanggal = date('d F Y', strtotime($article['date']));
                                $jam = date('H:i', strtotime($article['date']));
                                echo "Ditulis pada $hari, $tanggal | $jam by " . htmlspecialchars($article['author'] ?? '');
                                ?>
                            </em>
                        </div>
                        <!-- Kategori (jika ada) -->
                        <?php if (!empty($categories)): ?>
                            <div class="article-category-info mb-2">
                                <strong>Kategori:</strong>
                                <?php echo implode(', ', array_map('htmlspecialchars', $categories)); ?>
                            </div>
                        <?php endif; ?>


                    </div>
                    <?php if ($article['picture']): ?>
                        <div class="article-img-center">
                            <img src="img/<?php echo htmlspecialchars($article['picture']); ?>" class="card-img-top" alt="">
                        </div>
                    <?php endif; ?>
                    <div class="card-body pt-3">
                        <div class="card-text" id="article-content">
                            <?php echo $article['content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Sidebar Kanan -->
            <div class="col-lg-4">
                <!-- Pencarian -->
                <div class="card mb-4">
                    <div class="card-header py-2">
                        <strong>Pencarian</strong>
                    </div>
                    <div class="card-body">
                        <form id="find-form" autocomplete="off">
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="live-search" class="form-control"
                                    placeholder="Masukkan kata kunci...">
                                <button type="submit" class="btn btn-primary" id="find-btn">Go!</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Artikel Terkait -->
                <div class="card">
                    <div class="card-header py-2">
                        <strong>Artikel Terkait</strong>
                    </div>
                    <div class="card-body">
                        <?php
                        // Contoh query artikel terkait (bisa disesuaikan dengan kategori atau random)
                        $related = mysqli_query($conn, "SELECT id, title FROM article WHERE id != $id ORDER BY RAND() LIMIT 3");
                        while ($row = mysqli_fetch_assoc($related)): ?>
                            <div class="mb-2">
                                <a href="read.php?id=<?php echo $row['id']; ?>" class="related-article-link">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('find-form');
        const searchInput = document.getElementById('live-search');
        const articleContent = document.getElementById('article-content');
        const originalContent = articleContent.innerHTML;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const keyword = searchInput.value.trim();
            articleContent.innerHTML = originalContent; // Reset highlight

            if (!keyword) return;

            // Escape regex special chars
            const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp('(' + escaped + ')', 'gi');
            articleContent.innerHTML = originalContent.replace(regex, '<span class="highlight-keyword">$1</span>');

            // Scroll ke highlight pertama jika ada
            const firstHighlight = document.querySelector('.highlight-keyword');
            if (firstHighlight) {
                firstHighlight.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        });
    </script>
</body>

</html>