<?php echo view('partials/header', ['title' => $title]) ?>
<link rel="stylesheet" href="/css/users_index.css">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0" style="font-weight:600">System Users</h5>
    <a href="/admin/users/create" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i> Add User
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted">No users found.</td></tr>
            <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td style="font-weight:500"><?= esc($u['full_name']) ?></td>
                <td style="font-size:.83rem;color:var(--text-muted)"><?= esc($u['email']) ?></td>
                <td>
                    <?php $roleColor = $u['role_name'] === 'Admin' ? 'bg-primary' : 'bg-secondary'; ?>
                    <span class="badge <?= $roleColor ?>"><?= esc($u['role_name']) ?></span>
                </td>
                <td>
                    <?php $stColor = $u['status'] === 'active' ? 'success' : 'danger'; ?>
                    <span class="badge bg-<?= $stColor ?>"><?= ucfirst(esc($u['status'])) ?></span>
                </td>
                <td style="font-size:.78rem;color:var(--text-muted)"><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="/admin/users/edit/<?= $u['user_id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if ($u['user_id'] != session()->get('user_id')): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="confirmDelete(<?= $u['user_id'] ?>, '<?= esc($u['full_name']) ?>')">
                            <i class="bi bi-trash"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<form id="deleteForm" method="POST" action=""><<?= csrf_field() ?></form>
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content" style="background:var(--bg-card);border:1px solid var(--border);color:var(--text)">
      <div class="modal-header" style="border-color:var(--border)">
        <h6 class="modal-title">Delete User?</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="font-size:.875rem">
        Delete <strong id="userName"></strong>? This cannot be undone.
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
    document.getElementById('userName').textContent = name;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteId) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/users/delete/' + deleteId;
        form.submit();
    }
});
</script>
<?php echo view('partials/footer') ?>
