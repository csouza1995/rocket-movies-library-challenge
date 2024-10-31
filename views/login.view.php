<div class="w-full h-full" x-data="{ form: '<?= $_GET['type'] ?? 'login' ?>' }">
    <div class="mx-auto flex justify-center h-full w-1/2 mt-40">
        <div class="w-full">
            <!-- buttons toggle form -->
            <div class="flex bg-gray-200 p-1 rounded-lg mb-20">
                <button
                    class="px-4 py-4 rounded-lg text-gray-500 hover:text-purple-light w-1/2"
                    :class="{ 'bg-gray-300 text-purple-light': form === 'login' }"
                    x-on:click="form = 'login'">
                    Login
                </button>
                <button
                    class="px-4 py-4 rounded-lg text-gray-500 hover:text-purple-light w-1/2"
                    :class="{ 'bg-gray-300 text-purple-light': form === 'register' }"
                    x-on:click="form = 'register'">
                    Register
                </button>
            </div>

            <!-- forms -->
            <form action="/login" method="post" x-show="form == 'login'" class="w-full">
                <h2 class="font-display text-3xl font-bold mt-4">
                    Access your account
                </h2>

                <div class="my-10 space-y-4">
                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1">
                        <i class='bx bx-envelope text-xl'></i>

                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="Your email"
                            class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500"
                            value="<?= old('email') ?>">
                    </div>
                    <?php if ($error = error('email')) : ?>
                        <div class="text-error-base text-xs"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1">
                        <i class='bx bxs-key text-xl'></i>

                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="Your password"
                            class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500"
                            value="<?= old('password') ?>">
                    </div>
                    <?php if ($error = error('password')) : ?>
                        <div class="text-error-base text-xs"><?= $error ?></div>
                    <?php endif; ?>
                </div>

                <button class="w-full bg-purple-base text-white rounded-lg py-4">
                    Login
                </button>
            </form>

            <!-- forms -->
            <form action="/register" method="post" x-show="form == 'register'" class="w-full">
                <h2 class="font-display text-3xl font-bold mt-4">
                    Create your account
                </h2>

                <div class="my-10 space-y-4">
                    <div class="grid grid-cols-2 gap-0">
                        <div class="flex items-center text-gray-500 border border-gray-400 rounded-l-lg px-4 py-1">
                            <i class='bx bx-user text-xl'></i>

                            <input
                                type="text"
                                name="name"
                                required
                                placeholder="Your Name"
                                class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"
                                value="<?= old('name') ?>">
                        </div>
                        <?php if ($error = error('name')) : ?>
                            <div class="text-error-base text-xs"><?= $error ?></div>
                        <?php endif; ?>

                        <div class="flex items-center text-gray-500 border border-gray-400 rounded-r-lg px-4 py-1">
                            <input
                                type="text"
                                name="surname"
                                required
                                placeholder="and Surname"
                                class="py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"
                                value="<?= old('surname') ?>">
                        </div>
                        <?php if ($error = error('surname')) : ?>
                            <div class="text-error-base text-xs"><?= $error ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1">
                        <i class='bx bx-envelope text-xl'></i>

                        <input
                            type="email"
                            name="register_email"
                            required
                            placeholder="Your email"
                            class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500"
                            value="<?= old('register_email') ?>">
                    </div>
                    <?php if ($error = error('register_email')) : ?>
                        <div class="text-error-base text-xs"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1">
                        <i class='bx bx-check-double text-xl'></i>

                        <input
                            type="email"
                            name="register_email_confirm"
                            required
                            placeholder="Confirm your email"
                            class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500"
                            value="<?= old('register_email_confirm') ?>">
                    </div>
                    <?php if ($error = error('register_email_confirm')) : ?>
                        <div class="text-error-base text-xs"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1">
                        <i class='bx bxs-key text-xl'></i>

                        <input
                            type="password"
                            name="register_password"
                            required
                            placeholder="Your password"
                            class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500">
                    </div>
                    <?php if ($error = error('register_password')) : ?>
                        <div class="text-error-base text-xs"><?= $error ?></div>
                    <?php endif; ?>
                </div>

                <button class="w-full bg-purple-base text-white rounded-lg py-4">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>