<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/student_create.css">
</div>
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="/admin/students" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-weight:600">Add New Student</h5>
</div>

<div class="card" style="max-width:780px">
    <div class="card-body p-4">
        <form action="/admin/students/store" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <!-- Student No -->
                <div class="col-md-4">
                    <label class="form-label">Student No <span class="text-danger">*</span></label>
                    <input type="text" name="student_no" class="form-control"
                        placeholder="e.g. 2024-0001"
                        value="<?= esc(old('student_no')) ?>" required>
                </div>

                <!-- Name -->
                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control"
                        value="<?= esc(old('last_name')) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control"
                        value="<?= esc(old('first_name')) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control"
                        value="<?= esc(old('middle_name')) ?>">
                </div>

                <!-- Sex & Birthdate -->
                <div class="col-md-4">
                    <label class="form-label">Sex <span class="text-danger">*</span></label>
                    <select name="sex" class="form-select" required>
                        <option value="">Select</option>
                        <?php foreach (['Male','Female','Other'] as $s): ?>
                        <option value="<?= $s ?>" <?= old('sex') === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control"
                        value="<?= esc(old('birthdate')) ?>">
                </div>

                <!-- Academic -->
                <div class="col-md-5">
                    <label class="form-label">Program <span class="text-danger">*</span></label>
                    <input type="text" name="program" class="form-control"
                        placeholder="e.g. BS Computer Science"
                        value="<?= esc(old('program')) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Year Level <span class="text-danger">*</span></label>
                    <select name="year_level" class="form-select" required>
                        <option value="">Select</option>
                        <?php for ($y = 1; $y <= 6; $y++): ?>
                        <option value="<?= $y ?>" <?= old('year_level') == $y ? 'selected' : '' ?>>Year <?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" class="form-control"
                        placeholder="e.g. A" value="<?= esc(old('section')) ?>">
                </div>

                <!-- Contact -->
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= esc(old('email')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact No</label>
                    <input type="text" name="contact_no" class="form-control"
                        placeholder="09XXXXXXXXX" value="<?= esc(old('contact_no')) ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"
                        placeholder="Complete address"><?= esc(old('address')) ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Photo <small class="text-muted">(JPG/PNG, max 2MB)</small></label>
                    <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/gif">
                </div>
            </div>

            <hr style="border-color:var(--border);margin:1.5rem 0">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Save Student
                </button>
                <a href="/admin/students" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php echo view('partials/footer') ?>
