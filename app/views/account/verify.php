<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-3">Xác thực Email</h2>
                        <p class="mb-4"><?php echo htmlentities($message ?? ''); ?></p>
                        <a href="/account/login" class="btn btn-primary btn-lg">Đến trang đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
