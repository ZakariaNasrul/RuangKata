-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 03:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcms`
--
-- --------------------------------------------------------
--
-- Table structure for table `article`
--
CREATE TABLE
  `article` (
    `id` int (11) NOT NULL,
    `date` datetime NOT NULL,
    `title` varchar(255) NOT NULL,
    `content` text NOT NULL,
    `picture` varchar(255) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

--
-- Dumping data for table `article`
--
INSERT INTO
  `article` (`id`, `date`, `title`, `content`, `picture`)
VALUES
  (
    1,
    '2025-02-23 | 05:50:00',
    'AI Generatif: Menata Ulang Masa Depan Kreativitas Digital',
    '<h3>Apa Itu AI Generatif?</h3>
    <p>AI generatif merupakan jenis kecerdasan buatan yang dirancang untuk menciptakan sesuatu yang baru berdasarkan pola data yang sudah dipelajarinya. Teknologi ini bekerja dengan mengandalkan algoritma machine learning, khususnya deep learning, untuk mempelajari kumpulan data besar dan kemudian menghasilkan konten seperti teks, gambar, musik, hingga video. Dalam praktiknya, sistem ini dapat membuat sesuatu yang sebelumnya hanya bisa dilakukan oleh manusia kreatif.</p>
    <p>Contoh paling populer dari AI generatif adalah ChatGPT, DALL·E, dan Midjourney. Ketiganya dapat menghasilkan konten berdasarkan permintaan pengguna dengan cara yang intuitif dan responsif. ChatGPT, misalnya, dapat menulis esai, menjawab pertanyaan, hingga menyusun kode pemrograman hanya dari instruksi singkat. Begitu pula dengan DALL·E dan Midjourney yang mampu menciptakan gambar artistik dari deskripsi kalimat biasa.</p>
    <p>Kehebatan AI generatif tidak berhenti pada kemampuannya menciptakan, melainkan juga bagaimana ia belajar dan beradaptasi. Setiap iterasi pembelajaran membuat AI ini semakin akurat dan relevan dengan permintaan pengguna. Hal ini membuatnya menjadi alat yang sangat berguna dalam berbagai sektor yang membutuhkan kecepatan dan kreativitas dalam menghasilkan konten.</p>

    <h3>Mengapa AI Generatif Jadi Sorotan?</h3>
    <p>Popularitas AI generatif melonjak karena kemampuannya memberikan efisiensi tinggi dalam proses kreatif dan pekerjaan digital. Dengan bantuan AI, proses yang tadinya memakan waktu berjam-jam hingga berhari-hari kini bisa diselesaikan dalam hitungan menit. Misalnya, seorang desainer bisa membuat puluhan konsep hanya dengan input sederhana, atau seorang penulis bisa menyusun draft artikel lengkap dalam waktu singkat.</p>
    <p>Selain efisiensi, daya tarik AI generatif juga terletak pada aksesibilitasnya. Kini, siapa pun, tanpa latar belakang teknis sekalipun, dapat menggunakan alat ini untuk membuat konten. Ini membuka peluang baru bagi masyarakat umum untuk menjadi kreator digital, baik itu dalam bentuk tulisan, desain visual, maupun konten video. AI tidak lagi hanya milik para ahli, melainkan juga tersedia bagi pelajar, guru, pekerja lepas, hingga pebisnis kecil.</p>
    <p>Kemudahan ini membuat AI generatif dianggap sebagai “pemberdaya kreativitas massal”. Ia memberi ruang bagi imajinasi untuk berkembang, sekaligus menurunkan hambatan masuk ke dunia kreatif dan digital. Namun, penting untuk dicatat bahwa meskipun AI dapat menciptakan, sentuhan manusia masih tetap dibutuhkan untuk menilai kualitas, relevansi, dan konteks dari setiap karya yang dihasilkan.</p>

    <h3>Dampaknya di Dunia Industri</h3>
    <p>Berbagai industri kini mulai memanfaatkan AI generatif sebagai alat bantu utama dalam operasional dan pengembangan produk. Dalam dunia pemasaran, misalnya, AI dapat menyusun skrip iklan, caption media sosial, hingga strategi konten dengan cepat dan berdasarkan tren yang sedang berlangsung. Hal ini membantu perusahaan menyesuaikan diri dengan dinamika pasar yang berubah dengan cepat.</p>
    <p>Dalam sektor pendidikan, AI generatif digunakan untuk menyusun bahan ajar, kuis interaktif, bahkan menjawab pertanyaan siswa secara real-time. Ini sangat membantu guru dalam memberikan pengalaman belajar yang lebih personal dan adaptif. Di sisi lain, industri desain dan arsitektur menggunakannya untuk menghasilkan visualisasi konsep dengan presisi dan variasi yang luas, mempercepat proses desain dari sketsa hingga mock-up.</p>
    <p>Tak kalah penting adalah kontribusinya dalam bidang software development. AI generatif bisa membantu programmer dengan menulis kode otomatis, memberikan saran debugging, hingga menyusun dokumentasi. Dengan kehadiran teknologi ini, waktu pengembangan aplikasi dapat dipangkas secara signifikan, sementara kualitas tetap dapat dijaga melalui verifikasi manual oleh tim teknis.</p>

    <h3>Tantangan dan Etika</h3>
    <p>Meski potensinya besar, AI generatif juga menimbulkan banyak perdebatan terkait etika dan tanggung jawab penggunaannya. Salah satu isu utama adalah plagiarisme dan hak cipta, terutama saat AI menghasilkan karya yang mirip dengan buatan manusia lain atau karya yang dilatih dari data yang tidak memiliki izin. Hal ini membuka perdebatan mengenai siapa pemilik sah dari karya yang dihasilkan oleh AI.</p>
    <p>Isu lainnya adalah penyebaran informasi palsu melalui konten deepfake atau manipulasi suara dan video yang tampak realistis. AI generatif bisa digunakan untuk menciptakan konten menyesatkan yang berpotensi merusak reputasi, menyebarkan hoaks, atau bahkan mengganggu stabilitas sosial. Oleh karena itu, perlu adanya regulasi ketat dan teknologi pendeteksi yang mampu membedakan konten asli dan buatan AI.</p>
    <p>Masalah privasi juga menjadi perhatian utama. Banyak sistem AI dilatih menggunakan data publik yang luas, tetapi tidak selalu jelas apakah data tersebut digunakan secara etis atau legal. Ini menimbulkan pertanyaan tentang transparansi proses pelatihan AI dan perlindungan terhadap informasi pribadi yang mungkin terekspos tanpa disadari.</p>

    <h3>Masa Depan Kreativitas Digital</h3>
    <p>Di tengah tantangan tersebut, masa depan AI generatif tetap menjanjikan. Jika digunakan secara bijak, teknologi ini mampu menjadi alat kolaboratif yang memperkuat kapabilitas manusia, bukan menggantikannya. Dalam berbagai sektor kreatif, kehadiran AI akan membuat pekerjaan menjadi lebih efisien, fleksibel, dan terbuka terhadap inovasi lintas disiplin.</p>
    <p>AI juga memungkinkan hadirnya model bisnis baru di bidang konten digital, seperti personalisasi konten skala besar atau layanan desain dan penulisan otomatis yang terjangkau. Dengan demikian, UMKM dan kreator individu dapat bersaing dengan perusahaan besar tanpa perlu investasi mahal. Inilah bentuk demokratisasi teknologi yang sebenarnya.</p>
    <p>Namun, agar visi tersebut terwujud, perlu adanya edukasi yang memadai tentang cara menggunakan AI secara etis dan bertanggung jawab. Literasi digital harus ditingkatkan agar masyarakat tidak hanya menjadi pengguna, tetapi juga kritikus dan pengembang AI yang sadar akan dampaknya terhadap manusia dan lingkungan sosial.</p>

    <h3>Kesimpulan</h3>
    <p>AI generatif membawa revolusi dalam cara manusia berkreasi dan bekerja. Dengan kemampuannya menghasilkan konten secara otomatis dan cepat, ia membuka peluang besar di berbagai sektor industri dan pendidikan. Namun, teknologi ini juga memunculkan tanggung jawab besar terkait etika, privasi, dan keaslian karya.</p>
    <p>Penggunaan AI yang bijak dan transparan menjadi kunci agar teknologi ini benar-benar bisa memberi manfaat jangka panjang. Perlu sinergi antara pengguna, pengembang, dan pembuat kebijakan untuk membentuk ekosistem AI yang aman, inklusif, dan inovatif. Dengan pendekatan yang tepat, AI generatif bisa menjadi katalisator utama dalam menciptakan masa depan digital yang kreatif dan berkelanjutan.</p>
    <p>Di era digital yang semakin cepat berubah, kemampuan untuk beradaptasi dengan teknologi baru seperti AI generatif menjadi sangat penting. Bukan hanya untuk bertahan, tapi juga untuk tumbuh dan memimpin perubahan.</p>',
    'ai-generatif.jpg'
  ),
  (
    2,
    '2025-04-02 | 10:30:00',
    'Revolusi Pembelajaran: Peran AI dalam Mentransformasi Pendidikan Global',
    '<h3>Pendahuluan: Pendidikan dalam Pusaran Teknologi</h3>
    <p>Dunia pendidikan saat ini tengah mengalami transformasi mendalam akibat penetrasi teknologi digital, salah satunya kecerdasan buatan (AI). AI bukan hanya menjadi alat bantu pengajaran, melainkan juga aktor penting dalam mendesain ulang proses belajar-mengajar di berbagai level pendidikan. Dari sekolah dasar hingga universitas, AI hadir untuk menjawab kebutuhan akan efisiensi, personalisasi, dan akses pendidikan yang lebih inklusif.</p>
    <p>Kehadiran AI dalam dunia pendidikan bukanlah hal yang sepenuhnya baru, namun perkembangannya semakin signifikan dalam beberapa tahun terakhir. Berbagai platform pembelajaran seperti Khan Academy, Duolingo, hingga Coursera sudah menggunakan AI untuk menyesuaikan materi dengan kemampuan dan kebutuhan pengguna. AI membuat proses belajar menjadi lebih adaptif dan menarik, terutama bagi generasi digital-native.</p>
    <p>Namun, integrasi AI dalam pendidikan bukan tanpa tantangan. Ia menuntut perubahan paradigma dalam pembelajaran, mulai dari peran guru, metode pengajaran, hingga sistem evaluasi. Oleh karena itu, penting untuk memahami bagaimana AI bekerja dalam konteks pendidikan dan apa implikasinya bagi masa depan generasi pembelajar.</p>

    <h3>AI dan Personalisasi Pembelajaran</h3>
    <p>Salah satu kekuatan utama AI dalam pendidikan terletak pada kemampuannya mempersonalisasi pengalaman belajar. Sistem AI dapat menganalisis gaya belajar, kecepatan pemahaman, hingga minat siswa untuk menyajikan materi yang sesuai. Hasilnya adalah proses pembelajaran yang lebih relevan, efisien, dan tidak membebani peserta didik secara seragam seperti dalam sistem tradisional.</p>
    <p>Misalnya, dalam platform pembelajaran berbasis AI, seorang siswa yang lemah dalam matematika akan mendapat soal latihan tambahan di area tersebut, sementara siswa lain yang unggul dapat langsung melanjutkan ke tingkat yang lebih menantang. Proses ini tidak hanya mempercepat pencapaian kompetensi, tetapi juga mengurangi rasa frustrasi atau kebosanan siswa dalam belajar.</p>
    <p>Teknologi ini juga memberi peluang bagi pendidik untuk lebih fokus pada pengembangan soft skills dan pendampingan emosional siswa, karena tugas administratif dan repetitif dapat diotomatisasi oleh AI. Dengan kata lain, AI tidak menggantikan peran guru, melainkan memperkuat fungsi humanis dari pendidikan.</p>

    <h3>Guru sebagai Mitra AI, Bukan Korban</h3>
    <p>Salah satu kekhawatiran terbesar terhadap AI dalam pendidikan adalah kemungkinan tergesernya peran guru oleh mesin. Padahal, dalam skenario ideal, AI berfungsi sebagai mitra guru, bukan pengganti. Guru tetap memegang kendali dalam proses pembelajaran, sementara AI menyediakan data, rekomendasi, dan tools untuk memperkaya pengalaman mengajar.</p>
    <p>AI dapat membantu guru memahami perkembangan siswa secara lebih menyeluruh. Melalui analisis data, guru bisa melihat pola kesalahan siswa, topik yang sulit dipahami secara kolektif, atau potensi talenta yang perlu dikembangkan lebih lanjut. Ini memungkinkan guru membuat keputusan yang lebih akurat dalam menyusun strategi pengajaran.</p>
    <p>Di sisi lain, peran guru akan berkembang ke arah yang lebih strategis dan empatik. Mereka bukan hanya penyampai materi, tapi juga fasilitator, motivator, dan pembimbing. Ini adalah bentuk kolaborasi manusia dan teknologi yang memperkuat kualitas pendidikan secara menyeluruh.</p>

    <h3>Pendidikan Inklusif dan Akses Global</h3>
    <p>AI juga membuka jalan bagi pendidikan yang lebih inklusif dan merata. Di banyak wilayah terpencil atau negara berkembang, keterbatasan jumlah guru dan sumber belajar menjadi hambatan utama. Dengan teknologi AI, siswa di daerah terpencil bisa mengakses materi ajar berkualitas dunia, belajar dalam bahasa lokal, dan tetap mendapatkan umpan balik secara langsung dari sistem.</p>
    <p>Platform pembelajaran berbasis AI seperti Google Classroom, Edmodo, atau aplikasi lokal seperti Ruangguru dan Zenius sudah mulai mendemokratisasi akses ini. Materi ajar yang dulunya hanya tersedia di ruang-ruang kelas kini bisa dinikmati di layar smartphone, dengan kurikulum yang terus disesuaikan melalui analisis data pengguna.</p>
    <p>Pendidikan untuk penyandang disabilitas juga sangat terbantu dengan kehadiran AI. Misalnya, teknologi pengenalan suara dan teks otomatis membantu siswa tunanetra, sementara algoritma pembelajaran bisa menyesuaikan tempo untuk siswa dengan kesulitan belajar seperti disleksia atau autisme. Ini menunjukkan potensi AI dalam menghadirkan keadilan dalam pendidikan.</p>

    <h3>Tantangan Etika dan Keamanan Data</h3>
    <p>Meskipun menjanjikan, pemanfaatan AI dalam pendidikan menyimpan sejumlah tantangan serius, terutama terkait etika dan privasi data. Dalam sistem pembelajaran berbasis AI, setiap aktivitas siswa terekam dan dianalisis, mulai dari lama waktu membaca materi hingga respons terhadap soal. Data ini sangat sensitif dan berisiko disalahgunakan jika tidak dilindungi dengan baik.</p>
    <p>Isu lainnya adalah ketergantungan berlebihan terhadap algoritma yang bisa membuat proses pendidikan menjadi terlalu mekanistik. Ada kekhawatiran bahwa jika keputusan pendidikan didasarkan sepenuhnya pada data dan AI, maka unsur intuisi, empati, dan konteks sosial akan terabaikan. Padahal, aspek-aspek ini sangat penting dalam proses pembentukan karakter dan nilai.</p>
    <p>Regulasi dan kebijakan yang mengatur penggunaan AI di sektor pendidikan masih terus berkembang. Pemerintah dan penyedia teknologi harus bekerja sama untuk memastikan bahwa penggunaan AI tidak hanya efisien dan inovatif, tetapi juga adil, transparan, dan aman bagi semua pihak.</p>

    <h3>Kesimpulan: Masa Depan Pendidikan Berbasis AI</h3>
    <p>AI telah membawa angin segar bagi dunia pendidikan dengan menjanjikan efisiensi, personalisasi, dan perluasan akses belajar. Dengan kemampuan adaptifnya, AI mampu menyentuh aspek pembelajaran yang selama ini sulit dijangkau oleh sistem tradisional, terutama dalam konteks inklusi dan keterjangkauan.</p>
    <p>Namun, teknologi ini juga menuntut penyesuaian besar dalam sistem pendidikan, termasuk dari para guru, lembaga pendidikan, hingga pembuat kebijakan. Transformasi ini tidak hanya bersifat teknis, tetapi juga menyangkut perubahan budaya dan paradigma dalam belajar. Jika tidak diiringi dengan kesadaran etis dan perlindungan data, maka manfaat AI bisa berubah menjadi ancaman.</p>
    <p>Pendidikan masa depan adalah pendidikan yang kolaboratif antara manusia dan mesin. Guru dan AI harus berjalan beriringan, saling melengkapi demi menciptakan ekosistem belajar yang lebih adaptif, inklusif, dan transformatif. Di tangan yang tepat, AI bukan sekadar alat bantu, melainkan mitra strategis dalam mencetak generasi pembelajar masa depan.</p>',
    'revolusi-pembelajaran-ai.jpg'
  ),
  (
    3,
    '2025-04-01 | 10:00:00',
    'Membangun Masa Depan: Peran Startup Indonesia dalam Mengakselerasi Inovasi Lokal',
    '<h3>Pendahuluan: Kebangkitan Ekosistem Startup di Indonesia</h3>
    <p>Dalam beberapa tahun terakhir, Indonesia menyaksikan lonjakan pesat pertumbuhan startup digital yang merambah berbagai sektor kehidupan. Mulai dari layanan finansial, logistik, kesehatan, hingga pendidikan, startup lokal hadir sebagai jawaban atas berbagai permasalahan masyarakat yang belum tersentuh solusi konvensional. Keberadaan mereka tidak hanya menandai kemajuan teknologi, tetapi juga membuka babak baru dalam perekonomian digital nasional.</p>
    <p>Dukungan dari pemerintah melalui berbagai program inkubasi dan akselerator seperti Gerakan Nasional 1000 Startup Digital serta pendanaan dari investor global menjadi katalis yang memperkuat ekosistem startup tanah air. Tak hanya Jakarta, kota-kota lain seperti Bandung, Yogyakarta, Surabaya, hingga Makassar mulai melahirkan talenta digital dan inisiatif startup dengan identitas lokal yang kuat. Hal ini membuktikan bahwa semangat kewirausahaan berbasis teknologi mulai merata.</p>
    <p>Namun, pertumbuhan cepat ini tidak datang tanpa tantangan. Skala bisnis yang belum stabil, model monetisasi yang belum matang, hingga ketergantungan pada pendanaan eksternal menjadi hambatan yang nyata. Oleh karena itu, penting untuk melihat startup bukan hanya sebagai tren sesaat, melainkan sebagai motor inovasi jangka panjang yang membutuhkan pembinaan berkelanjutan.</p>

    <h3>Startup Sebagai Motor Inovasi Lokal</h3>
    <p>Startup memiliki posisi strategis dalam menciptakan solusi yang dekat dengan kebutuhan masyarakat. Dengan struktur yang lincah dan pendekatan berbasis teknologi, mereka mampu mengeksekusi ide inovatif dengan cepat dan efisien. Inilah yang membedakan mereka dari korporasi besar yang cenderung lambat dalam beradaptasi terhadap perubahan pasar.</p>
    <p>Contoh sukses seperti Gojek, Ruangguru, dan eFishery menunjukkan bagaimana startup lokal bisa menciptakan dampak sosial dan ekonomi yang luas. Mereka tidak hanya menyediakan layanan baru, tetapi juga menciptakan lapangan kerja, meningkatkan efisiensi industri, dan memperluas akses layanan bagi masyarakat yang sebelumnya terpinggirkan. Nilai tambah semacam ini adalah bentuk nyata dari inovasi yang berorientasi pada dampak.</p>
    <p>Lebih dari sekadar teknologi, inovasi yang dibawa startup juga mencakup pendekatan bisnis yang disruptif, misalnya dengan mengandalkan ekonomi berbagi, sistem langganan, hingga pemanfaatan big data untuk pengambilan keputusan. Hal ini menandakan bahwa inovasi lokal Indonesia memiliki daya saing yang tak kalah dari pemain global, asalkan mendapat dukungan dan lingkungan yang kondusif.</p>

    <h3>Peran Inkubator dan Komunitas Digital</h3>
    <p>Untuk memperkuat daya tahan dan keberlangsungan startup, peran inkubator, akselerator, dan komunitas digital menjadi sangat penting. Entitas ini menyediakan bimbingan, jejaring, dan akses ke pendanaan awal yang sangat krusial di tahap-tahap awal pengembangan startup. Tanpa dukungan ini, banyak ide brilian yang berakhir tanpa implementasi.</p>
    <p>Berbagai kampus kini juga mulai membuka program inkubasi startup untuk mahasiswa dan alumni, seperti di ITB, UI, dan Universitas Airlangga. Kolaborasi antara dunia akademik dan industri ini diharapkan bisa memperkaya ekosistem startup dengan riset dan inovasi yang lebih mendalam. Selain itu, komunitas digital seperti Startup Weekend, Tech in Asia, dan komunitas co-working space juga memberikan ruang untuk kolaborasi dan validasi ide.</p>
    <p>Di sisi lain, peran mentor dan praktisi senior dari dunia startup sangat diperlukan untuk memberikan pengalaman nyata yang tidak bisa didapatkan di ruang kelas. Mereka dapat membantu pendiri startup muda menghindari jebakan umum, seperti pengelolaan tim yang buruk, overestimasi pasar, atau kurangnya fokus terhadap pengguna. Dengan demikian, pertumbuhan startup dapat lebih terarah dan berkelanjutan.</p>

    <h3>Mendukung UMKM melalui Teknologi Startup</h3>
    <p>Salah satu dampak paling nyata dari keberadaan startup adalah kontribusinya terhadap digitalisasi UMKM. Banyak startup yang hadir dengan misi membantu UMKM dalam hal pemasaran digital, manajemen keuangan, hingga sistem distribusi. Inovasi ini sangat penting untuk meningkatkan daya saing UMKM di tengah tantangan ekonomi global.</p>
    <p>Platform seperti Tokopedia, Bukalapak, dan Moka POS memberikan kemudahan bagi pelaku usaha kecil untuk berjualan secara daring dan mengelola bisnis secara lebih efisien. Melalui teknologi, UMKM bisa menjangkau konsumen yang lebih luas, bahkan lintas daerah dan negara. Hal ini menciptakan ekosistem ekonomi yang lebih inklusif dan kompetitif.</p>
    <p>Namun, tantangan literasi digital dan kesiapan infrastruktur masih menjadi penghambat utama di daerah. Oleh karena itu, diperlukan sinergi antara startup, pemerintah daerah, dan sektor swasta untuk meningkatkan pelatihan dan akses teknologi bagi pelaku UMKM. Dengan demikian, manfaat digitalisasi benar-benar bisa dirasakan secara merata.</p>

    <h3>Tantangan Keberlanjutan dan Model Bisnis</h3>
    <p>Meskipun pertumbuhan startup di Indonesia menjanjikan, tidak sedikit yang gagal bertahan dalam 2-3 tahun pertama. Salah satu penyebab utama adalah kurangnya kejelasan model bisnis dan ketergantungan pada pendanaan investor. Banyak startup yang fokus pada akuisisi pengguna tanpa strategi monetisasi yang kuat, sehingga akhirnya kesulitan mempertahankan operasional.</p>
    <p>Selain itu, kondisi makroekonomi global juga mempengaruhi ekosistem startup. Penurunan investasi, fluktuasi nilai tukar, dan ketidakpastian pasar dapat menyebabkan banyak investor mengerem pendanaan. Di sinilah pentingnya membangun bisnis dengan fondasi yang sehat, fokus pada keberlanjutan jangka panjang, dan bukan hanya pertumbuhan cepat.</p>
    <p>Startup yang sukses adalah mereka yang mampu menyeimbangkan antara pertumbuhan dan profitabilitas. Mereka harus bisa berinovasi dalam menciptakan nilai, namun tetap realistis dalam pengelolaan sumber daya. Pendekatan lean startup dan validasi pasar yang kuat adalah kunci untuk memastikan ide yang dikembangkan benar-benar dibutuhkan oleh pasar.</p>

    <h3>Kesimpulan: Mendorong Ekosistem Inovasi yang Berkelanjutan</h2>
    <p>Startup bukan sekadar tren atau buzzword, melainkan pilar penting dalam ekonomi digital Indonesia. Mereka membawa semangat perubahan dan keberanian untuk memecahkan masalah dengan cara-cara baru yang lebih adaptif. Jika dikelola dengan baik, startup bisa menjadi katalis inovasi yang tidak hanya berdampak lokal, tetapi juga regional dan global.</p>
    <p>Untuk itu, dukungan terhadap startup harus bersifat holistik, mencakup aspek regulasi, pembiayaan, edukasi, hingga kolaborasi lintas sektor. Pemerintah, industri, akademisi, dan masyarakat perlu bersinergi dalam membangun ekosistem yang mendorong pertumbuhan startup secara sehat dan berkelanjutan.</p>
    <p>Dengan terus mendorong inovasi lokal, kita membuka peluang baru bagi generasi muda untuk berkarya, menciptakan solusi, dan menjadi bagian dari transformasi ekonomi nasional. Inilah saatnya membangun masa depan melalui kekuatan startup dan semangat inovasi yang tak pernah padam.</p>',
    'startup-indonesia.jpg'
  ),
  (
    4,
    '2025-04-15 | 05:00:00',
    'Transformasi Digital Sektor Pertanian: Peran Startup Agritech dalam Meningkatkan Produktivitas Petani Indonesia',
    '<h3>Pendahuluan: Digitalisasi dan Masa Depan Pertanian</h3>
    <p>Pertanian merupakan salah satu sektor penting dalam perekonomian Indonesia yang menyerap jutaan tenaga kerja dan menopang kebutuhan pangan nasional. Namun, sektor ini masih menghadapi tantangan klasik seperti produktivitas rendah, keterbatasan akses pasar, serta minimnya teknologi yang digunakan oleh petani. Seiring perkembangan teknologi digital, muncul gelombang baru inovasi yang mencoba menjawab tantangan ini melalui pendekatan modern.</p>
    <p>Startup agritech hadir dengan misi mempercepat transformasi digital sektor pertanian. Mereka menawarkan solusi berbasis teknologi seperti pemantauan lahan berbasis sensor, sistem irigasi pintar, hingga platform pemasaran hasil pertanian secara online. Pendekatan ini diharapkan mampu meningkatkan efisiensi, transparansi, dan daya saing petani di era modern.</p>
    <p>Fenomena ini menandai era baru bagi dunia pertanian Indonesia, di mana petani tak lagi sekadar mengandalkan metode tradisional, tetapi mulai memanfaatkan data, aplikasi, dan konektivitas internet untuk mengambil keputusan yang lebih cerdas. Ini bukan hanya soal teknologi, tapi tentang memperkuat posisi petani sebagai aktor utama dalam ekosistem pangan nasional.</p>

    <h3>Solusi Inovatif Startup Agritech Lokal</h3>
    <p>Berbagai startup agritech Indonesia telah menunjukkan potensi besar dalam memberikan solusi konkret. Misalnya, <strong>Habibi Garden</strong> mengembangkan sensor tanah dan sistem berbasis Internet of Things (IoT) untuk membantu petani memantau kondisi lahan secara real-time. Dengan teknologi ini, petani dapat menentukan waktu penyiraman atau pemupukan yang lebih tepat, sehingga hasil panen bisa meningkat signifikan.</p>
    <p>Sementara itu, <strong>TaniHub</strong> dan <strong>Sayurbox</strong> menawarkan platform digital yang menghubungkan petani langsung dengan konsumen atau pelaku bisnis, tanpa harus melalui rantai distribusi yang panjang dan tidak efisien. Dengan demikian, petani mendapatkan harga jual yang lebih adil dan konsumen memperoleh produk segar dengan harga bersaing. Inovasi semacam ini membawa semangat ekonomi berbagi yang mendekatkan produsen dan pasar secara langsung.</p>
    <p>Tak ketinggalan, beberapa startup juga berfokus pada edukasi petani, seperti <strong>8villages</strong>, yang menyediakan platform informasi pertanian berbasis SMS dan aplikasi. Petani dapat memperoleh tips pertanian, informasi harga pasar, dan saran teknis dari ahli secara langsung. Transformasi ini mengubah cara petani memperoleh informasi, dari yang sebelumnya terbatas menjadi lebih inklusif dan berbasis komunitas.</p>

    <h3>Dampak Ekonomi dan Sosial</h3>
    <p>Peran startup agritech tidak hanya berdampak pada sisi teknis pertanian, tetapi juga memiliki pengaruh luas terhadap kehidupan sosial dan ekonomi petani. Dengan meningkatnya efisiensi dan akses pasar, pendapatan petani cenderung naik, yang pada gilirannya meningkatkan kesejahteraan rumah tangga petani. Mereka pun lebih termotivasi untuk mengembangkan lahan dan bereksperimen dengan metode baru yang lebih produktif.</p>
    <p>Di sisi lain, keterlibatan generasi muda dalam sektor pertanian mulai meningkat berkat sentuhan teknologi. Startup agritech menciptakan citra baru bahwa bertani tidak lagi identik dengan pekerjaan konvensional, tetapi bisa menjadi profesi modern yang menarik dan menjanjikan. Ini penting mengingat tantangan regenerasi petani menjadi isu serius yang mengancam keberlanjutan sektor ini di masa depan.</p>
    <p>Lebih luas lagi, digitalisasi pertanian juga memberikan kontribusi terhadap ketahanan pangan nasional. Dengan data yang lebih akurat, pemerintah dan pelaku industri dapat melakukan perencanaan produksi, distribusi, dan logistik pangan secara lebih tepat. Efisiensi rantai pasok pun meningkat, mengurangi potensi pemborosan atau kerugian akibat kelebihan pasokan.</p>

    <h3>Tantangan dan Kebutuhan Dukungan</h3>
    <p>Meskipun perkembangan startup agritech menjanjikan, mereka juga menghadapi sejumlah tantangan. Salah satunya adalah tingkat literasi digital petani yang masih rendah, terutama di wilayah pedesaan. Implementasi teknologi seringkali terhambat oleh keterbatasan pemahaman pengguna serta infrastruktur digital seperti koneksi internet yang belum merata.</p>
    <p>Masalah lainnya adalah pembiayaan. Banyak petani yang belum memiliki akses ke modal untuk membeli alat-alat teknologi baru atau mengakses layanan digital premium. Di sisi lain, startup agritech sendiri juga memerlukan dukungan finansial untuk memperluas layanan mereka ke daerah yang lebih terpencil dan membutuhkan. Sinergi antara pemerintah, lembaga keuangan, dan investor menjadi kunci agar skala dampak dapat ditingkatkan.</p>
    <p>Dukungan kebijakan juga sangat penting. Pemerintah perlu menciptakan regulasi yang mendukung perkembangan startup agritech, termasuk insentif fiskal, penyederhanaan perizinan, dan integrasi data pertanian. Selain itu, perlu ada kerjasama lintas sektor antara kementerian, institusi riset, dan pelaku bisnis untuk memastikan teknologi yang dikembangkan relevan dan aplikatif di lapangan.</p>

    <h3>Kesimpulan: Masa Depan Pertanian yang Cerdas</h3>
    <p>Startup agritech memiliki peran vital dalam membentuk masa depan pertanian Indonesia yang lebih modern, efisien, dan berkelanjutan. Mereka membawa semangat inovasi ke sektor yang selama ini cenderung tertinggal dalam adopsi teknologi. Dengan menghubungkan petani dengan data, pasar, dan edukasi, agritech tidak hanya meningkatkan produktivitas, tetapi juga martabat profesi petani itu sendiri.</p>
    <p>Agar dampaknya semakin luas, kolaborasi lintas sektor perlu diperkuat. Pemerintah, swasta, akademisi, dan masyarakat harus berjalan beriringan dalam menciptakan ekosistem agritech yang tangguh. Keberhasilan transformasi digital pertanian bukan hanya tanggung jawab startup semata, melainkan agenda nasional yang menyangkut kedaulatan pangan dan kesejahteraan jutaan keluarga petani.</p>
    <p>Dengan pendekatan yang inklusif dan berorientasi pada dampak, agritech membuka jalan menuju pertanian cerdas yang mampu menjawab tantangan masa depan. Ini adalah peluang besar bagi Indonesia untuk tidak hanya menjadi lumbung pangan, tetapi juga pusat inovasi agraria di tingkat regional.</p>',
    'transformasi-digital-pertanian.jpg'
  ),
  (
    5,
    '2025-05-20 | 23:00:00',
    'Kebangkitan Perangkat Lipat: Evolusi Desain dalam Dunia Smartphone Modern',
    '<h3>Era Baru Desain Smartphone</h3>
    <p>Industri smartphone terus berevolusi dalam menghadirkan inovasi yang tak hanya menjawab kebutuhan fungsional pengguna, tetapi juga menciptakan pengalaman baru dalam penggunaan sehari-hari. Salah satu tren paling menonjol dalam beberapa tahun terakhir adalah kehadiran smartphone lipat atau <em>foldable phone</em>. Perangkat ini membawa angin segar dalam dunia desain gadget, menyatukan portabilitas dengan layar besar dalam satu bentuk yang revolusioner.</p>
    <p>Berawal dari konsep yang tampak futuristik, perangkat lipat kini telah hadir dalam berbagai bentuk dan merk terkemuka, seperti Samsung Galaxy Z Fold, Huawei Mate X, dan Oppo Find N. Kehadiran mereka menandai kembalinya era eksplorasi desain setelah bertahun-tahun pasar didominasi oleh bentuk candybar yang cenderung seragam. Dengan layar fleksibel berbasis OLED, pengguna dapat menikmati transisi mulus antara mode smartphone dan tablet.</p>
    <p>Tidak hanya tampilan yang berubah, namun juga paradigma interaksi pengguna terhadap perangkat. Smartphone lipat memungkinkan multitasking lebih efisien, pengalaman menonton yang lebih imersif, dan kreativitas yang lebih luas dalam penggunaan aplikasi. Inilah yang menjadikan tren ini bukan sekadar gimmick, tetapi awal dari perubahan mendalam dalam cara kita menggunakan teknologi mobile.</p>

    <h3>Tantangan Teknologi dan Inovasi yang Didorong</h3>
    <p>Meski menjanjikan, pengembangan perangkat lipat bukan tanpa hambatan. Salah satu tantangan terbesar adalah menciptakan layar yang tahan terhadap lipatan ribuan kali tanpa mengalami penurunan kualitas visual. Teknologi seperti Ultra Thin Glass (UTG) dan engsel canggih yang dirancang untuk fleksibilitas dan durabilitas telah menjadi fokus utama dalam pengembangan perangkat ini.</p>
    <p>Selain layar, desain engsel juga memainkan peran penting. Engsel harus memungkinkan lipatan yang presisi dan halus, namun tetap kokoh dan tahan lama. Untuk itu, berbagai merek mengembangkan mekanisme unik—mulai dari engsel tersembunyi, sistem sapuan debu otomatis, hingga struktur multi-lapisan pelindung yang inovatif. Semua ini menunjukkan betapa tingginya standar teknis yang harus dipenuhi dalam menghadirkan pengalaman pengguna yang optimal.</p>
    <p>Namun, inovasi tidak berhenti di hardware. Pengembangan perangkat lunak untuk mendukung transisi layar juga krusial. Sistem operasi harus bisa merespons perubahan bentuk layar secara real-time dan aplikasi perlu dioptimalkan agar bisa berjalan mulus dalam berbagai mode. Kolaborasi antara produsen hardware dan pengembang aplikasi menjadi kunci sukses perangkat lipat di pasar global.</p>

    <h3>Dampak Terhadap Industri dan Gaya Hidup</h3>
    <p>Munculnya perangkat lipat berdampak signifikan terhadap ekosistem industri teknologi secara keseluruhan. Produsen aksesori, pengembang aplikasi, bahkan desainer antarmuka pun harus menyesuaikan pendekatan mereka. Dengan layar yang dapat berubah ukuran, standar UI/UX juga mengalami transformasi agar tetap intuitif dan responsif terhadap dinamika penggunaan.</p>
    <p>Di sisi konsumen, perangkat lipat menjadi simbol gaya hidup modern yang menggabungkan produktivitas dan hiburan dalam satu perangkat. Pebisnis, kreator konten, hingga pengguna profesional menyambut baik kemampuannya untuk membuka banyak jendela sekaligus, menggambar dengan stylus, atau menonton video dengan layar penuh tanpa mengorbankan kenyamanan membawa perangkat besar.</p>
    <p>Selain itu, perangkat lipat membuka potensi baru dalam desain wearable dan perangkat hybrid lainnya. Konsep yang semula dianggap hanya cocok untuk smartphone kini mulai diterapkan dalam laptop, tablet, bahkan perangkat e-reader. Ini memperluas cakupan inovasi dan memberi arah baru dalam evolusi perangkat pintar yang lebih adaptif dan fungsional.</p>

    <h3>Respons Pasar dan Arah Masa Depan</h3>
    <p>Saat pertama kali diperkenalkan, perangkat lipat menuai keraguan dari pasar karena harga yang tinggi dan ketahanan yang dipertanyakan. Namun, seiring waktu, teknologi yang makin matang serta respons positif dari pengguna awal membantu mengubah persepsi publik. Laporan terbaru menunjukkan peningkatan penjualan perangkat lipat secara global, terutama di pasar Asia dan Amerika Utara.</p>
    <p>Harga yang semula menjadi hambatan kini mulai menurun, seiring makin banyaknya model yang diluncurkan dengan rentang harga lebih terjangkau. Ini membuka jalan bagi adopsi lebih luas, terutama di kalangan pengguna teknologi menengah ke atas. Produsen pun mulai bersaing tidak hanya pada spesifikasi teknis, tetapi juga pada nilai fungsional dan pengalaman penggunaan.</p>
    <p>Ke depan, diperkirakan bahwa perangkat lipat akan menjadi arus utama dalam desain gadget, menggantikan dominasi perangkat monoblok tradisional. Dengan berkembangnya teknologi layar, baterai fleksibel, dan material baru yang lebih ringan, masa depan perangkat mobile semakin mengarah pada fleksibilitas dan adaptabilitas tinggi. Dunia teknologi memasuki babak baru di mana bentuk bukan lagi batasan, melainkan sarana untuk berekspresi dan berinovasi.</p>

    <h3>Kesimpulan</h3>
    <p>Perangkat lipat menandai era baru dalam desain dan inovasi smartphone, menghadirkan perpaduan antara portabilitas dan layar besar yang fleksibel. Meski menghadapi tantangan teknis seperti ketahanan layar dan desain engsel, kemajuan teknologi dan kolaborasi antara produsen hardware serta pengembang aplikasi terus mendorong adopsi perangkat ini. Kehadiran smartphone lipat tidak hanya mengubah cara berinteraksi dengan teknologi, tetapi juga memengaruhi industri, gaya hidup, dan standar desain perangkat pintar ke depan. Dengan harga yang semakin terjangkau dan inovasi yang terus berkembang, perangkat lipat diprediksi akan menjadi tren utama masa depan, membuka peluang baru dalam ekspresi, produktivitas, dan inovasi teknologi mobile.</p>',
    'perangkat-lipat-smartphone.jpg'
  ),
  (
    6,
    '2025-06-02 | 11:00:00',
    'Quantum Computing: Menembus Batas Komputasi Konvensional di Era Digital',
    '<h3>Awal Mula Quantum Computing dan Paradigmanya</h3>
    <p>Komputasi kuantum atau <em>quantum computing</em> merupakan terobosan besar dalam dunia teknologi informasi, yang menawarkan pendekatan radikal terhadap cara kerja komputer. Tidak lagi mengandalkan bit biner tradisional yang hanya mengenal 0 dan 1, komputasi kuantum menggunakan <em>qubit</em> yang dapat berada dalam superposisi—yakni berada di posisi 0 dan 1 secara bersamaan. Konsep ini diambil dari prinsip mekanika kuantum, yang membuka potensi kecepatan dan efisiensi komputasi yang jauh melampaui sistem klasik.</p>
    <p>Sejak dirintis oleh para ilmuwan pada akhir abad ke-20, quantum computing kini menjadi perhatian utama dalam bidang teknologi tinggi. Perusahaan seperti IBM, Google, dan D-Wave telah mengembangkan prototipe komputer kuantum yang mampu menyelesaikan perhitungan rumit dalam waktu yang sangat singkat, dibandingkan dengan komputer super sekalipun. Ini menjadikan quantum computing sebagai tulang punggung dari revolusi digital tahap berikutnya.</p>
    <p>Namun, teknologi ini masih dalam tahap eksplorasi aktif dan belum mencapai kematangan untuk penggunaan komersial luas. Kompleksitas dalam menjaga kestabilan qubit, tantangan pendinginan ekstrem, serta koreksi kesalahan kuantum masih menjadi kendala besar. Meski demikian, perkembangan signifikan terus terjadi, dengan prediksi bahwa dalam satu dekade ke depan, komputer kuantum bisa mulai diterapkan dalam skenario dunia nyata.</p>

    <h3>Keunggulan dan Potensi Aplikasinya</h3>
    <p>Salah satu keunggulan utama komputasi kuantum adalah kemampuannya dalam menyelesaikan masalah kompleks yang tak mampu ditangani oleh komputer konvensional. Hal ini mencakup simulasi molekul kimia untuk pengembangan obat, optimalisasi logistik dalam skala besar, hingga peretasan dan pengamanan kriptografi masa depan. Potensi ini menjadikan banyak sektor industri mulai berinvestasi dalam penelitian dan kolaborasi quantum.</p>
    <p>Di bidang farmasi, komputasi kuantum memungkinkan simulasi molekul secara presisi untuk menemukan senyawa obat baru dalam waktu yang jauh lebih singkat. Dalam sektor keuangan, quantum computing dapat digunakan untuk menganalisis risiko dan prediksi pasar dengan model yang sangat kompleks dan dinamis. Bahkan di dunia kecerdasan buatan, algoritma pembelajaran mesin berbasis kuantum tengah dikembangkan untuk meningkatkan efisiensi dan ketepatan hasil.</p>
    <p>Tak kalah penting adalah kontribusinya dalam keamanan data. Di satu sisi, komputer kuantum berpotensi meretas sistem enkripsi yang ada sekarang. Namun di sisi lain, muncul pula konsep <em>quantum cryptography</em> yang menawarkan keamanan mutlak berbasis prinsip kuantum. Ini memunculkan persaingan dan urgensi baru dalam mengembangkan sistem keamanan digital yang tahan terhadap era kuantum.</p>

    <h3>Tantangan Infrastruktur dan Sumber Daya</h3>
    <p>Untuk dapat mengimplementasikan komputer kuantum secara luas, dibutuhkan infrastruktur khusus yang jauh berbeda dari pusat data konvensional. Komputer kuantum harus beroperasi dalam suhu mendekati nol absolut menggunakan pendingin cryogenic, yang sangat mahal dan kompleks. Hal ini menjadi tantangan utama dalam menyiapkan ekosistem yang layak dan hemat energi.</p>
    <p>Selain itu, ketersediaan tenaga ahli di bidang ini masih sangat terbatas. Komputasi kuantum menggabungkan ilmu fisika, matematika, dan ilmu komputer tingkat lanjut yang tidak banyak dikuasai oleh profesional teknologi saat ini. Maka, institusi pendidikan tinggi pun mulai merancang kurikulum khusus untuk menyiapkan talenta di bidang ini. Investasi pada SDM menjadi krusial untuk menjaga momentum pengembangan teknologi kuantum.</p>
    <p>Tantangan lain adalah kebutuhan perangkat lunak dan algoritma yang bisa diadaptasi ke sistem kuantum. Karena cara kerja komputer kuantum sangat berbeda dengan komputer biasa, pengembang harus membuat pendekatan baru dalam pemrograman, arsitektur sistem, dan manajemen data. Platform seperti Qiskit (oleh IBM) dan Cirq (oleh Google) menjadi awal dari terbentuknya ekosistem pengembangan software kuantum.</p>

    <h3>Masa Depan Quantum Computing dalam Dunia Nyata</h3>
    <p>Walaupun masih dalam tahap riset dan pengembangan, banyak kalangan memprediksi bahwa komputasi kuantum akan menjadi fondasi teknologi masa depan. Sebagaimana AI yang kini telah diadopsi secara masif, quantum computing pun diyakini akan mengalami fase akselerasi begitu teknologi dasar dan infrastruktur telah mapan. Negara-negara maju bahkan telah menjadikan ini sebagai proyek strategis nasional.</p>
    <p>Amerika Serikat, Tiongkok, dan Uni Eropa bersaing dalam mengembangkan teknologi ini melalui dana penelitian miliaran dolar. Startup dan perusahaan raksasa teknologi ikut serta dalam balapan untuk menjadi pionir dalam bidang ini. Semakin dini mereka menguasai quantum computing, semakin besar peluang untuk menguasai industri-industri penting di masa depan.</p>
    <p>Adopsi quantum computing diperkirakan akan bersifat bertahap, dimulai dari sektor-sektor dengan kebutuhan komputasi ekstrem. Namun begitu kesiapan teknologinya stabil dan biaya produksinya menurun, adopsi massal sangat mungkin terjadi. Quantum computing tidak sekadar mempercepat proses, tetapi juga berpotensi membuka jawaban atas permasalahan yang selama ini dianggap tak terpecahkan oleh sistem komputasi tradisional.</p>

    <h3>Kesimpulan: Quantum Computing dan Transformasi Digital</h3>
    <p>Quantum computing bukan sekadar lompatan teknologi, melainkan fondasi baru bagi masa depan digital dunia. Dengan kemampuannya menembus batas komputasi konvensional, teknologi ini membuka peluang inovasi di berbagai sektor, mulai dari kesehatan, keuangan, hingga keamanan data. Namun, perjalanan menuju adopsi luas masih dipenuhi tantangan teknis, infrastruktur, dan sumber daya manusia.</p>
    <p>Kolaborasi lintas disiplin dan investasi berkelanjutan sangat dibutuhkan untuk mempercepat kematangan teknologi ini. Pemerintah, akademisi, dan industri harus bersinergi dalam membangun ekosistem quantum yang inklusif dan adaptif terhadap perubahan. Pendidikan dan pelatihan talenta baru menjadi kunci agar bangsa tidak hanya menjadi pengguna, tetapi juga pelaku utama dalam revolusi kuantum.</p>
    <p>Di masa depan, quantum computing diprediksi akan menjadi katalisator utama dalam menyelesaikan tantangan global yang selama ini tak terpecahkan. Dengan pendekatan yang tepat, teknologi ini dapat membawa manfaat besar bagi masyarakat luas dan memperkuat daya saing bangsa di era digital yang semakin kompetitif.</p>',
    'quantum-computing.jpg'
  );

-- --------------------------------------------------------
--
-- Table structure for table `article_author`
--
CREATE TABLE
  `article_author` (
    `article_id` int (11) NOT NULL,
    `author_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

--
-- Dumping data for table `article_author`
--
INSERT INTO
  `article_author` (`article_id`, `author_id`)
VALUES
  (1, 2),
  (2, 1),
  (3, 1),
  (4, 2),
  (5, 3),
  (6, 3);

-- --------------------------------------------------------
--
-- Table structure for table `article_category`
--
CREATE TABLE
  `article_category` (
    `article_id` int (11) NOT NULL,
    `category_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

--
-- Dumping data for table `article_category`
--
INSERT INTO
  `article_category` (`article_id`, `category_id`)
VALUES
  (1, 4),
  (2, 4),
  (3, 5),
  (4, 5),
  (5, 6),
  (6, 6);

-- --------------------------------------------------------
--
-- Table structure for table `author`
--
CREATE TABLE
  `author` (
    `id` int (11) NOT NULL,
    `nickname` varchar(100) NOT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

--
-- Dumping data for table `author`
--
INSERT INTO
  `author` (`id`, `nickname`, `email`, `password`)
VALUES
  (1, 'User1', 'user1@gmail.com', '12345'),
  (2, 'User2', 'user2@gmail.com', '12345'),
  (3, 'User3', 'user3@gmail.com', '12345');

-- --------------------------------------------------------
--
-- Table structure for table `category`
--
CREATE TABLE
  `category` (
    `id` int (11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `description` text DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_swedish_ci;

--
-- Dumping data for table `category`
--
INSERT INTO
  `category` (`id`, `name`, `description`)
VALUES
  (
    4,
    'Kecerdasan Buatan (AI)',
    'Kategori yang mencakup teknologi dan aplikasi kecerdasan buatan dalam berbagai bidang.'
  ),
  (
    5,
    'Startup & Inovasi',
    'Kategori yang berisi artikel tentang startup dan inovasi di berbagai sektor.'
  ),
  (
    6,
    'Tren Teknologi',
    'Kategori yang mencakup tren terbaru dalam teknologi dan dampaknya terhadap masyarakat.'
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `article`
--
ALTER TABLE `article` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_author`
--
ALTER TABLE `article_author` ADD PRIMARY KEY (`article_id`, `author_id`),
ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `article_category`
--
ALTER TABLE `article_category` ADD PRIMARY KEY (`article_id`, `category_id`),
ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author` ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `article_author`
--
ALTER TABLE `article_author` ADD CONSTRAINT `article_author_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `article_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_category`
--
ALTER TABLE `article_category` ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

COMMIT;

SELECT DATE_FORMAT(date, '%W, %Y-%m-%d %H:%i:%s') AS tanggal_lengkap FROM article;