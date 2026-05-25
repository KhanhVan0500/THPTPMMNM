<?php include 'app/views/shares/header.php'; ?>

<?php
$banks = [
  'vcb' => ['label'=>'Vietcombank', 'name'=>'VIETCOMBANK', 'stk'=>'1234567890', 'color'=>'006b3c'],
  'tcb' => ['label'=>'Techcombank', 'name'=>'TECHCOMBANK', 'stk'=>'9876543210', 'color'=>'d32f2f'],
  'mb'  => ['label'=>'MB Bank',     'name'=>'MB BANK',     'stk'=>'0123456789', 'color'=>'1565c0'],
];
$sel = $_GET['bank'] ?? 'vcb';
if (!isset($banks[$sel])) $sel = 'vcb';
$b = $banks[$sel];
$qrData = urlencode('STK:'.$b['stk'].'|NH:'.$b['name'].'|ST:'.$total.'|ND:DH '.strtoupper($order_name));
$qrUrl  = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&color='.$b['color'].'&data='.$qrData;
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow text-center">
      <div class="card-header bg-dark text-white">
        <h4 class="mb-0">🏦 Chuyển khoản ngân hàng</h4>
      </div>
      <div class="card-body">
        <p class="text-muted mb-2">Chọn ngân hàng và chuyển khoản theo thông tin bên dưới</p>

        <!-- Chọn ngân hàng -->
        <div class="btn-group mb-3">
          <?php foreach ($banks as $code => $info): ?>
            <a href="/Product/paymentBank?bank=<?php echo $code; ?>"
               class="btn <?php echo $sel===$code ? 'btn-dark' : 'btn-outline-dark'; ?>"
               style="background:#<?php echo $info['color']; ?>;color:#fff;border:none;opacity:<?php echo $sel===$code?'1':'0.55'; ?>">
              <?php echo $info['label']; ?>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- QR -->
        <div style="background:#fff;border-radius:12px;padding:14px;display:inline-block;margin:8px auto;border:1px solid #eee">
          <img src="<?php echo $qrUrl; ?>" alt="Bank QR" width="220" height="220"
               onerror="this.outerHTML='<div style=\'padding:40px;color:red\'>Không tải được QR.</div>'">
        </div>

        <!-- Thông tin -->
        <div class="list-group mt-3 text-left">
          <div class="list-group-item d-flex justify-content-between">
            <span>Ngân hàng</span><strong><?php echo $b['name']; ?></strong>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <span>Số tài khoản</span>
            <strong><?php echo $b['stk']; ?>
              <button class="btn btn-sm btn-outline-secondary py-0 ml-1" onclick="cp('<?php echo $b['stk']; ?>')">Copy</button>
            </strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Chủ tài khoản</span><strong>NGUYEN VAN A</strong>
          </div>
          <div class="list-group-item d-flex justify-content-between">
            <span>Số tiền</span>
            <strong class="text-danger"><?php echo number_format($total,0,',','.'); ?> VND</strong>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <span>Nội dung CK</span>
            <strong>DH <?php echo strtoupper($order_name); ?>
              <button class="btn btn-sm btn-outline-secondary py-0 ml-1"
                onclick="cp('DH <?php echo strtoupper($order_name); ?>')">Copy</button>
            </strong>
          </div>
        </div>

        <div class="alert alert-info mt-3 text-left">
          ⚠️ Ghi đúng nội dung chuyển khoản để đơn hàng được xác nhận tự động.
        </div>

        <a href="/Product/orderConfirmation" class="btn btn-success btn-lg mt-2">
          ✅ Tôi đã chuyển khoản xong
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
