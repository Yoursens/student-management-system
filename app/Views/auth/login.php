<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TA2 Student System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,700;1,9..144,400&family=Outfit:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Login Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>
<body>

<!-- ══════════════════════════════════════════════════════════
     LOGIN WRAPPER — 60 / 40 split
     ══════════════════════════════════════════════════════════ -->
<div class="login-wrapper">

    <!-- ════════════════════════════════
         LEFT PANEL — 60% image side
         ════════════════════════════════ -->
    <div class="image-panel">
        <div class="bg-img"></div>
        <div class="image-panel-grid"></div>

        <!-- Floating badge -->
        <div class="image-badge">
            <div class="dot"></div>
            <span>Live System</span>
        </div>

        <!-- Bottom content -->
        <div class="image-panel-content">
            <div class="image-stats">
                <div class="stat-pill">
                    <span class="num">4.2k</span>
                    <span class="lbl">Students</span>
                </div>
                <div class="stat-pill">
                    <span class="num">180</span>
                    <span class="lbl">Courses</span>
                </div>
                <div class="stat-pill">
                    <span class="num">98%</span>
                    <span class="lbl">Uptime</span>
                </div>
            </div>

            <h2 class="image-caption">
                Manage your<br><em>campus,</em><br>effortlessly.
            </h2>
            <p class="image-sub">
                TA2 Student Information System — secure, fast, and built for modern educational institutions.
            </p>
        </div>
    </div>
    <!-- end .image-panel -->

    <!-- ════════════════════════════════
         RIGHT PANEL — 40% form side
         ════════════════════════════════ -->
    <div class="form-panel">
        <div class="login-card">

            <!-- Logo Row -->
            <div class="login-logo">
                <div class="icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h5>StudentSys</h5>
                    <small>Terminal Assessment 2</small>
                </div>
            </div>

            <!-- Heading -->
            <h4>Welcome back</h4>
            <p class="subtitle">Sign in to your account to continue</p>

            <div class="form-divider"></div>

            <!-- Flash: Error -->
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
            <?php endif; ?>

            <!-- Flash: Success -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if (isset($errors) && $errors): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ((array) $errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="/login" method="POST">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label" for="emailField">Email address</label>
                    <input
                        type="email"
                        id="emailField"
                        name="email"
                        class="form-control"
                        placeholder="admin@example.com"
                        value="<?= esc(old('email')) ?>"
                        required
                        autocomplete="email"
                    >
                </div>

                <!-- Password -->
                <div class="mb-4 position-relative">
                    <label class="form-label" for="passwordField">Password</label>
                    <input
                        type="password"
                        id="passwordField"
                        name="password"
                        class="form-control pe-5"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="eye-toggle" onclick="togglePass()" aria-label="Toggle password visibility">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="demo-box">
                <strong>Demo Accounts</strong>
                Admin: admin@studentsys.com / Admin@1234<br>
                Staff: staff@studentsys.com / Staff@1234
            </div>

        </div>
        <!-- end .login-card -->
    </div>
    <!-- end .form-panel -->

</div>
<!-- end .login-wrapper -->

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Login Scripts -->
<script src="<?= base_url('js/login.js') ?>"></script>

</body>
</html>