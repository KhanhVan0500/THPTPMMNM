<?php include 'app/views/shares/header.php'; ?>

<?php
$qrData = urlencode('momo://transfer?phone=0901234567&amount='.$total.'&comment=DonHang'.urlencode($order_name));
$qrUrl  = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&color=ae2070&data=' . $qrData;
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow text-center">
      <div class="card-header text-white" style="background:#ae2070">
        <h4 class="mb-0">💜 Thanh toán MoMo</h4>
      </div>
      <div class="card-body">
        <p class="text-muted">Mở app <strong>MoMo</strong> → Quét mã QR bên dưới để thanh toán</p>

        <div style="background:#fff;border-radius:12px;padding:14px;display:inline-block;margin:10px auto;border:1px solid #eee">
          <img src="<?php echo $qrUrl; ?>" alt="MoMo QR" width="220" height="220"
               onerror="this.outerHTML='<div style=\'padding:40px;color:red\'>Không tải được QR. Vui lòng kiểm tra kết nối mạng.</div>'">
        </div>

        <div class="list-group mt-3 text-left">
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <span>SĐT MoMo</span>
            <strong>0901 234 567
              <button class="btn btn-sm btn-outline-secondary py-0 ml-1" onclick="cp('0901234567')">Copy</button>
            </strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Tên tài khoản</span><strong>NGUYEN VAN A</strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Số tiền</span>
            <strong class="text-danger"><?php echo number_format($total,0,',','.'); ?> VND</strong>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <span>Nội dung</span>
            <strong>DonHang <?php echo strtoupper($order_name); ?>
              <button class="btn btn-sm btn-outline-secondary py-0 ml-1"
                onclick="cp('DonHang <?php echo strtoupper($order_name); ?>')">Copy</button>
            </strong>
          </div>
        </div>

        <div class="alert alert-warning mt-3 text-left">
          ⚠️ Chuyển đúng số tiền và nội dung để đơn hàng được xử lý tự động.
        </div>

        <a href="/Product/orderConfirmation" class="btn btn-success btn-lg mt-2">
          ✅ Tôi đã thanh toán xong
        </a>
      </div>
    </div>
  </div>
</div>

<script>
function cp(txt) {
  navigator.clipboard.writeText(txt).then(() => alert('✅ Đã copy: ' + txt));
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
