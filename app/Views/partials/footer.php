    </div><!-- /content-area -->
</div><!-- /main-wrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss alerts after 5 s
document.querySelectorAll('.alert').forEach(function(el) {
    setTimeout(function() {
        var alert = bootstrap.Alert.getOrCreateInstance(el);
        alert.close();
    }, 5000);
});

// CSRF token in all AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
document.querySelectorAll('form[method="POST"]').forEach(form => {
    if (!form.querySelector('input[name="csrf_token"]')) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'csrf_token';
        input.value = csrfToken;
        form.appendChild(input);
    }
});
</script>
</body>
</html>
