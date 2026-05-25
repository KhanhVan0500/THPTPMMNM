<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Đơn hàng đã mua</h3>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <div class="alert alert-info">Hiện chưa có đơn hàng nào.</div>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="border rounded-lg p-4 mb-4" style="background:#f8fafc;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:12px;">
                                <div>
                                    <h5 class="mb-1">Đơn hàng #<?php echo htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="mb-1"><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="mb-1"><strong>Điện thoại:</strong> <?php echo htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="mb-0"><strong>Địa chỉ:</strong> <?php echo nl2br(htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8')); ?></p>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-pill badge-info" style="font-size:0.95rem; padding:0.75rem 1rem; background:#7c3aed; color:#fff;"><?php echo htmlspecialchars($order->status, ENT_QUOTES, 'UTF-8'); ?></span>
                                    <p class="mb-0 text-muted" style="margin-top:0.5rem;"><?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                                </div>
                            </div>

                            <?php $details = $detailsByOrder[$order->id] ?? []; ?>
                            <?php if (!empty($details)): ?>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-right">Giá</th>
                                                <th class="text-right">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $orderTotal = 0; ?>
                                            <?php foreach ($details as $item): ?>
                                                <?php $lineTotal = $item['quantity'] * $item['price']; ?>
                                                <?php $orderTotal += $lineTotal; ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="text-right"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                                    <td class="text-right"><?php echo number_format($lineTotal, 0, ',', '.'); ?>đ</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-right">Tổng đơn hàng:</th>
                                                <th class="text-right"><?php echo number_format($orderTotal, 0, ',', '.'); ?>đ</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>