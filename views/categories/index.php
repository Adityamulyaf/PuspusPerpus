<?php
/**
 * Categories Index View for PuspusPerpus
 */
$pageTitle = 'Kategori Buku';
require_once __DIR__ . '/../../partials/header.php';
?>

<!-- Header -->
<div class="page-header">
    <div>
        <h2 class="page-title">Klasifikasi Kategori Buku</h2>
        <p class="page-subtitle">Kelola kategori pengelompokan buku untuk mempermudah pencarian.</p>
    </div>
</div>

<!-- Flash Notifications for category CRUD -->
<?php if (hasFlash('category_flash')): ?>
    <?php $flash = getFlash('category_flash'); ?>
    <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
        <?php if ($flash['type'] === 'success'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        <?php endif; ?>
        <span><?php echo htmlspecialchars($flash['message']); ?></span>
    </div>
<?php endif; ?>

<!-- 2-Column Split Layout for Table and Add Panel -->
<div class="grid-split-2">
    <!-- Left Column: Categories List -->
    <div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>Nama Kategori</th>
                        <th style="width: 180px;">Dibuat Pada</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--muted-foreground); padding: 40px;">
                                Belum ada kategori yang ditambahkan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr style="opacity: 0;">
                                <td style="font-weight: 600; color: var(--muted-foreground);">
                                    #<?php echo htmlspecialchars($cat['id']); ?>
                                </td>
                                <td style="font-weight: 600; color: var(--primary);">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </td>
                                <td style="color: var(--muted-foreground); font-size: 13px;">
                                    <?php echo date('d M Y H:i', strtotime($cat['created_at'])); ?>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <!-- Edit button -->
                                        <a href="index.php?route=categories/edit&id=<?php echo $cat['id']; ?>" class="btn btn-outline btn-icon btn-sm" title="Edit Kategori">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.013a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>
                                        <!-- Delete button triggers modal -->
                                        <button 
                                            type="button" 
                                            class="btn btn-outline btn-icon btn-sm" 
                                            style="color: var(--danger); border-color: rgba(239, 68, 68, 0.2);"
                                            title="Hapus Kategori"
                                            onclick="triggerDeleteCategory(<?php echo $cat['id']; ?>, '<?php echo addslashes(htmlspecialchars($cat['name'])); ?>')"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Right Column: Add Category Form Panel -->
    <div>
        <div class="stat-card" style="opacity: 1; padding: 24px; position: sticky; top: 94px;">
            <h3 style="font-size: 16px; font-weight: 600; color: var(--primary); margin-bottom: 4px;">Tambah Kategori</h3>
            <p style="font-size: 12px; color: var(--muted-foreground); margin-bottom: 20px;">Masukkan nama kategori klasifikasi buku baru.</p>
            
            <!-- Category validation error logs -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="padding: 10px 14px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 16px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="index.php?route=categories/create" method="POST" id="category-form" novalidate>
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
                        value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                    >
                </div>
                
                <button type="submit" class="btn btn-primary w-100" style="margin-top: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Simpan Kategori</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Category Delete Modal Component -->
<div id="delete-cat-modal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus Kategori</h3>
            <button type="button" class="btn-outline btn-icon" style="border: none; padding: 4px;" onclick="closeConfirmModal('delete-cat-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p class="modal-message">Apakah Anda yakin ingin menghapus kategori ini?</p>
            <div style="background-color: var(--danger-light); border: 1px solid var(--danger-border); color: var(--danger); border-radius: var(--radius); padding: 12px; margin-top: 16px; font-size: 13px; display: flex; gap: 8px; align-items: flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span><strong>PERINGATAN:</strong> Menghapus kategori ini akan secara otomatis menghapus <strong>seluruh data buku</strong> yang terkait dengan kategori ini!</span>
            </div>
        </div>
        <div class="modal-footer">
            <form action="index.php?route=categories/delete" method="POST">
                <?php echo csrfField(); ?>
                <input type="hidden" name="id" id="delete-cat-id" value="">
                
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeConfirmModal('delete-cat-modal')">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus Semua</button>
            </form>
        </div>
    </div>
</div>

<script>
    /**
     * Set target category ID in delete form and show confirmation modal
     */
    function triggerDeleteCategory(id, name) {
        document.getElementById('delete-cat-id').value = id;
        const message = `Apakah Anda yakin ingin menghapus kategori "${name}"?`;
        openConfirmModal('delete-cat-modal', null, message);
    }
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
