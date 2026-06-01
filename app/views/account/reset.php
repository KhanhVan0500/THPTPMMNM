<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2">🔐 Đặt lại mật khẩu</h2>
                            <p class="text-muted mb-0">Nhập mật khẩu mới để hoàn tất quá trình đặt lại.</p>
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
                        <?php endif; ?>
                        <?php if (!isset($success)) : ?>
                            <form action="/account/reset" method="post" onsubmit="return validatePassword()">
                                <input type="hidden" name="token" value="<?php echo htmlentities($token ?? ''); ?>">
                                
                                <div class="mb-4">
                                    <label class="form-label" for="password">Mật khẩu mới</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" 
                                           placeholder="Tối thiểu 8 ký tự" required>
                                    <small class="form-text text-muted d-block mt-2">
                                        ✓ Ít nhất 8 ký tự<br>
                                        ✓ Có ít nhất 1 chữ in hoa (A-Z)<br>
                                        ✓ Có ít nhất 1 số (0-9)<br>
                                        ✓ Có ít nhất 1 ký tự đặc biệt (!@#$%^&*)
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="confirmpassword">Xác nhận mật khẩu</label>
                                    <input type="password" id="confirmpassword" name="confirmpassword" class="form-control form-control-lg" 
                                           placeholder="Nhập lại mật khẩu" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">✅ Cập nhật mật khẩu</button>
                            </form>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="/account/login" class="text-decoration-none">← Quay lại đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function validatePassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmpassword').value;
    
    // Check if passwords match
    if (password !== confirmPassword) {
        alert('Mật khẩu mới và xác nhận không khớp!');
        return false;
    }
    
    // Check password requirements
    const hasUpperCase = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
    const isLongEnough = password.length >= 8;
    
    if (!isLongEnough || !hasUpperCase || !hasNumber || !hasSpecialChar) {
        let errors = [];
        if (!isLongEnough) errors.push('- Tối thiểu 8 ký tự');
        if (!hasUpperCase) errors.push('- Ít nhất 1 chữ in hoa (A-Z)');
        if (!hasNumber) errors.push('- Ít nhất 1 số (0-9)');
        if (!hasSpecialChar) errors.push('- Ít nhất 1 ký tự đặc biệt');
        
        alert('Mật khẩu không đáp ứng các yêu cầu:\n' + errors.join('\n'));
        return false;
    }
    
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
