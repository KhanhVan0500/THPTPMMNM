<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2">🔑 Quên mật khẩu</h2>
                            <p class="text-muted mb-0">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlentities($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo htmlentities($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="alert alert-info">
                                <p class="mb-0"><strong>💡 Mẹo:</strong> Kiểm tra thư mục Spam nếu không thấy email trong Inbox.</p>
                            </div>
                        <?php endif; ?>
                        <form action="/account/sendreset" method="post">
                            <div class="mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" 
                                       placeholder="you@gmail.com" 
                                       value="<?php echo htmlentities($_POST['email'] ?? ''); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">📧 Gửi liên kết đặt lại</button>
                        </form>
                        <hr>
                        <div class="alert alert-light border">
                            <p class="mb-2"><strong>📌 Hướng dẫn:</strong></p>
                            <ol class="mb-0 small">
                                <li>Nhập email đăng ký của bạn</li>
                                <li>Nhấn nút "Gửi liên kết"</li>
                                <li>Kiểm tra email để lấy liên kết đặt lại (có thể mất vài phút)</li>
                                <li>Click vào liên kết và nhập mật khẩu mới</li>
                            </ol>
                        </div>
                        <div class="text-center mt-4">
                            <a href="/account/login" class="text-decoration-none">← Quay lại đăng nhập</a> | 
                            <a href="/account/register" class="text-decoration-none">Đăng ký tài khoản mới →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
