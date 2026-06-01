<?php include 'app/views/shares/header.php'; ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="fw-bold mb-1">Quản lý người dùng</h2>
                                <p class="text-muted mb-0">Danh sách tất cả tài khoản và trạng thái khóa.</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Họ tên</th>
                                        <th>Vai trò</th>
                                        <th>Xác thực email</th>
                                        <th>Khóa</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo htmlentities($user->id); ?></td>
                                            <td><?php echo htmlentities($user->username); ?></td>
                                            <td><?php echo htmlentities($user->fullname); ?></td>
                                            <td><?php echo htmlentities($user->role); ?></td>
                                            <td><?php echo $user->email_verified ? '<span class="badge badge-success">Đã xác thực</span>' : '<span class="badge badge-warning">Chưa</span>'; ?></td>
                                            <td><?php echo $user->is_locked ? '<span class="badge badge-danger">Đã khóa</span>' : '<span class="badge badge-success">Hoạt động</span>'; ?></td>
                                            <td>
                                                <?php if ($user->username !== ($_SESSION['username'] ?? '')) : ?>
                                                    <?php if ($user->is_locked) : ?>
                                                        <a href="/account/unlock/<?php echo htmlentities($user->id); ?>" class="btn btn-sm btn-success">Mở khóa</a>
                                                    <?php else : ?>
                                                        <a href="/account/lock/<?php echo htmlentities($user->id); ?>" class="btn btn-sm btn-danger">Khóa</a>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <span class="text-muted">Không thể thao tác</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <a href="/Product" class="btn btn-secondary">Quay lại trang chính</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
