<?php include 'app/views/shares/header.php'; ?>

<h2 class="font-weight-bold mb-4">🛒 Giỏ hàng của bạn</h2>

<?php if (!empty($cart)): ?>
    <?php
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Thành tiền</th>
                        <th class="text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                         alt="" style="width:60px; height:60px; object-fit:cover;" class="rounded">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="width:60px;height:60px;">🖼️</div>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle font-weight-bold">
                                <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td class="text-center align-middle text-muted">
                                <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge badge-secondary px-3 py-2" style="font-size:1rem;">
                                    <?php echo $item['quantity']; ?>
                                </span>
                            </td>
                            <td class="text-center align-middle font-weight-bold text-danger">
                                <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VND
                            </td>
                            <td class="text-center align-middle">
                                <a href="/Product/removeFromCart/<?php echo $id; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <td colspan="4" class="text-right font-weight-bold h5">Tổng cộng:</td>
                        <td class="text-center font-weight-bold h5 text-danger">
                            <?php echo number_format($total, 0, ',', '.'); ?> VND
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="/Product" class="btn btn-outline-secondary btn-lg">
            ← Tiếp tục mua sắm
        </a>
        <a href="/Product/checkout" class="btn btn-success btn-lg">
            💳 Tiến hành thanh toán
        </a>
    </div>

<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <span style="font-size:4rem;">🛒</span>
            <h4 class="mt-3 text-muted">Giỏ hàng của bạn đang trống.</h4>
            <a href="/Product" class="btn btn-primary mt-3">🛍️ Mua sắm ngay</a>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
