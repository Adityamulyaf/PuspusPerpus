<?php
/**
 * Dashboard View for PuspusPerpus
 */
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../partials/header.php';
?>

<!-- Welcome Section -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h2 class="page-title">Ringkasan Perpustakaan</h2>
        <p class="page-subtitle">Selamat datang di panel admin PuspusPerpus. Berikut status koleksi perpustakaan saat ini.</p>
    </div>
</div>

<!-- Flash message notifications -->
<?php if (hasFlash('success')): ?>
    <?php $flash = getFlash('success'); ?>
    <div class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo htmlspecialchars($flash['message']); ?></span>
    </div>
<?php endif; ?>

<!-- Stats Cards Grid -->
<div class="stats-grid">
    <!-- Stat 1: Total Books -->
    <div class="stat-card" style="opacity: 0;">
        <div class="stat-header">
            <span class="stat-title">Total Koleksi Buku</span>
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </div>
        <div>
            <div class="stat-value"><?php echo number_format($totalBooks); ?></div>
            <div class="stat-desc">Buku terdaftar dalam sistem</div>
        </div>
    </div>

    <!-- Stat 2: Total Categories -->
    <div class="stat-card" style="opacity: 0;">
        <div class="stat-header">
            <span class="stat-title">Kategori Buku</span>
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.125 1.125 0 001.591 0l7.182-7.182a1.125 1.125 0 000-1.59l-9.582-9.58a1.725 1.725 0 00-1.22-.5L9.568 3z" />
                </svg>
            </div>
        </div>
        <div>
            <div class="stat-value"><?php echo number_format($totalCategories); ?></div>
            <div class="stat-desc">Kategori genre/disiplin ilmu</div>
        </div>
    </div>

    <!-- Stat 3: Total Available Books -->
    <div class="stat-card" style="opacity: 0;">
        <div class="stat-header">
            <span class="stat-title">Buku Tersedia</span>
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div>
            <div class="stat-value" style="color: var(--success);"><?php echo number_format($totalAvailable); ?></div>
            <div class="stat-desc">Koleksi berstatus 'Tersedia'</div>
        </div>
    </div>
</div>

<!-- Extra Quick Actions Panel -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="stat-card" style="opacity: 0; min-height: 200px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-size: 16px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">Kelola Data Koleksi</h3>
                <p style="font-size: 13px; color: var(--muted-foreground); line-height: 1.6;">Akses daftar lengkap data buku perpustakaan untuk menambah, mengedit, memperbarui status, atau menghapus item lama.</p>
            </div>
            <div style="margin-top: 16px;">
                <a href="index.php?route=books" class="btn btn-primary btn-sm">
                    <span>Lihat Data Buku</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="stat-card" style="opacity: 0; min-height: 200px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-size: 16px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">Kategorisasi Koleksi</h3>
                <p style="font-size: 13px; color: var(--muted-foreground); line-height: 1.6;">Atur klasifikasi buku perpustakaan dengan membuat klasifikasi kategori baru atau mengedit pengelompokan yang sudah ada.</p>
            </div>
            <div style="margin-top: 16px;">
                <a href="index.php?route=categories" class="btn btn-outline btn-sm">
                    <span>Kelola Kategori</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
