<?php
$seoTitle = 'Đơn hàng — KZANN Admin';
$seoDescription = 'Khu vực quản lý đơn hàng KZANN.';
?>
<?php include BASE_PATH . '/app/views/shares/header.php'; ?>

<div class="page-header">
    <?= breadcrumb([['label'=>'Đơn hàng']]) ?>
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-3 mb-md-0">
            <h2><?= isAdmin() ? 'Quản lý đơn hàng' : 'Đơn hàng của tôi' ?></h2>
            <p class="mb-0 text-muted"><?= isAdmin() ? 'Theo dõi trạng thái, doanh thu và tra cứu đơn hàng.' : 'Theo dõi các đơn hàng bạn đã đặt.' ?></p>
        </div>
        <a href="index.php?url=product" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
</div>

<div class="stats-grid mb-4">
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5"><i class="fas fa-receipt" style="color:#d70018"></i></div><div class="stat-content"><h6>Tổng đơn</h6><div class="stat-value"><?= number_format((int) ($orderStats['total_orders'] ?? 0)) ?></div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5"><i class="fas fa-calendar-alt" style="color:#d70018"></i></div><div class="stat-content"><h6>Hôm nay</h6><div class="stat-value"><?= number_format((int) ($orderStats['today_orders'] ?? 0)) ?></div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5"><i class="fas fa-box" style="color:#d70018"></i></div><div class="stat-content"><h6>Đã bán</h6><div class="stat-value"><?= number_format((int) ($orderStats['total_items_sold'] ?? 0)) ?></div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:#fff5f5"><i class="fas fa-coins" style="color:#d70018"></i></div><div class="stat-content"><h6>Doanh thu</h6><div class="stat-value"><?= moneyVnd($orderStats['total_revenue'] ?? 0) ?></div></div></div>
</div>

<form method="GET" action="index.php" class="mb-4">
    <input type="hidden" name="url" value="order">
    <div class="input-group">
        <input type="text" name="q" value="<?= e($keyword ?? '') ?>" class="form-control form-control-lg border-0 shadow-sm" placeholder="Tìm theo mã đơn, khách hàng...">
        <div class="input-group-append"><button class="btn btn-primary px-4" type="submit">Tìm kiếm</button></div>
    </div>
</form>

<div class="card">
    <div class="card-header">Danh sách đơn hàng</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Mã</th><th>Khách hàng</th><th>Liên hệ</th><th>Trạng thái</th><th class="text-center">SP</th><th>Thanh toán</th><th class="text-right">Tổng</th><th>Ngày tạo</th><th></th></tr></thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="9"><div class="empty-state py-5"><i class="fas fa-inbox"></i><h4>Chưa có đơn hàng</h4><p>Đơn hàng mới sẽ xuất hiện tại đây.</p></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <?php $status = $order['order_status'] ?? ($order['status'] ?? 'new'); ?>
                            <tr>
                                <td><button class="btn btn-sm btn-secondary copy-text" data-copy="#<?= (int) $order['id'] ?>">#<?= (int) $order['id'] ?></button></td>
                                <td><strong><?= e($order['name']) ?></strong><br><small style="color:var(--muted);">ID <?= (int) $order['id'] ?></small></td>
                                <td><?= e($order['phone']) ?><?php if (!empty($order['email'])): ?><br><small style="color:var(--muted);"><?= e($order['email']) ?></small><?php endif; ?></td>
                                <td><span class="badge-status status-<?= e($status) ?>"><?= e($status) ?></span></td>
                                <td class="text-center"><?= (int) ($order['total_items'] ?? 0) ?></td>
                                <td><?= e($order['payment_label'] ?? ($order['payment_method'] ?? 'COD')) ?></td>
                                <td class="text-right"><strong><?= moneyVnd($order['total_amount'] ?? 0) ?></strong></td>
                                <td><?= !empty($order['created_at']) ? date('d/m/Y H:i', strtotime($order['created_at'])) : '' ?></td>
                                <td class="text-right"><a href="index.php?url=order/show/<?= (int) $order['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-1"></i>Xem</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php if (($totalPages ?? 1) > 1): ?>
<nav class="mt-3"><ul class="pagination justify-content-center modern-pagination"><li class="page-item <?= $page<=1?'disabled':'' ?>"><a class="page-link" href="index.php?url=order&q=<?= urlencode($keyword) ?>&page=<?= $page-1 ?>">«</a></li><?php for($i=1;$i<=$totalPages;$i++): ?><li class="page-item <?= $i==$page?'active':'' ?>"><a class="page-link" href="index.php?url=order&q=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a></li><?php endfor; ?><li class="page-item <?= $page>=$totalPages?'disabled':'' ?>"><a class="page-link" href="index.php?url=order&q=<?= urlencode($keyword) ?>&page=<?= $page+1 ?>">»</a></li></ul></nav>
<?php endif; ?>

<?php include BASE_PATH . '/app/views/shares/footer.php'; ?>
