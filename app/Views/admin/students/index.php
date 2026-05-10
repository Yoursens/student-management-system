<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/student_index.css">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0" style="font-weight:600">Students</h5>
        <small class="text-muted"><?= number_format($total) ?> total records</small>
    </div>
    <a href="/admin/students/create" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i> Add Student
    </a>
</div>

<!-- Search -->
<form method="GET" action="/admin/students" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="form-control"
                    placeholder="Search name, student no, program…"
                    value="<?= esc($search) ?>">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            <?php if ($search): ?>
            <a href="/admin/students" class="btn btn-sm btn-outline-secondary ms-1">Clear</a>
            <?php endif; ?>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student No</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Year / Section</th>
                    <th>Sex</th>
                    <th>Added By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($students)): ?>
            <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                    No students found<?= $search ? ' for "' . esc($search) . '"' : '' ?>
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($students as $i => $s): ?>
            <tr>
                <td style="color:var(--text-muted);font-size:.78rem"><?= $i + 1 ?></td>
                <td><code style="color:#3b82f6;font-size:.8rem"><?= esc($s['student_no']) ?></code></td>
                <td>
                    <strong><?= esc($s['last_name']) ?></strong>, <?= esc($s['first_name']) ?>
                    <?php if ($s['middle_name']): ?>
                    <span style="color:var(--text-muted)"> <?= esc($s['middle_name'][0]) ?>.</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:.85rem"><?= esc($s['program']) ?></td>
                <td>
                    <span class="badge bg-secondary me-1">Year <?= esc($s['year_level']) ?></span>
                    <?= $s['section'] ? '<small class="text-muted">' . esc($s['section']) . '</small>' : '' ?>
                </td>
                <td>
                    <?php $sexColors = ['Male'=>'#3b82f6','Female'=>'#ec4899','Other'=>'#8b5cf6']; ?>
                    <span style="color:<?= $sexColors[$s['sex']] ?? 'var(--text-muted)' ?>;font-size:.8rem">
                        <?= esc($s['sex']) ?>
                    </span>
                </td>
                <td style="font-size:.78rem;color:var(--text-muted)"><?= esc($s['created_by_name'] ?? 'System') ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="/admin/students/view/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-secondary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/admin/students/edit/<?= $s['student_id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                            onclick="confirmDelete(<?= $s['student_id'] ?>, '<?= esc($s['first_name'] . ' ' . $s['last_name']) ?>')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
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

<!-- Delete confirm modal -->
<form id="deleteForm" method="POST" action="">
    <?= csrf_field() ?>
</form>

<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content" style="background:var(--bg-card);border:1px solid var(--border);color:var(--text)">
      <div class="modal-header" style="border-color:var(--border)">
        <h6 class="modal-title">Delete Student?</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="font-size:.875rem">
        Are you sure you want to delete <strong id="studentName"></strong>? This cannot be undone.
      </div>
      <div class="modal-footer" style="border-color:var(--border)">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
let deleteId = null;
function confirmDelete(id, name) {
    deleteId = id;
    document.getElementById('studentName').textContent = name;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/students/delete/' + deleteId;
        form.submit();
    }
});
</script>

<?php echo view('partials/footer') ?>
