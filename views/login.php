<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PuspusPerpus</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Bootstrap Grid only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css" rel="stylesheet">
    <!-- Custom styling system -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* Extra styles to ensure login is completely centered and has GSAP start opacity */
        #login-card {
            opacity: 0;
            transform: translateY(20px);
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card" id="login-card">
        <div class="auth-header">
            <!-- App Logo / Icon -->
            <div style="color: var(--primary); margin-bottom: 12px; display: inline-block;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 42px; height: 42px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            <h1 class="auth-title">PuspusPerpus</h1>
            <p class="auth-subtitle">Masuk untuk mengelola data perpustakaan</p>
        </div>

        <!-- Alert messages (e.g. database error, login failed, success redirect) -->
        <?php if (hasFlash('success')): ?>
            <?php $flash = getFlash('success'); ?>
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo $flash['message']; ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($errors['auth'])): ?>
            <div class="alert alert-danger" id="auth-alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span><?php echo $errors['auth']; ?></span>
            </div>
        <?php endif; ?>

        <form action="index.php?route=login" method="POST" id="login-form" novalidate>
            <!-- CSRF Token protection field -->
            <?php echo csrfField(); ?>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                    placeholder="nama@domain.com"
                    value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                    autocomplete="email"
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top: 12px;">
                <span>Masuk Sekarang</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 16px; height: 16px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Load GSAP Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<!-- Load App Scripts -->
<script src="assets/js/main.js"></script>

<script>
    // Smooth card slide-in entrance
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof gsap !== 'undefined') {
            gsap.to("#login-card", {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: "power3.out"
            });
            
            // Shake auth alert if login fails
            const alertBox = document.getElementById('auth-alert');
            if (alertBox) {
                gsap.fromTo(alertBox, {x: -8}, {x: 8, duration: 0.06, repeat: 5, yoyo: true, ease: "sine.inOut", onComplete: () => {
                    alertBox.style.transform = 'none';
                }});
            }
        }
    });
</script>

</body>
</html>
