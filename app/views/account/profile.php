<?php include 'app/views/shares/header.php'; ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                <h2 class="fw-bold mb-1">Hồ sơ cá nhân</h2>
                                <p class="text-muted mb-0">Xem và cập nhật thông tin tài khoản của bạn.</p>
                            </div>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?php echo htmlentities($error); ?></div>
                        <?php endif; ?>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success"><?php echo htmlentities($success); ?></div>
                        <?php endif; ?>

                        <!-- Phần hiển thị thông tin khách hàng -->
                        <div class="mb-5 p-4 bg-light rounded-3">
                            <h4 class="fw-bold mb-4">📋 Thông tin khách hàng</h4>
                            <div class="row">
                                <div class="col-md-3 text-center mb-4">
                                    <?php if (!empty($account->avatar)) : ?>
                                        <img src="<?php echo htmlentities($account->avatar); ?>" alt="Avatar" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                                    <?php else : ?>
                                        <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:120px;height:120px;font-size:48px;">👤</div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Họ và tên</p>
                                            <p class="fw-bold"><?php echo htmlentities($account->fullname ?? 'Chưa cập nhật'); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Email</p>
                                            <p class="fw-bold"><?php echo htmlentities($account->username ?? ''); ?></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Số điện thoại</p>
                                            <p class="fw-bold"><?php echo !empty($account->phone) ? htmlentities($account->phone) : '<span class="text-muted">Chưa cập nhật</span>'; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Vai trò</p>
                                            <p class="fw-bold">
                                                <?php if ($account->role === 'admin') : ?>
                                                    <span class="badge bg-danger">Quản trị viên</span>
                                                <?php else : ?>
                                                    <span class="badge bg-info">Khách hàng</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Địa chỉ</p>
                                            <p class="fw-bold small"><?php echo !empty($account->address) ? htmlentities($account->address) : '<span class="text-muted">Chưa cập nhật</span>'; ?></p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-1 small">Trạng thái</p>
                                            <p class="fw-bold">
                                                <?php if ($account->email_verified) : ?>
                                                    <span class="badge bg-success">Đã xác thực</span>
                                                <?php else : ?>
                                                    <span class="badge bg-warning">Chưa xác thực</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Phần chỉnh sửa thông tin -->
                        <h4 class="fw-bold mb-4">✏️ Chỉnh sửa thông tin</h4>
                        <form action="/account/updateprofile" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo htmlentities($account->username ?? ''); ?>" readonly>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="fullname">Họ và tên</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo htmlentities($account->fullname ?? ''); ?>" required>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="phone">Số điện thoại</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlentities($account->phone ?? ''); ?>" placeholder="Ví dụ: 0901234567">
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="address">Địa chỉ</label>
                                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ đầy đủ"><?php echo htmlentities($account->address ?? ''); ?></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Ảnh đại diện</label>
                                <div class="mb-3">
                                    <?php if (!empty($account->avatar)) : ?>
                                        <img src="<?php echo htmlentities($account->avatar); ?>" alt="Avatar" class="rounded-circle" style="width:96px;height:96px;object-fit:cover;">
                                    <?php else : ?>
                                        <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:96px;height:96px;">?</div>
                                    <?php endif; ?>
                                </div>
                                <input type="file" class="form-control-file" id="avatar" name="avatar" accept="image/*">
                                <small class="form-text text-muted">Tải lên ảnh JPG/PNG/GIF, tối đa 5MB.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="/account/changePassword" class="btn btn-outline-secondary ml-2">Đổi mật khẩu</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
