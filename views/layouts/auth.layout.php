<div class="grid grid-cols-1 md:grid-cols-2 h-screen text-gray-600 p-4 gap-4">
    <!-- image-side -->
    <div class="relative h-full font-display">
        <img src="assets/images/login.png" alt="login" class="h-full absolute">

        <a href="/" class="size-20 flex items-center absolute top-10 left-10 right-10">
            <?php include ROOT . '/views/partials/_logo.php'; ?>
        </a>

        <div class="text-4xl absolute bottom-10 left-10 right-10">
            <p class="text-gray-500 text-2xl">
                ab movies
            </p>

            <p class="mt-4">
                The ultimate guide for <br>
                movie lovers
            </p>
        </div>
    </div>

    <!-- form-side -->
    <main>
        <!-- messages -->
        <?php require ROOT . "/views/partials/_messages.php"; ?>

        <!-- content -->
        <?php require ROOT . "/views/{$view}.view.php"; ?>
    </main>
</div>