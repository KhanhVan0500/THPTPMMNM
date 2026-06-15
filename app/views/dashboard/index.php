<?php include BASE_PATH . '/app/views/shares/header.php'; ?>

<?php
$totalProducts = (int) ($productStats['total_products'] ?? 0);
$totalOrders = (int) ($orderStats['total_orders'] ?? 0);
$totalRevenue = (float) ($orderStats['total_revenue'] ?? 0);
$todayOrders = (int) ($orderStats['today_orders'] ?? 0);
$maxCategoryCount = 1;
foreach ($categories as $cat) {
    $maxCategoryCount = max($maxCategoryCount, (int) ($cat['product_count'] ?? 0));
}
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span class="hero-chip mb-3"><i class="fas fa-satellite"></i> Command Center Online</span>
            <h2 class="font-display"><span class="nav-live-dot"></span>Trung tâm điều khiển NovaTech</h2>
            <p>Dashboard tổng quan vận hành shop công nghệ: sản phẩm, đơn hàng, doanh thu, wishlist, so sánh và giỏ hàng.</p>
            <div class="hero-chips">
                <span class="hero-chip"><i class="fas fa-bolt"></i> UI Future Tech</span>
                <span class="hero-chip"><i class="fas fa-shield-alt"></i> Quản lý đơn</span>
                <span class="hero-chip"><i class="fas fa-ticket-alt"></i> Voucher thông minh</span>
            </div>
        </div>
        <div class="mt-3 mt-lg-0 d-flex flex-wrap" style="gap:8px;">
            <?php if (isAdminLoggedIn()): ?><a href="index.php?url=product/create" class="btn btn-outline-light"><i class="fas fa-plus mr-1"></i>Thêm sản phẩm</a><?php endif; ?>
            <a href="index.php?url=product" class="btn btn-primary"><i class="fas fa-store mr-1"></i>Vào cửa hàng</a>
        </div>
    </div>
</div>

<div class="premium-banner">
    <div class="premium-banner-card animate-in">
        <span class="mini-chip"><i class="fas fa-rocket"></i> NovaTech Future Launch</span>
        <h3 class="banner-title font-display mt-3">Không gian bán hàng công nghệ chuẩn tương lai</h3>
        <p style="color:var(--text-secondary);max-width:720px;line-height:1.8;">Header mới, logo SVG, banner cao cấp, tìm kiếm nhanh, giỏ hàng, wishlist, so sánh, voucher, checkout thông minh và quản lý trạng thái đơn hàng.</p>
        <div class="d-flex flex-wrap mt-3" style="gap:8px;">
            <a href="index.php?url=product" class="btn btn-primary"><i class="fas fa-store mr-1"></i>Khám phá sản phẩm</a>
            <a href="index.php?url=cart" class="btn btn-secondary"><i class="fas fa-shopping-bag mr-1"></i>Mở giỏ hàng</a>
        </div>
    </div>
    <div class="premium-banner-card animate-in" style="animation-delay:.08s;">
        <span class="mini-chip"><i class="fas fa-ticket-alt"></i> Voucher đang bật</span>
        <div class="mt-3 d-flex flex-wrap" style="gap:8px;">
            <span class="hero-chip copy-text" data-copy="FUTURE10">FUTURE10</span>
            <span class="hero-chip copy-text" data-copy="VIP15">VIP15</span>
            <span class="hero-chip copy-text" data-copy="TECH500">TECH500</span>
        </div>
        <p class="mt-3 mb-0" style="color:var(--text-secondary);">Bấm vào mã để sao chép nhanh, áp dụng trực tiếp trong giỏ hàng.</p>
    </div>
</div>

<div class="stats-grid mb-4">
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-cube"></i></div>
        <div class="stat-content"><h6>Sản phẩm</h6><div class="stat-value"><?= number_format($totalProducts) ?></div></div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon" style="background:var(--gradient-accent);"><i class="fas fa-receipt"></i></div>
        <div class="stat-content"><h6>Tổng đơn</h6><div class="stat-value"><?= number_format($totalOrders) ?></div></div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon" style="background:var(--gradient-warm);"><i class="fas fa-chart-line"></i></div>
        <div class="stat-content"><h6>Doanh thu</h6><div class="stat-value"><?= moneyVnd($totalRevenue) ?></div></div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon" style="background:var(--gradient-rose);"><i class="fas fa-calendar-day"></i></div>
        <div class="stat-content"><h6>Đơn hôm nay</h6><div class="stat-value"><?= number_format($todayOrders) ?></div></div>
    </div>
</div>


<?php if (!empty($lowStockProducts)): ?>
<div class="card animate-in mb-4" style="border-left:3px solid var(--warning);"><div class="card-header" style="color:var(--warning);"><i class="fas fa-exclamation-triangle mr-2"></i>Cảnh báo tồn kho thấp (<?= count($lowStockProducts) ?> sản phẩm)</div><div class="card-body p-0"><table class="table mb-0"><thead><tr><th>Sản phẩm</th><th>Danh mục</th><th class="text-center">Tồn kho</th><th></th></tr></thead><tbody><?php foreach ($lowStockProducts as $lp): ?><tr><td><strong><?= e($lp['name']) ?></strong></td><td style="color:var(--muted);"><?= e($lp['category_name'] ?? '—') ?></td><td class="text-center"><span class="badge-status <?= (int)$lp['stock'] <= 0 ? 'status-cancelled' : 'status-shipping' ?>"><?= (int)$lp['stock'] <= 0 ? 'Hết hàng' : (int)$lp['stock'].' cái' ?></span></td><td class="text-right"><?php if (isAdminLoggedIn()): ?><a href="index.php?url=product/edit/<?= (int)$lp['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen mr-1"></i>Nhập hàng</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php endif; ?>


<div class="card animate-in mb-4"><div class="card-header d-flex justify-content-between align-items-center"><span><i class="fas fa-chart-area mr-2" style="color:var(--accent);"></i>Doanh thu 7 ngày qua</span><span class="mini-chip" id="chartTotal"></span></div><div class="card-body"><canvas id="revenueChart" style="height:220px;max-height:220px;"></canvas></div></div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card animate-in h-100">
            <div class="card-header"><i class="fas fa-layer-group mr-2" style="color:var(--accent);"></i>Phân bổ danh mục</div>
            <div class="card-body">
                <?php if (empty($categories)): ?>
                    <div class="empty-state py-4"><i class="fas fa-folder-open"></i><h4>Chưa có danh mục</h4></div>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <?php $count = (int) ($cat['product_count'] ?? 0); $percent = max(6, round($count / $maxCategoryCount * 100)); ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <a href="index.php?url=product&category_id=<?= (int)$cat['id'] ?>" style="color:var(--ink);font-weight:900;"><?= e($cat['name']) ?></a>
                                <span class="mini-chip"><i class="fas fa-box"></i><?= $count ?> SP</span>
                            </div>
                            <div class="progress-line"><span style="width:<?= $percent ?>%"></span></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card animate-in h-100">
            <div class="card-header"><i class="fas fa-fire mr-2" style="color:var(--warning);"></i>Sản phẩm mới nhất</div>
            <div class="card-body">
                <?php foreach ($latestProducts as $product): ?>
                    <?php $imgSrc = getImageSrc($product['image'], $product['name'], $product['category_id'] ?? null); ?>
                    <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom:1px solid var(--border-light);">
                        <img src="<?= e($imgSrc) ?>" class="table-img mr-3" alt="<?= e($product['name']) ?>">
                        <div class="flex-fill" style="min-width:0;">
                            <a href="index.php?url=product/show/<?= (int) $product['id'] ?>" class="font-weight-bold" style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= e($product['name']) ?></a>
                            <span class="price" style="font-size:.92rem;"><?= moneyVnd($product['price']) ?></span>
                        </div>
                        <a href="index.php?url=cart/add/<?= (int) $product['id'] ?>" class="btn btn-cart btn-sm"><i class="fas fa-plus"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card animate-in">
            <div class="card-header"><i class="fas fa-clock mr-2" style="color:var(--cyan);"></i>Đơn hàng gần đây</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Mã</th><th>Khách</th><th>Trạng thái</th><th class="text-right">Tổng</th><th></th></tr></thead>
                        <tbody>
                        <?php if (empty($recentOrders)): ?>
                            <tr><td colspan="5" class="text-center py-4" style="color:var(--muted);">Chưa có đơn hàng.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <?php $status = $order['order_status'] ?? ($order['status'] ?? 'new'); ?>
                                <tr>
                                    <td><button class="btn btn-sm btn-secondary copy-text" data-copy="#<?= (int) $order['id'] ?>">#<?= (int) $order['id'] ?></button></td>
                                    <td><strong><?= e($order['name']) ?></strong><br><small style="color:var(--muted);"><?= e($order['phone']) ?></small></td>
                                    <td><span class="badge-status status-<?= e($status) ?>"><?= e($status) ?></span></td>
                                    <td class="text-right"><strong><?= moneyVnd($order['total_amount'] ?? 0) ?></strong></td>
                                    <td class="text-right"><a href="index.php?url=order/show/<?= (int) $order['id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card animate-in h-100">
            <div class="card-header"><i class="fas fa-terminal mr-2" style="color:var(--accent);"></i>Phím tắt vận hành</div>
            <div class="card-body">
                <a class="btn btn-primary btn-block mb-2" href="index.php?url=product"><i class="fas fa-search mr-1"></i>Tìm kiếm / lọc sản phẩm</a>
                <a class="btn btn-secondary btn-block mb-2" href="index.php?url=wishlist"><i class="fas fa-heart mr-1"></i>Mở wishlist</a>
                <a class="btn btn-secondary btn-block mb-2" href="index.php?url=compare"><i class="fas fa-balance-scale mr-1"></i>Mở so sánh</a>
                <a class="btn btn-secondary btn-block" href="index.php?url=order"><i class="fas fa-receipt mr-1"></i>Quản lý đơn hàng</a>
                <hr style="border-color:var(--line);">
                <p class="mb-2" style="color:var(--text-secondary);font-size:.9rem;">Mã voucher demo:</p>
                <div class="d-flex flex-wrap" style="gap:8px;">
                    <span class="mini-chip copy-text" data-copy="FUTURE10">FUTURE10</span>
                    <span class="mini-chip copy-text" data-copy="VIP15">VIP15</span>
                    <span class="mini-chip copy-text" data-copy="TECH500">TECH500</span>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>(function(){var labels=<?= $chartLabels ?? '[]' ?>;var data=<?= $chartData ?? '[]' ?>;var el=document.getElementById('revenueChart');if(!el||!window.Chart)return;var isDark=document.documentElement.getAttribute('data-theme')!=='light';var gridColor=isDark?'rgba(255,255,255,.07)':'rgba(0,0,0,.07)';var textColor=isDark?'#8ea4c6':'#6c7f9f';var ctx=el.getContext('2d');var grad=ctx.createLinearGradient(0,0,0,220);grad.addColorStop(0,'rgba(0,245,200,.28)');grad.addColorStop(1,'rgba(0,245,200,0)');new Chart(ctx,{type:'line',data:{labels:labels,datasets:[{label:'Doanh thu',data:data,borderColor:'#00f5c8',backgroundColor:grad,borderWidth:2,tension:.42,fill:true,pointBackgroundColor:'#00f5c8',pointRadius:4,pointHoverRadius:6}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:function(c){return ' '+new Intl.NumberFormat('vi-VN').format(c.parsed.y)+' đ';}}}},scales:{x:{grid:{color:gridColor},ticks:{color:textColor}},y:{grid:{color:gridColor},ticks:{color:textColor,callback:function(v){return (v/1e6).toFixed(1)+'M';}}}}}});var total=data.reduce(function(a,b){return a+b;},0);document.getElementById('chartTotal').textContent=new Intl.NumberFormat('vi-VN').format(total)+' đ';})();</script>
<?php include BASE_PATH . '/app/views/shares/footer.php'; ?>
