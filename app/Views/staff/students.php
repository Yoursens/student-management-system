<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/staff_students.css">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0" style="font-weight:600">Students</h5>
        <small class="text-muted"><?= number_format($total) ?> total records (read-only view)</small>
    </div>
</div>

<form method="GET" action="/staff/students" class="mb-3">
    <div class="row g-2">
        <div class="col-md-5">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="form-control"
                    placeholder="Search by name, student no, program…"
                    value="<?= esc($search) ?>">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            <?php if ($search): ?>
            <a href="/staff/students" class="btn btn-sm btn-outline-secondary ms-1">Clear</a>
            <?php endif; ?>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Student No</th><th>Name</th><th>Program</th><th>Year / Section</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php if (empty($students)): ?>
            <tr><td colspan="5" class="text-center py-5 text-muted">No students found.</td></tr>
            <?php else: ?>
            <?php foreach ($students as $s): ?>
            <tr>
                <td><code style="color:#3b82f6;font-size:.8rem"><?= esc($s['student_no']) ?></code></td>
                <td><?= esc($s['last_name']) ?>, <?= esc($s['first_name']) ?></td>
                <td style="font-size:.85rem"><?= esc($s['program']) ?></td>
                <td>
                    <span class="badge bg-secondary me-1">Year <?= esc($s['year_level']) ?></span>
                    <?= $s['section'] ? '<small class="text-muted">' . esc($s['section']) . '</small>' : '' ?>
                </td>
                <td>
                    <a href="/staff/students/view/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye me-1"></i>View
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager): ?>
    <div class="card-footer" style="background:transparent;border-top:1px solid var(--border);padding:.75rem 1.25rem">
        <?= $pager->links('default', 'bootstrap_5') ?>
    </div>
    <?php endif; ?>
</div>
<?php echo view('partials/footer') ?>
