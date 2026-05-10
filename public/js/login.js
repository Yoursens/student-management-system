/* ============================================================
   TA2 Student Information System — Login Page Scripts
   ============================================================ */

/**
 * togglePass
 * Switches the password field between plain text and password,
 * and swaps the eye icon accordingly.
 */
function togglePass() {
    const field   = document.getElementById('passwordField');
    const eyeIcon = document.getElementById('eyeIcon');

    if (field.type === 'password') {
        field.type        = 'text';
        eyeIcon.className = 'bi bi-eye-slash';
    } else {
        field.type        = 'password';
        eyeIcon.className = 'bi bi-eye';
    }
}