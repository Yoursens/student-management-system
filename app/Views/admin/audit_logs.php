<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/audit_logs.css">
<h5 class="mb-4" style="font-weight:600"><i class="bi bi-journal-text me-2"></i>Audit Logs</h5>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($logs)): ?>
            <tr><td colspan="4" class="text-center py-5 text-muted">No logs yet.</td></tr>
            <?php else: ?>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td style="font-size:.75rem;color:var(--text-muted);white-space:nowrap;font-family:'DM Mono',monospace">
                    <?= date('M d Y H:i', strtotime($log['created_at'])) ?>
                </td>
                <td style="font-size:.85rem"><?= esc($log['full_name'] ?? 'System') ?></td>
                <td>
                    <?php
                    $badgeColors = [
                        'LOGIN' => 'success', 'LOGOUT' => 'secondary',
                        'LOGIN_FAILED' => 'danger',
                        'CREATE_STUDENT' => 'primary', 'UPDATE_STUDENT' => 'warning',
                        'DELETE_STUDENT' => 'danger', 'CREATE_USER' => 'info',
                        'UPDATE_USER' => 'warning', 'DELETE_USER' => 'danger',
                    ];
                    $color = $badgeColors[$log['action']] ?? 'secondary';
                    ?>
                    <span class="badge bg-<?= $color ?>" style="font-family:'DM Mono',monospace;font-size:.7rem">
                        <?= esc($log['action']) ?>
                    </span>
                </td>
                <td style="font-size:.83rem"><?= esc($log['description']) ?></td>
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
