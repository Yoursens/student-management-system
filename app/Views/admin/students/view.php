<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/student_view.css"></div>
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0" style="font-weight:600">Student Profile</h5>
</div>

<div class="card" style="max-width:680px">
    <div class="card-body p-4">
        <div class="d-flex align-items-start gap-4 mb-4">
            <div style="width:80px;height:80px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#6366f1);display:flex;align-items:center;justify-content:center;font-size:2rem;color:white;flex-shrink:0">
                <?= strtoupper(substr($student['first_name'], 0, 1)) ?>
            </div>
            <div>
                <h4 style="font-weight:700;margin-bottom:.25rem">
                    <?= esc($student['last_name']) ?>, <?= esc($student['first_name']) ?>
                    <?= $student['middle_name'] ? esc($student['middle_name'][0]) . '.' : '' ?>
                </h4>
                <code style="color:#3b82f6;font-size:.9rem"><?= esc($student['student_no']) ?></code>
                <div class="mt-2">
                    <span class="badge bg-primary me-1"><?= esc($student['program']) ?></span>
                    <span class="badge bg-secondary me-1">Year <?= esc($student['year_level']) ?></span>
                    <?php if ($student['section']): ?>
                    <span class="badge bg-dark" style="border:1px solid var(--border)"><?= esc($student['section']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row g-3" style="font-size:.875rem">
            <?php
            $fields = [
                ['Sex', $student['sex']],
                ['Birthdate', $student['birthdate'] ? date('F d, Y', strtotime($student['birthdate'])) : '—'],
                ['Email', $student['email'] ?: '—'],
                ['Contact No', $student['contact_no'] ?: '—'],
                ['Address', $student['address'] ?: '—'],
                ['Enrolled', date('M d, Y', strtotime($student['created_at']))],
            ];
            foreach ($fields as $f):
            ?>
            <div class="col-md-6">
                <div style="color:var(--text-muted);font-size:.73rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em"><?= $f[0] ?></div>
                <div style="margin-top:.2rem"><?= esc($f[1]) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <hr style="border-color:var(--border);margin:1.5rem 0">
        <div class="d-flex gap-2">
            <a href="/admin/students/edit/<?= $student['student_id'] ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="/admin/students" class="btn btn-outline-secondary btn-sm">Back to List</a>
        </div>
    </div>
</div>

<?php echo view('partials/footer') ?>
