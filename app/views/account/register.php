<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 gradient-custom">
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card shadow-lg" style="border-radius: 25px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Đăng ký tài khoản</h2>
                        <p class="text-muted">Sử dụng email Gmail để đăng ký và bắt đầu trải nghiệm</p>
                    </div>
                    <?php if (isset($errors)) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err) : ?>
                                    <li><?php echo htmlentities($err); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="/account/save" method="post">
                        <div class="form-group mb-3">
                            <label class="form-label" for="role">Quyền</label>
                            <select class="form-control form-control-lg" id="role" name="role">
                                <option value="user" selected>Người dùng (user)</option>
                                <option value="admin">Quản trị (admin)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email (Gmail)</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="you@gmail.com" required>
                        </div>
                        <div class="form-row row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Mật khẩu" required>
                                <small class="form-text text-muted">Mật khẩu tối thiểu 8 ký tự, có chữ in hoa, số và ký tự đặc biệt.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="confirmpassword">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control form-control-lg" id="confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-4" style="border-radius: 12px;">Đăng ký ngay</button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="mb-0">Lưu ý: Quyền admin chỉ được cấp khi đăng ký tài khoản admin đầu tiên hoặc email nằm trong cấu hình <code>admin_emails</code>.</p>
                        <p class="mb-0">Đã có tài khoản? <a href="/account/login" class="fw-bold text-primary">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<?php include 'app/views/shares/footer.php'; ?>