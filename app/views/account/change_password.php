<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2">Đổi mật khẩu</h2>
                            <p class="text-muted mb-0">Nhập mật khẩu hiện tại và mật khẩu mới.</p>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?php echo htmlentities($error); ?></div>
                        <?php endif; ?>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success"><?php echo htmlentities($success); ?></div>
                        <?php endif; ?>
                        <form action="/account/updatepassword" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="current_password">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="new_password">Mật khẩu mới</label>
                                <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" placeholder="Mật khẩu mới" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="confirm_password">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Cập nhật mật khẩu</button>
                        </form>
                        <div class="text-center mt-4">
                            <a href="/account/profile" class="text-decoration-none">Quay lại hồ sơ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
