<!DOCTYPE html>
<html class="light" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'SMK Tri Bhakti Al Husna')); ?></title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    
    <!-- Scripts & Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] bg-primary-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[20%] h-[20%] bg-secondary-600/10 rounded-full blur-[120px]"></div>
    </div>

    <!-- Main Login Canvas -->
    <main class="relative z-10 w-full max-w-[1200px] flex flex-col md:flex-row items-center justify-center px-6 py-10">
        <!-- Left Side: Brand Narrative (Hidden on Mobile) -->
        <div class="hidden md:flex flex-col w-1/2 pr-12 space-y-6">
            <div class="inline-flex items-center space-x-2 bg-primary-600/10 px-4 py-2 rounded-full w-fit">
                <span class="material-symbols-outlined text-primary-600">school</span>
                <span class="font-medium text-sm text-primary-600">Sistem Akademik Terpadu</span>
            </div>
            <h1 class="text-5xl font-bold text-gray-900 leading-tight">
                Membangun Masa Depan <br/>
                <span class="text-primary-600">Unggul & Berkarakter</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-[440px]">
                Selamat datang kembali di portal resmi SMK Tri Bhakti Al Husna. Silakan masuk untuk mengakses layanan akademik dan manajemen sekolah Anda.
            </p>
        </div>

        <!-- Right Side: Content Injection -->
        <div class="w-full md:w-[460px] glass-panel rounded-[32px] p-10 shadow-lg border border-white/50">
            <?php echo e($slot); ?>

        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="absolute bottom-0 w-full py-4 px-6 flex flex-col md:flex-row justify-between items-center text-gray-500 z-10">
        <p class="text-sm">© 2024 SMK Tri Bhakti Al Husna - Integrated Academic Service System</p>
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/layouts/guest.blade.php ENDPATH**/ ?>