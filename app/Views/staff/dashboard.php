<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/staff_dashboard.css">
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,.15);color:#3b82f6">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="stat-value"><?= number_format($totalStudents) ?></div>
            <div class="stat-label">Total Students</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(34,197,94,.15);color:#22c55e">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div class="stat-value"><?= number_format($myStudents) ?></div>
            <div class="stat-label">My Enrolled Students</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(245,158,11,.15);color:#f59e0b">
                <i class="bi bi-shield-lock"></i>
            </div>
            <div class="stat-value" style="font-size:1.2rem">Read-Only</div>
            <div class="stat-label">Your Access Level</div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-person-lines-fill me-2"></i>Recent Students</span>
        <a href="/staff/students" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Student No</th><th>Name</th><th>Program</th><th>Year</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php if (empty($recentStudents)): ?>
            <tr><td colspan="5" class="text-center py-4 text-muted">No students yet.</td></tr>
            <?php else: ?>
            <?php foreach ($recentStudents as $s): ?>
            <tr>
                <td><code style="color:#3b82f6;font-size:.8rem"><?= esc($s['student_no']) ?></code></td>
                <td><?= esc($s['last_name']) ?>, <?= esc($s['first_name']) ?></td>
                <td style="font-size:.85rem"><?= esc($s['program']) ?></td>
                <td><span class="badge bg-secondary">Year <?= esc($s['year_level']) ?></span></td>
                <td>
                    <a href="/staff/students/view/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo view('partials/footer') ?>