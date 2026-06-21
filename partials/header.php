<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - PuspusPerpus' : 'PuspusPerpus'; ?></title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Bootstrap Grid only (Layout utilities) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css" rel="stylesheet">
    
    <!-- Custom shadcn/ui inspired CSS System -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <!-- Sidebar navigation -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>
    
    <!-- Main content container wrapper -->
    <div class="app-content">
        <!-- Top Navbar -->
        <?php require_once __DIR__ . '/navbar.php'; ?>
        
        <!-- Main content injection point -->
        <main class="main-container">
