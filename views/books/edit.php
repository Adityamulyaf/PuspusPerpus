<?php
/**
 * Edit Book View for PuspusPerpus
 */
$pageTitle = 'Edit Buku';
require_once __DIR__ . '/../../partials/header.php';
?>

<!-- Header & Back navigation -->
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h2 class="page-title">Edit Buku</h2>
        <p class="page-subtitle">Perbarui data detail untuk buku: <strong><?php echo htmlspecialchars($book['title']); ?></strong>.</p>
    </div>
    <div>
        <a href="index.php?route=books" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="stat-card" style="opacity: 1; padding: 32px;">
            
            <!-- Global warnings -->
            <?php if (isset($errors['auth'])): ?>
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span><?php echo htmlspecialchars($errors['auth']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($errors['db'])): ?>
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span><?php echo htmlspecialchars($errors['db']); ?></span>
                </div>
            <?php endif; ?>

            <form action="index.php?route=books/edit&id=<?php echo $book['id']; ?>" method="POST" id="book-form" novalidate>
                <!-- CSRF Token protection -->
                <?php echo csrfField(); ?>

                <!-- Judul Buku -->
                <div class="form-group">
                    <label for="title" class="form-label">Judul Buku</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="form-control <?php echo isset($errors['title']) ? 'is-invalid' : ''; ?>" 
                        placeholder="Contoh: Pemrograman Berorientasi Objek"
                        value="<?php echo htmlspecialchars($old['title'] ?? ''); ?>"
                    >
                    <?php if (isset($errors['title'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['title']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <!-- Penulis -->
                    <div class="col-md-6 form-group">
                        <label for="author" class="form-label">Penulis / Pengarang</label>
                        <input 
                            type="text" 
                            name="author" 
                            id="author" 
                            class="form-control <?php echo isset($errors['author']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Contoh: Prof. Budi Raharjo"
                            value="<?php echo htmlspecialchars($old['author'] ?? ''); ?>"
                        >
                        <?php if (isset($errors['author'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['author']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Penerbit -->
                    <div class="col-md-6 form-group">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input 
                            type="text" 
                            name="publisher" 
                            id="publisher" 
                            class="form-control <?php echo isset($errors['publisher']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Contoh: Penerbit Andi"
                            value="<?php echo htmlspecialchars($old['publisher'] ?? ''); ?>"
                        >
                        <?php if (isset($errors['publisher'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['publisher']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <!-- Tahun Terbit -->
                    <div class="col-md-6 form-group">
                        <label for="publication_year" class="form-label">Tahun Terbit</label>
                        <input 
                            type="number" 
                            name="publication_year" 
                            id="publication_year" 
                            class="form-control <?php echo isset($errors['publication_year']) ? 'is-invalid' : ''; ?>" 
                            placeholder="Contoh: 2024"
                            min="1900"
                            max="<?php echo date('Y'); ?>"
                            value="<?php echo htmlspecialchars($old['publication_year'] ?? ''); ?>"
                        >
                        <?php if (isset($errors['publication_year'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['publication_year']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Kategori Dropdown -->
                    <div class="col-md-6 form-group">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select 
                            name="category_id" 
                            id="category_id" 
                            class="form-control <?php echo isset($errors['category_id']) ? 'is-invalid' : ''; ?>"
                        >
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $category): ?>
                                <option 
                                    value="<?php echo $category['id']; ?>"
                                    <?php echo (isset($old['category_id']) && $old['category_id'] == $category['id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['category_id']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Status Buku -->
                <div class="form-group">
                    <label class="form-label">Status Ketersediaan</label>
                    <div style="display: flex; gap: 24px; margin-top: 8px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer;">
                            <input 
                                type="radio" 
                                name="status" 
                                value="Tersedia" 
                                style="accent-color: var(--primary);"
                                <?php echo ($old['status'] === 'Tersedia') ? 'checked' : ''; ?>
                            >
                            <span>Tersedia</span>
                        </label>
                        
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer;">
                            <input 
                                type="radio" 
                                name="status" 
                                value="Dipinjam" 
                                style="accent-color: var(--primary);"
                                <?php echo ($old['status'] === 'Dipinjam') ? 'checked' : ''; ?>
                            >
                            <span>Dipinjam</span>
                        </label>
                    </div>
                    <?php if (isset($errors['status'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['status']; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Actions buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; border-top: 1px solid var(--border); padding-top: 24px;">
                    <a href="index.php?route=books" class="btn btn-secondary">Batal</a>
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
