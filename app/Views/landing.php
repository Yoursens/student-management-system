<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentSys — Terminal Assessment 2</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Instrument+Serif:ital@0;1&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- GSAP (required by studentsys.js) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- Page Stylesheet -->
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>

<div class="cursor" id="cursor"></div>

<!-- ══════════════════════════════════════════
     NAV
     ══════════════════════════════════════════ -->
<nav id="mainNav" class="on-hero">
    <div class="nav-logo">Student<span>Sys</span></div>
    <div class="nav-links">
        <a href="#features">Features</a>
        <a href="#api">API</a>
        <a href="#roles">Roles</a>
        <a href="#security">Security</a>
        <a href="/login" class="nav-cta">Login →</a>
    </div>
</nav>

<!-- ══════════════════════════════════════════
     GSAP SCROLL MASTER
     600vh container — sticky scene pins hero
     image and morphs it into a card on scroll
     ══════════════════════════════════════════ -->
<div class="master">
  <div class="sticky" id="stickyScene">

    <!-- Background giant word -->
    <div class="bg-word" id="bgWord">SYSTEM</div>

    <!-- Hero image — collapses to card on scroll -->
    <div class="img-wrap" id="imgWrap">
      <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1600&q=80" alt="Campus" id="mainImg">
      <div class="img-overlay"   id="imgOverlay"></div>
      <div class="img-grid"      id="imgGrid"></div>
      <div class="img-scanlines" id="imgScanlines"></div>

      <!-- Stats panel fades in once image becomes card -->
      <div class="card-img-stats" id="cardStats" style="opacity:0">
        <div class="slide-stat-grid">
          <div class="slide-stat">
            <div class="slide-stat-num">4<span>+</span></div>
            <div class="slide-stat-label">REST Endpoints</div>
          </div>
          <div class="slide-stat">
            <div class="slide-stat-num">2</div>
            <div class="slide-stat-label">User Roles</div>
          </div>
          <div class="slide-stat">
            <div class="slide-stat-num">100<span>%</span></div>
            <div class="slide-stat-label">CSRF Protected</div>
          </div>
          <div class="slide-stat">
            <div class="slide-stat-num">CI<span>4</span></div>
            <div class="slide-stat-label">Framework</div>
          </div>
        </div>
        <div class="slide-badge">
          <div class="slide-badge-text">Development Server Active</div>
          <div class="slide-dot"></div>
        </div>
      </div>
    </div>
    <!-- end #imgWrap -->

    <!-- Phase 1: Fullscreen hero text -->
    <div class="fullscreen-text" id="phase1">
      <div class="cin-eyebrow">Terminal Assessment 2 · CodeIgniter 4</div>
      <h1 class="cin-title">
        Student<br>
        Information<br>
        <em>System.</em>
      </h1>
      <p class="cin-sub">
        A secure, role-based management platform with REST API endpoints,
        full CRUD operations, audit logging, and CSRF/XSS protection.
      </p>
      <div class="scroll-hint">
        <div class="scroll-dot"></div>
        Scroll to explore
      </div>
    </div>

    <!-- Phase 2: Card + description text (revealed by GSAP) -->
    <div class="card-phase" id="phase2">
      <div class="card-img-container">
        <span class="card-badge">CI4 · PHP 8.2</span>
      </div>
      <div class="card-text" id="cardText">
        <div class="label">Overview</div>
        <h2>Built for<br>Security &<br><em>Clarity.</em></h2>
        <p>
          A complete student information system with role-based access, REST API
          endpoints, full audit logging — all running on CodeIgniter 4 with PHP 8.2
          and MySQL.
        </p>
        <div class="card-stats-row">
          <div class="c-stat">
            <div class="c-stat-num">4<span>+</span></div>
            <div class="c-stat-label">REST Endpoints</div>
          </div>
          <div class="c-stat">
            <div class="c-stat-num">2</div>
            <div class="c-stat-label">User Roles</div>
          </div>
          <div class="c-stat">
            <div class="c-stat-num">CI<span>4</span></div>
            <div class="c-stat-label">Framework</div>
          </div>
        </div>
        <a href="/login" class="btn-cta">→ Access System <span class="btn-cta-arrow">↗</span></a>
      </div>
    </div>

  </div>
</div>
<!-- end .master -->

<!-- ══════════════════════════════════════════
     MARQUEE
     ══════════════════════════════════════════ -->
<div class="marquee-wrap">
    <div class="marquee-track" id="marqueeTrack">
        <div class="marquee-item">CodeIgniter 4</div>
        <div class="marquee-item">REST API</div>
        <div class="marquee-item">CRUD Operations</div>
        <div class="marquee-item">CSRF Protection</div>
        <div class="marquee-item">XSS Prevention</div>
        <div class="marquee-item">Bcrypt Hashing</div>
        <div class="marquee-item">Role-Based Access</div>
        <div class="marquee-item">Audit Logging</div>
        <div class="marquee-item">MySQL Database</div>
        <div class="marquee-item">PHP 8.2</div>
        <!-- duplicated for seamless loop -->
        <div class="marquee-item">CodeIgniter 4</div>
        <div class="marquee-item">REST API</div>
        <div class="marquee-item">CRUD Operations</div>
        <div class="marquee-item">CSRF Protection</div>
        <div class="marquee-item">XSS Prevention</div>
        <div class="marquee-item">Bcrypt Hashing</div>
        <div class="marquee-item">Role-Based Access</div>
        <div class="marquee-item">Audit Logging</div>
        <div class="marquee-item">MySQL Database</div>
        <div class="marquee-item">PHP 8.2</div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     FEATURES
     ══════════════════════════════════════════ -->
<section class="features" id="features">
    <div class="feature-col">
        <div class="feature-num">01</div>
        <div class="feature-title">Full Student CRUD</div>
        <p class="feature-desc">Create, read, update, and delete student records with photo uploads, validation, search, and Bootstrap 5 paginated tables.</p>
        <span class="feature-tag">Admin Only</span>
    </div>
    <div class="feature-col">
        <div class="feature-num">02</div>
        <div class="feature-title">REST API</div>
        <p class="feature-desc">Four JSON endpoints — students list, single student, users list, and statistics — protected by X-API-Key or session authentication.</p>
        <span class="feature-tag">GET Endpoints</span>
    </div>
    <div class="feature-col">
        <div class="feature-num">03</div>
        <div class="feature-title">Audit Trail</div>
        <p class="feature-desc">Every login, logout, create, update, and delete action is logged with user ID, action type, IP address, and timestamp.</p>
        <span class="feature-tag">Full History</span>
    </div>
</section>

<!-- ══════════════════════════════════════════
     API
     ══════════════════════════════════════════ -->
<section class="api-section" id="api">
    <div class="api-left">
        <div class="section-label">REST API</div>
        <h2 class="section-title">Four Endpoints.<br>One Key.</h2>
        <p class="section-desc">
            All endpoints accept either an active session or an
            <code style="font-family:'DM Mono',monospace;font-size:.85em;background:var(--cream);padding:.1rem .4rem">X-API-Key</code>
            header for external access.
        </p>
        <div class="api-endpoints">
            <div class="endpoint">
                <span class="endpoint-method">GET</span>
                <span class="endpoint-path">/api/students</span>
                <span class="endpoint-desc">paginated · searchable</span>
            </div>
            <div class="endpoint">
                <span class="endpoint-method">GET</span>
                <span class="endpoint-path">/api/students/{id}</span>
                <span class="endpoint-desc">single record</span>
            </div>
            <div class="endpoint">
                <span class="endpoint-method">GET</span>
                <span class="endpoint-path">/api/users</span>
                <span class="endpoint-desc">all system users</span>
            </div>
            <div class="endpoint">
                <span class="endpoint-method">GET</span>
                <span class="endpoint-path">/api/stats</span>
                <span class="endpoint-desc">counts + breakdowns</span>
            </div>
        </div>
    </div>
    <div class="api-right">
        <div class="code-header">JSON Response · /api/students</div>
        <div class="code-block">
            <span class="c-gray">{</span><br>
            &nbsp;&nbsp;<span class="c-yellow">"status"</span><span class="c-gray">:</span> <span class="c-green">"success"</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;<span class="c-yellow">"page"</span><span class="c-gray">:</span> <span class="c-blue">1</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;<span class="c-yellow">"per_page"</span><span class="c-gray">:</span> <span class="c-blue">10</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;<span class="c-yellow">"total"</span><span class="c-gray">:</span> <span class="c-blue">12</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;<span class="c-yellow">"data"</span><span class="c-gray">: [{</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="c-yellow">"student_no"</span><span class="c-gray">:</span> <span class="c-green">"2024-0001"</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="c-yellow">"first_name"</span><span class="c-gray">:</span> <span class="c-green">"Maria"</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="c-yellow">"last_name"</span><span class="c-gray">:</span> <span class="c-green">"Santos"</span><span class="c-gray">,</span><br>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="c-yellow">"program"</span><span class="c-gray">:</span> <span class="c-green">"BS Computer Science"</span><br>
            &nbsp;&nbsp;<span class="c-gray">}]</span><br>
            <span class="c-gray">}</span>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     ROLES
     ══════════════════════════════════════════ -->
<section class="roles-section" id="roles">
    <div class="roles-header">
        <div>
            <div class="section-label">Access Control</div>
            <h2 class="section-title">Two Roles.<br>Clear Boundaries.</h2>
        </div>
        <p style="max-width:280px;font-size:.85rem;color:var(--muted);line-height:1.75">
            Role-based access control enforced at the route level via CI4 filters.
            Every request is verified before reaching any controller.
        </p>
    </div>
    <div class="roles-grid">
        <div class="role-card">
            <div class="role-name">Administrator</div>
            <p class="role-desc">Full system access including user management, all CRUD operations, audit log viewing, and API access.</p>
            <div class="role-perms">
                <div class="perm yes">View all students</div>
                <div class="perm yes">Add / Edit / Delete students</div>
                <div class="perm yes">Manage system users</div>
                <div class="perm yes">View audit logs</div>
                <div class="perm yes">Access REST API</div>
            </div>
        </div>
        <div class="role-card">
            <div class="role-name">Staff</div>
            <p class="role-desc">Read-only access to student records. Can view student profiles and use the API but cannot modify data.</p>
            <div class="role-perms">
                <div class="perm yes">View all students</div>
                <div class="perm">Add / Edit / Delete students</div>
                <div class="perm">Manage system users</div>
                <div class="perm">View audit logs</div>
                <div class="perm yes">Access REST API</div>
            </div>
        </div>
        <div class="role-card">
            <div class="role-name">Login Credentials</div>
            <p class="role-desc">Demo accounts seeded into the database using bcrypt cost-12 hashing.</p>
            <div class="role-perms">
                <div class="perm yes">admin@studentsys.com</div>
                <div class="perm yes">Password: Admin@1234</div>
            </div>
        </div>
        <div class="role-card">
            <div class="role-name">Staff Account</div>
            <p class="role-desc">Limited dashboard with read-only student access. Blocked from admin routes by AuthFilter.</p>
            <div class="role-perms">
                <div class="perm yes">staff@studentsys.com</div>
                <div class="perm yes">Password: Staff@1234</div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     SECURITY
     ══════════════════════════════════════════ -->
<section class="security-section" id="security">
    <div class="section-label" style="color:#4ade80">
        <span style="background:#4ade80;width:20px;height:1.5px;display:inline-block;margin-right:.6rem"></span>Security
    </div>
    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2.2rem,3.5vw,3rem);line-height:.92;margin-bottom:.5rem;color:var(--paper)">
        Built Secure.<br>By Default.
    </h2>
    <div class="security-grid">
        <div class="sec-item">
            <div class="sec-title">CSRF Protection</div>
            <div class="sec-desc">Token on every POST form. Enforced globally via CI4 Filters. Validated before any controller runs.</div>
        </div>
        <div class="sec-item">
            <div class="sec-title">XSS Prevention</div>
            <div class="sec-desc">All output escaped with esc(). All input sanitized with FILTER_SANITIZE_* before processing.</div>
        </div>
        <div class="sec-item">
            <div class="sec-title">Bcrypt Hashing</div>
            <div class="sec-desc">Passwords hashed at cost-12. Verified with password_verify() on login. Never stored plain.</div>
        </div>
        <div class="sec-item">
            <div class="sec-title">SQL Injection Safe</div>
            <div class="sec-desc">CI4 Query Builder with parameterized queries throughout. No raw SQL string concatenation.</div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     CTA
     ══════════════════════════════════════════ -->
<section class="cta-section">
    <div class="cta-bg">LOGIN</div>
    <div class="cta-inner">
        <h2 class="cta-title">Ready to<br><em>Get Started?</em></h2>
        <p class="cta-sub">Import the database, run composer install, and you're live in under 3 commands.</p>
        <div class="cta-actions">
            <a href="/login" class="btn-primary">→ Go to Login</a>
            <a href="/api/stats" class="btn-secondary">View API Stats</a>
        </div>
        <p class="cta-note">php spark serve · http://localhost:8080</p>
    </div>
</section>

<!-- ══════════════════════════════════════════
     FOOTER
     ══════════════════════════════════════════ -->
<footer>
    <div class="footer-logo">Student<span>Sys</span></div>
    <div class="footer-meta">Terminal Assessment 2 · CodeIgniter 4 · PHP 8.2</div>
    <div class="footer-links">
        <a href="/login">Login</a>
        <a href="/api/students">API</a>
        <a href="/admin/dashboard">Dashboard</a>
    </div>
</footer>

<!-- Page Script (must come after GSAP scripts in <head>) -->
<script src="js/landing.js"></script>

</body>
</html>