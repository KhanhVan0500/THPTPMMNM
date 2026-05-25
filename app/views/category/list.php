<?php include 'app/views/shares/header.php'; ?>

<h2 class="font-weight-bold mb-4">📂 Danh sách danh mục</h2>

<?php if (empty($categories)): ?>
    <div class="alert alert-info">Chưa có danh mục nào.</div>
<?php else: ?>
    <ul class="list-group">
        <?php foreach ($categories as $category): ?>
            <li class="list-group-item">
                <h5 class="mb-1"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                <p class="mb-0 text-muted small"><?php echo htmlspecialchars($category->description ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
