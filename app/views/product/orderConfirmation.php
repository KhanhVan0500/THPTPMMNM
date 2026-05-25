<?php include 'app/views/shares/header.php'; ?>

<?php
$method = $_SESSION['payment_method'] ?? 'cod';
$notes  = [
    'cod'   => '🚚 Đơn hàng COD — Thanh toán tiền mặt khi nhận hàng.',
    'momo'  => '💜 Đã thanh toán qua MoMo thành công.',
    'bank'  => '🏦 Chuyển khoản ngân hàng đã được ghi nhận.',
    'vnpay' => '💙 Đã thanh toán qua VNPay thành công.',
];
unset($_SESSION['order_total'], $_SESSION['order_name'], $_SESSION['payment_method']);
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow text-center">
            <div class="card-body py-5">
                <div style="font-size:5rem">✅</div>
                <h2 class="text-success font-weight-bold mt-3">Đặt hàng thành công!</h2>
                <p class="lead text-muted mt-2"><?php echo $notes[$method] ?? ''; ?></p>
                <hr>
                <p class="text-muted">Chúng tôi sẽ liên hệ xác nhận và giao hàng sớm nhất.</p>
                <a href="/Product" class="btn btn-primary btn-lg mt-3">🛍️ Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
