<?php
/**
 * Books Index (List) View for PuspusPerpus
 */
$pageTitle = 'Daftar Buku';
require_once __DIR__ . '/../../partials/header.php';

// Calculate pagination items count info
$startItem = $totalBooks > 0 ? $offset + 1 : 0;
$endItem = min($offset + $limit, $totalBooks);
?>

<!-- Page Header Area -->
<div class="page-header">
    <div>
        <h2 class="page-title">Daftar Koleksi Buku</h2>
        <p class="page-subtitle">Koleksi terdaftar saat ini: <?php echo number_format($totalBooks); ?> buku.</p>
    </div>
    <div>
        <a href="index.php?route=books/create" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Tambah Buku Baru</span>
        </a>
    </div>
</div>

<!-- Flash Notifications -->
<?php if (hasFlash('book_flash')): ?>
    <?php $flash = getFlash('book_flash'); ?>
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

<!-- Search Filter Bar -->
<div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
    <form action="index.php" method="GET" class="search-wrapper">
        <input type="hidden" name="route" value="books">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input 
            type="text" 
            name="search" 
            class="form-control search-input" 
            placeholder="Cari judul, penulis, penerbit..." 
            value="<?php echo htmlspecialchars($search); ?>"
        >
    </form>
    
    <?php if ($search !== ''): ?>
        <div>
            <a href="index.php?route=books" class="btn btn-secondary btn-sm">
                <span>Reset Pencarian</span>
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Books List Table -->
<div class="table-responsive">
    <table class="table-custom">
        <thead>
            <tr>
                <th style="width: 80px;">ID Buku</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th style="width: 110px;">Tahun Terbit</th>
                <th>Kategori</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 120px; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($books)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--muted-foreground); padding: 40px;">
                        Tidak ada data buku yang ditemukan.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <tr style="opacity: 0;">
                        <td style="font-weight: 600; color: var(--muted-foreground);">
                            #<?php echo htmlspecialchars($book['id']); ?>
                        </td>
                        <td style="font-weight: 600; color: var(--primary);">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['publisher']); ?></td>
                        <td><?php echo htmlspecialchars($book['publication_year']); ?></td>
                        <td>
                            <span class="badge" style="background-color: var(--primary-light); color: var(--primary); border: 1px solid var(--border);">
                                <?php echo htmlspecialchars($book['category_name'] ?? 'Tanpa Kategori'); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($book['status'] === 'Tersedia'): ?>
                                <span class="badge badge-success">Tersedia</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Dipinjam</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <!-- Edit button -->
                                <a href="index.php?route=books/edit&id=<?php echo $book['id']; ?>" class="btn btn-outline btn-icon btn-sm" title="Edit Buku">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.013a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <!-- Delete button triggers modal -->
                                <button 
                                    type="button" 
                                    class="btn btn-outline btn-icon btn-sm" 
                                    style="color: var(--danger); border-color: rgba(239, 68, 68, 0.2);"
                                    title="Hapus Buku"
                                    onclick="triggerDeleteBook(<?php echo $book['id']; ?>, '<?php echo addslashes(htmlspecialchars($book['title'])); ?>')"
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

<!-- Pagination Controls -->
<?php if ($totalPages > 1): ?>
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan <?php echo $startItem; ?> - <?php echo $endItem; ?> dari <?php echo number_format($totalBooks); ?> data.
        </div>
        <nav>
            <ul class="pagination-nav">
                <!-- Previous Button -->
                <li class="pagination-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a href="index.php?route=books&page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 14px; height: 14px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                </li>
                
                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="pagination-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a href="index.php?route=books&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="pagination-link">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <!-- Next Button -->
                <li class="pagination-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a href="index.php?route=books&page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 14px; height: 14px;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>

<!-- Delete Confirmation Modal Component -->
<div id="delete-modal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus Buku</h3>
            <button type="button" class="btn-outline btn-icon" style="border: none; padding: 4px;" onclick="closeConfirmModal('delete-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 18px; height: 18px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p class="modal-message">Apakah Anda yakin ingin menghapus data buku ini secara permanen?</p>
            <p style="color: var(--danger); font-size: 12px; margin-top: 8px;">*Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <form action="index.php?route=books/delete" method="POST">
                <?php echo csrfField(); ?>
                <input type="hidden" name="id" id="delete-book-id" value="">
                
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeConfirmModal('delete-modal')">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    /**
     * Set target book ID in delete form and open the modal overlay
     */
    function triggerDeleteBook(id, title) {
        document.getElementById('delete-book-id').value = id;
        const message = `Apakah Anda yakin ingin menghapus buku "${title}" dari database perpustakaan?`;
        openConfirmModal('delete-modal', null, message);
    }
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
