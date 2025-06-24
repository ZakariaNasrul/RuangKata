<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;

include 'db.php';

// Ambil semua kategori untuk ditampilkan di filter
$kategori_sql = "SELECT id, name FROM category ORDER BY name";
$kategori_result = mysqli_query($conn, $kategori_sql);
$kategori = [];
while ($kat_row = mysqli_fetch_assoc($kategori_result)) {
    $kategori[] = $kat_row;
}
// Ambil kategori yang dipilih
$selected_kategori = null;
$where = '';
$join_category = '';

if (isset($_GET['cat']) && !empty($_GET['cat'])) {
    $selected_kategori = intval($_GET['cat']);
    // Join dengan tabel article_category untuk filter berdasarkan kategori
    $join_category = "INNER JOIN article_category ac ON a.id = ac.article_id";
    $where = "WHERE ac.category_id = $selected_kategori";
}

// Pastikan $join_category dan $where didefinisikan dulu, meskipun kosong
$join_category = $join_category ?? '';
$where = $where ?? '';

$sql = "
    SELECT 
        a.id, 
        a.title, 
        a.picture, 
        a.date,
        GROUP_CONCAT(DISTINCT au.nickname SEPARATOR ', ') AS authors,
        GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories
    FROM article a
    LEFT JOIN article_author aa ON a.id = aa.article_id
    LEFT JOIN author au ON aa.author_id = au.id
    LEFT JOIN article_category ac2 ON a.id = ac2.article_id
    LEFT JOIN category c ON ac2.category_id = c.id
    $join_category
    $where
    GROUP BY a.id, a.title, a.picture, a.date
    ORDER BY a.date DESC
";

$result = mysqli_query($conn, $sql);


// Debug query jika diperlukan
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Ambil semua data artikel ke array
$artikel = [];
$min_len = null;
$max_lines = 2; // default 2 baris
while ($row = mysqli_fetch_assoc($result)) {
    $artikel[] = $row;
    $len = mb_strlen($row['title']);
    if ($min_len === null || $len < $min_len) $min_len = $len;
}

// Hitung max lines (misal 40 karakter per baris, sesuaikan dengan desain)
function count_lines($text, $max_per_line = 40)
{
    return ceil(mb_strlen($text) / $max_per_line);
}

$max_lines = 1;
foreach ($artikel as $row) {
    $lines = count_lines($row['title']);
    if ($lines > $max_lines) $max_lines = $lines;
}

function limit_title($title, $limit = 60)
{
    if (mb_strlen($title) > $limit) {
        return mb_substr($title, 0, $limit) . '...';
    }
    return $title;
}

// Format tanggal Indonesia
function format_date_indonesia($date)
{
    $bulan = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des'
    ];
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);

    return "$day $month $year";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Article Website: RuangKata</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@100;600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                        <a href="index.php" class="nav-item-custom nav-link-custom active">Home</a>
                        <a href="article.php" class="nav-item-custom nav-link-custom">Artikel</a>
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

    <!-- Features Start -->
    <?php
    // Query jumlah artikel
    $q_artikel = mysqli_query($conn, "SELECT COUNT(*) as total FROM article");
    $total_artikel = mysqli_fetch_assoc($q_artikel)['total'];

    // Query jumlah penulis
    $q_penulis = mysqli_query($conn, "SELECT COUNT(*) as total FROM author");
    $total_penulis = mysqli_fetch_assoc($q_penulis)['total'];

    // Ambil kategori dari database
    $q_kategori = mysqli_query($conn, "SELECT id, name FROM category");
    $kategori = [];
    while ($row = mysqli_fetch_assoc($q_kategori)) {
        $kategori[] = $row;
    }
    ?>
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="feature-card text-white bg-primary p-4 rounded h-100 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa fa-newspaper fa-3x"></i>
                    </div>
                    <div>
                        <div class="fs-5 mb-1">Total Artikel</div>
                        <div class="fs-1 fw-bold"><?php echo $total_artikel; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="feature-card text-white bg-success p-4 rounded h-100 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa fa-user-edit fa-3x"></i>
                    </div>
                    <div>
                        <div class="fs-5 mb-1">Total Penulis</div>
                        <div class="fs-1 fw-bold"><?php echo $total_penulis; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Latest News Start -->

    <div class="container-fluid latest-news py-5">
        <div class="container py-5">
            <div class="d-flex align-items-center mb-4">
                <h2 class="mb-0 me-3">Latest News</h2>
                <div class="d-flex flex-wrap gap-2">
                    <a href="index.php" class="btn btn-outline-primary btn-sm<?php if (!$selected_kategori) echo ' active'; ?>">Semua</a>
                    <?php foreach ($kategori as $kat): ?>
                        <a href="index.php?cat=<?php echo $kat['id']; ?>"
                           class="btn btn-outline-primary btn-sm<?php if ($selected_kategori == $kat['id']) echo ' active'; ?>">
                            <?php echo htmlspecialchars($kat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- FEATURED ARTICLE -->
            <?php if (count($artikel) > 0): ?>
                <?php $featured = $artikel[0]; ?>
                <div class="featured-news bg-light p-4 rounded d-flex flex-lg-row flex-column">
                    <!-- Gambar -->
                    <div class="featured-image me-lg-4 mb-3 mb-lg-0">
                        <img src="img/<?php echo htmlspecialchars($featured['picture']); ?>" alt="<?php echo htmlspecialchars($featured['title']); ?>">
                    </div>

                    <!-- Konten -->
                    <div class="featured-content d-flex flex-column justify-content-center">
                        <!-- Featured -->
                        <a href="read.php?id=<?php echo $featured['id']; ?>" class="featured-title text-decoration-none mb-3 article-title">
                            <?php echo htmlspecialchars(limit_title($featured['title'], 120)); ?>
                        </a>
                        <div class="text-muted small">
                            <div><i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($featured['authors'] ?? 'Admin'); ?></div>
                            <div><i class="fas fa-calendar-alt me-1"></i> <?php echo format_date_indonesia($featured['date']); ?></div>
                            <div><i class="fas fa-tags me-1"></i> <?php echo htmlspecialchars($featured['categories'] ?? ''); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- BAGIAN SEMUA ARTIKEL -->
            <div class="d-flex align-items-center mb-4">
                <h2 class="mb-0 me-3 mt-5">All Artikel</h2>
            </div>
            <div class="row g-4">
                <?php foreach (array_slice($artikel, 1) as $row): ?>
                    <div class="col-md-4 latest-news-item">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="small-thumbnail">
                                <img src="img/<?php echo htmlspecialchars($row['picture']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div class="card-body">
                                <!-- Daftar artikel -->
                                <a href="read.php?id=<?php echo $row['id']; ?>" class="h6 text-decoration-none d-block article-title">
                                    <?php echo htmlspecialchars(limit_title($row['title'], 80)); ?>
                                </a>
                                <div class="text-muted mt-2 small">
                                    <div><i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($row['authors'] ?? 'Admin'); ?></div>
                                    <div><i class="fas fa-calendar-alt me-1"></i> <?php echo format_date_indonesia($row['date']); ?></div>
                                    <div><i class="fas fa-tags me-1"></i> <?php echo htmlspecialchars($row['categories']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>



    <!-- Latest News End -->

    <footer class="footer-site mt-5 py-4">
        <div class="container text-center">
            <div class="footer-about mb-2">
                <strong>Tentang RuangKata:</strong>
                <span>
                    Website artikel edukasi yang membahas berbagai topik, tokoh, dan peristiwa
                    penting untuk menambah wawasan pembaca.
                </span>
            </div>
            <div class="footer-copyright text-muted">
                &copy; <?php echo date('Y'); ?> RuangKata. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-article');
            const searchBtn = document.querySelector('.search-btn-custom, .search-btn');
            const searchForm = document.getElementById('search-form');
            const articleCards = document.querySelectorAll('.col-md-4');
            const featuredCard = document.querySelector('.featured-news');
            const allCards = [...articleCards];
            if (featuredCard) allCards.unshift(featuredCard);

            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function highlight(text, keyword) {
                if (!keyword) return text;
                const re = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');
                return text.replace(re, '<mark>$1</mark>');
            }

            function filterArticles() {
                const keyword = searchInput.value.trim().toLowerCase();
                allCards.forEach(card => {
                    const titleElem = card.querySelector('.article-title');
                    if (!titleElem) return;
                    const originalTitle = titleElem.textContent;
                    if (originalTitle.toLowerCase().includes(keyword) || keyword === '') {
                        card.style.display = '';
                        titleElem.innerHTML = highlight(originalTitle, keyword);
                    } else {
                        card.style.display = 'none';
                        titleElem.innerHTML = originalTitle;
                    }
                });
                // Jika pakai OwlCarousel, refresh agar tampilan update
                if (typeof $('.latest-news-carousel').trigger === 'function') {
                    $('.latest-news-carousel').trigger('refresh.owl.carousel');
                }
            }

            // Cegah submit form agar tidak reload
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    filterArticles();
                });
            }

            // Klik tombol search
            if (searchBtn) {
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    filterArticles();
                });
            }

            // Tekan Enter di input
            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        filterArticles();
                    }
                });
            }
        });
    </script>
</body>

</html>