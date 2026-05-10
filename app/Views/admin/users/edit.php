<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/users_edit.css">
<link rel="stylesheet" href="/css/users_create.css">
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/users" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0" style="font-weight:600">Edit User</h5>
</div>

<div class="card" style="max-width:500px">
    <div class="card-body p-4">
        <form action="/admin/users/update/<?= $user['user_id'] ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" class="form-control"
                    value="<?= esc(old('full_name', $user['full_name'])) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control"
                    value="<?= esc(old('email', $user['email'])) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" minlength="8">
            </div>
            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role_id" class="form-select" required>
                    <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['role_id'] ?>" <?= (old('role_id', $user['role_id']) == $r['role_id']) ? 'selected' : '' ?>>
                        <?= esc($r['role_name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= (old('status', $user['status']) === 'active') ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= (old('status', $user['status']) === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update User</button>
                <a href="/admin/users" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php echo view('partials/footer') ?>
