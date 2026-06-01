<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<div class="card shadow-lg border-0 rounded-4">
					<div class="card-body p-5">
						<div class="text-center mb-4">
							<h2 class="fw-bold mb-2">Đăng nhập</h2>
							<p class="text-muted mb-0">Đăng nhập bằng email Gmail và mật khẩu của bạn.</p>
						</div>

						<?php if (isset($error)) : ?>
							<div class="alert alert-danger" role="alert">
								<?php echo htmlentities($error); ?>
							</div>
						<?php endif; ?>

						<form action="/account/checklogin" method="post">
							<div class="mb-3">
								<label class="form-label" for="email">Email (Gmail)</label>
								<input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="you@gmail.com" required>
							</div>
							<div class="mb-4">
								<label class="form-label" for="password">Mật khẩu</label>
								<input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Nhập mật khẩu" required>
							</div>
							<div class="d-flex justify-content-between align-items-center mb-4">
								<a href="#!" class="text-decoration-none text-muted small">Quên mật khẩu?</a>
							</div>
							<button type="submit" class="btn btn-primary btn-lg w-100">Đăng nhập</button>
						</form>

						<div class="text-center mt-4">
							<p class="mb-0 text-muted">Chưa có tài khoản? <a href="/account/register" class="text-primary fw-semibold">Đăng ký ngay</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include 'app/views/shares/footer.php'; ?>