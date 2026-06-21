<?php
/**
 * Top Navbar Partial for PuspusPerpus
 */
?>
<header class="app-navbar">
    <!-- Mobile Hamburger Menu Button -->
    <button class="sidebar-toggle" aria-label="Toggle Menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 24px; height: 24px;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
    
    <!-- Title context or Left Nav Elements -->
    <div class="nav-left">
        <!-- Kept clean and uncluttered -->
    </div>
    
    <!-- Right side items (Date & Time display) -->
    <div class="nav-right">
        <span style="font-size: 13px; color: var(--muted-foreground);">
            Hari ini: <strong style="color: var(--primary);"><?php echo date('d F Y'); ?></strong>
        </span>
    </div>
</header>
