<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/admin_dashboard.css">

<!-- ── Stat Cards ── -->
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div>
                <div class="stat-value"><?= number_format($totalStudents) ?></div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="stat-value"><?= number_format($totalUsers) ?></div>
                <div class="stat-label">System Users</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-braces"></i>
            </div>
            <div>
                <div class="stat-value">4</div>
                <div class="stat-label">API Endpoints</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="stat-value">ON</div>
                <div class="stat-label">CSRF + XSS Active</div>
            </div>
        </div>
    </div>

</div>

<!-- ── Students + Activity Row ── -->
<div class="row g-3">

    <!-- Recent Students -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-person-lines-fill me-2"></i>Recent Students</span>
                <a href="/admin/students" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Student No</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentStudents)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No students yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentStudents as $s): ?>
                                <tr>
                                    <td><code><?= esc($s['student_no']) ?></code></td>
                                    <td><?= esc($s['last_name']) ?>, <?= esc($s['first_name']) ?></td>
                                    <td><?= esc($s['program']) ?></td>
                                    <td><span class="badge bg-secondary"><?= esc($s['year_level']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Audit Logs -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-journal-text me-2"></i>Recent Activity</span>
                <a href="/admin/audit-logs" class="btn btn-sm btn-outline-secondary">All Logs</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentLogs)): ?>
                    <div class="p-4 text-center text-muted">No activity yet.</div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentLogs as $log): ?>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary"
                                          data-action="<?= esc($log['action']) ?>">
                                        <?= esc($log['action']) ?>
                                    </span>
                                    <small class="text-muted"><?= esc($log['full_name'] ?? 'System') ?></small>
                                </div>
                                <div style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem">
                                    <?= esc($log['description']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- ── REST API Endpoints ── -->
<div class="card mt-3">
    <div class="card-header">
        <span><i class="bi bi-braces me-2"></i>REST API Endpoints</span>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <?php
            $endpoints = [
                ['GET /api/students',      '/api/students',   'List all students (paginated)'],
                ['GET /api/students/{id}', '/api/students/1', 'Single student details'],
                ['GET /api/users',         '/api/users',      'List all system users'],
                ['GET /api/stats',         '/api/stats',      'Summary statistics'],
            ];
            foreach ($endpoints as $ep):
            ?>
                <div class="col-md-6">
                    <div style="background:#1e2229;border:1px solid var(--border);border-radius:8px;padding:.75rem 1rem">
                        <div class="d-flex justify-content-between align-items-center">
                            <code style="color:#3b82f6;font-size:.8rem"><?= esc($ep[0]) ?></code>
                            <a href="<?= esc($ep[1]) ?>" target="_blank"
                               class="btn btn-sm btn-outline-primary"
                               style="font-size:.7rem">Test</a>
                        </div>
                        <div style="font-size:.75rem;color:var(--text-muted);margin-top:.3rem">
                            <?= esc($ep[2]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php echo view('partials/footer') ?>