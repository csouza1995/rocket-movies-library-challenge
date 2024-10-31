<header class="text-white h-20 px-6 py-2">
    <nav class="flex items-center justify-between">
        <a href="/" class="size-20 flex items-center space-x-2">
            <?php include ROOT . '/views/partials/_logo.php'; ?>
        </a>

        <div class="flex items-center space-x-4 font-body text-gray-500">
            <a href="/" class="flex items-center px-4 py-2 rounded-lg hover:text-purple-light hover:bg-gray-300 <?= $route == 'index' ? 'bg-gray-300 text-purple-light' : ''; ?>">
                <i class='bx bx-grid-alt text-xl mr-2'></i>
                Explorer
            </a>
            <a href="/my-movies" class="flex items-center px-4 py-2 rounded-lg hover:text-purple-light hover:bg-gray-300 <?= $route === '/my-movies' ? 'bg-gray-300 text-purple-light' : ''; ?>">
                <i class='bx bx-movie-play text-xl mr-2'></i>
                My Movies
            </a>
        </div>

        <div class="flex items-center space-x-4 font-body text-gray-600">
            <?php if (auth()) : ?>
                <!-- user name and profile -->
                <div class="flex items-center space-x-4">
                    <span>
                        Olá, <?= auth()->fullname(); ?>
                    </span>
                    <img src="<?= auth()->avatar(); ?>" alt="avatar" class="size-10 rounded ml-2">
                </div>

                <!-- divider -->
                <div class="border-r border-gray-300 h-10"></div>

                <!-- logout -->
                <a href="/logout" class="px-4 py-2 rounded-lg bg-gray-300 hover:text-purple-light">
                    <i class='bx bx-log-out text-xl rotate-180'></i>
                </a>
            <?php else : ?>
                <a href="/login" class="px-4 py-2 rounded-lg bg-gray-300 hover:text-purple-light">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="mx-auto max-w-screen-2xl space-y-10 px-6 pt-10">
    <!-- messages -->
    <?php require ROOT . "/views/partials/_messages.php"; ?>

    <!-- content -->
    <?php require ROOT . "/views/{$view}.view.php"; ?>
</main>