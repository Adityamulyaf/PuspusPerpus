<?php
/**
 * Edit Category View for PuspusPerpus
 */
$pageTitle = 'Edit Kategori';
require_once __DIR__ . '/../../partials/header.php';
?>

<!-- Header & Back navigation -->
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h2 class="page-title">Edit Kategori</h2>
        <p class="page-subtitle">Ubah nama kategori untuk klasifikasi buku perpustakaan.</p>
    </div>
    <div>
        <a href="index.php?route=categories" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Kategori</span>
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="stat-card" style="opacity: 1; padding: 32px;">
            <h3 style="font-size: 16px; font-weight: 600; color: var(--primary); margin-bottom: 4px;">Ubah Nama Kategori</h3>
            <p style="font-size: 12px; color: var(--muted-foreground); margin-bottom: 24px;">Edit pengelompokan klasifikasi buku.</p>

            <!-- Inline validation error notices -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="padding: 10px 14px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 16px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="index.php?route=categories/edit&id=<?php echo $category['id']; ?>" method="POST" id="category-form" novalidate>
                <!-- CSRF Token -->
                <?php echo csrfField(); ?>

                <div class="form-group">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Contoh: Novel Remaja"
                        value="<?php echo htmlspecialchars($category['name']); ?>"
                    >
                </div>

                <!-- Actions buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; border-top: 1px solid var(--border); padding-top: 24px;">
                    <a href="index.php?route=categories" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
