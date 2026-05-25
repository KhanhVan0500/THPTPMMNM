<?php include 'app/views/shares/header.php'; ?>

<?php
$orderId = 'VNP' . substr(time(), -8);
$qrData  = urlencode('vnpay://pay?amount='.$total.'&order='.$orderId.'&name='.urlencode($order_name));
$qrUrl   = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&color=006dff&data=' . $qrData;
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow text-center">
      <div class="card-header text-white" style="background:#006dff">
        <h4 class="mb-0">💙 Thanh toán VNPay</h4>
      </div>
      <div class="card-body">
        <p class="text-muted">Mở app ngân hàng hoặc ví VNPay → Quét mã QR bên dưới</p>

        <div style="background:#fff;border-radius:12px;padding:14px;display:inline-block;margin:10px auto;border:1px solid #eee">
          <img src="<?php echo $qrUrl; ?>" alt="VNPay QR" width="220" height="220"
               onerror="this.outerHTML='<div style=\'padding:40px;color:red\'>Không tải được QR.</div>'">
        </div>

        <div class="list-group mt-3 text-left">
          <div class="list-group-item d-flex justify-content-between">
            <span>Mã đơn hàng</span><strong><?php echo $orderId; ?></strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Số tiền</span>
            <strong class="text-danger"><?php echo number_format($total,0,',','.'); ?> VND</strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Hiệu lực QR</span>
            <strong class="text-success" id="timer">15:00</strong>
          </div>
        </div>

        <div class="mt-3">
          <span class="badge badge-primary p-2 mr-1">💳 Thẻ ATM</span>
          <span class="badge badge-warning p-2 mr-1">💳 Visa/Master</span>
          <span class="badge badge-success p-2">📱 App ngân hàng</span>
        </div>

        <div class="alert alert-primary mt-3 text-left">
          🔒 Giao dịch được bảo mật bởi VNPay &amp; SSL 256-bit.
        </div>

        <a href="/Product/orderConfirmation" class="btn btn-success btn-lg mt-2">
          ✅ Tôi đã thanh toán xong
        </a>
      </div>
    </div>
  </div>
</div>

<script>
var secs = 900;
var iv = setInterval(function() {
  secs--;
  var el = document.getElementById('timer');
  if (!el) { clearInterval(iv); return; }
  if (secs <= 0) { el.textContent='Hết hạn'; el.style.color='red'; clearInterval(iv); return; }
  var m = String(Math.floor(secs/60)).padStart(2,'0');
  var s = String(secs%60).padStart(2,'0');
  el.textContent = m+':'+s;
  if (secs < 60) el.style.color='red';
}, 1000);
</script>

<?php include 'app/views/shares/footer.php'; ?>
