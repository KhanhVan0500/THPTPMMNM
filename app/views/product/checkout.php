<?php include 'app/views/shares/header.php'; ?>

<div class="row">
    <!-- Form thanh toán -->
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">💳 Thông tin đặt hàng</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/Product/processCheckout"
                      onsubmit="return validateCheckout()">

                    <div class="form-group">
                        <label><strong>Họ và tên:</strong></label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên người nhận" required>
                    </div>
                    <div class="form-group">
                        <label><strong>Số điện thoại:</strong></label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label><strong>Địa chỉ giao hàng:</strong></label>
                        <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ đầy đủ" required></textarea>
                    </div>

                    <!-- PHƯƠNG THỨC THANH TOÁN -->
                    <div class="form-group">
                        <label><strong>Phương thức thanh toán:</strong></label>

                        <div class="pm-option active-pm" onclick="selectPM(this,'cod')" style="cursor:pointer;border:2px solid #28a745;border-radius:10px;padding:12px 16px;margin-bottom:8px;display:flex;align-items:center;gap:14px;background:#f8fff9">
                            <span style="font-size:24px">🚚</span>
                            <div>
                                <div class="font-weight-bold">Thanh toán khi nhận hàng (COD)</div>
                                <small class="text-muted">Trả tiền mặt cho shipper khi nhận hàng</small>
                            </div>
                        </div>

                        <div class="pm-option" onclick="selectPM(this,'momo')" style="cursor:pointer;border:2px solid #dee2e6;border-radius:10px;padding:12px 16px;margin-bottom:8px;display:flex;align-items:center;gap:14px;background:#fff">
                            <span style="width:40px;height:40px;background:#ae2070;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:18px;flex-shrink:0">M</span>
                            <div>
                                <div class="font-weight-bold">Ví MoMo</div>
                                <small class="text-muted">Quét mã QR để thanh toán qua MoMo</small>
                            </div>
                        </div>

                        <div class="pm-option" onclick="selectPM(this,'bank')" style="cursor:pointer;border:2px solid #dee2e6;border-radius:10px;padding:12px 16px;margin-bottom:8px;display:flex;align-items:center;gap:14px;background:#fff">
                            <span style="font-size:28px">🏦</span>
                            <div>
                                <div class="font-weight-bold">Chuyển khoản ngân hàng</div>
                                <small class="text-muted">Vietcombank · Techcombank · MB Bank</small>
                            </div>
                        </div>

                        <div class="pm-option" onclick="selectPM(this,'vnpay')" style="cursor:pointer;border:2px solid #dee2e6;border-radius:10px;padding:12px 16px;margin-bottom:8px;display:flex;align-items:center;gap:14px;background:#fff">
                            <span style="width:40px;height:40px;background:#006dff;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:18px;flex-shrink:0">V</span>
                            <div>
                                <div class="font-weight-bold">VNPay</div>
                                <small class="text-muted">Thẻ ATM, thẻ quốc tế, QR Pay</small>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" id="payment_method" value="cod">
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="/Product/cart" class="btn btn-outline-secondary btn-lg">← Quay lại</a>
                        <button type="submit" class="btn btn-success btn-lg">✅ Đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tóm tắt đơn hàng -->
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📋 Tóm tắt đơn hàng</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="font-weight-bold"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></span><br>
                            <small class="text-muted">x<?php echo $item['quantity']; ?> × <?php echo number_format($item['price'], 0, ',', '.'); ?> VND</small>
                        </div>
                        <span class="text-danger font-weight-bold"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="card-footer">
                    <div class="d-flex justify-content-between h5 font-weight-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-danger"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pm-option:hover { border-color: #28a745 !important; background: #f8fff9 !important; }
.active-pm { border-color: #28a745 !important; background: #f8fff9 !important; }
</style>
<script>
function selectPM(el, method) {
    document.querySelectorAll('.pm-option').forEach(o => {
        o.style.borderColor = '#dee2e6';
        o.style.background  = '#fff';
        o.classList.remove('active-pm');
    });
    el.style.borderColor = '#28a745';
    el.style.background  = '#f8fff9';
    el.classList.add('active-pm');
    document.getElementById('payment_method').value = method;
}
function validateCheckout() {
    let phone   = document.getElementById('phone').value.trim();
    let address = document.getElementById('address').value.trim();
    let errors  = [];
    if (!/^\d{9,11}$/.test(phone)) errors.push('Số điện thoại phải có 9-11 chữ số.');
    if (address.length < 10)       errors.push('Địa chỉ phải có ít nhất 10 ký tự.');
    if (errors.length > 0) { alert(errors.join('\n')); return false; }
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
