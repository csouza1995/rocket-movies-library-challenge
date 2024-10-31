<section class="flex justify-between items-center text-gray-600 my-20 w-full">
    <!-- titlw -->
    <h1 class="font-display text-4xl">
        Explorer
    </h1>

    <!-- search -->
    <form method="get" action="/" x-data="{ search: '<?= $_GET['search'] ?? '' ?>' }">
        <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg px-4 py-1 w-[500px] max-w-full">
            <i class='bx bx-search text-xl'></i>

            <input
                type="text"
                name="search"
                x-model="search"
                placeholder="Search for movies, press enter to confirm"
                class="px-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full">

            <!-- clear -->
            <button
                x-show="search.length > 0"
                x-on:click="search = ''"
                type="button"
                class="hover:text-purple-light flex items-center rounded-lg">
                <i class='bx bxs-x-circle text-2xl'></i>
            </button>
        </div>
    </form>
</section>

<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <?php if (empty($movies)) : ?>
        <div class="col-span-full text-center text-gray-400">
            <i class='bx bx-movie-play text-6xl mb-6'></i>

            <p class="font-body text-xl text-gray-500">
                No one movie found
                <br>
                How about another search?
            </p>

            <button class="px-4 py-2 hover:text-purple-light flex items-center mx-auto mt-4 rounded-lg">
                <i class='bx bx-x text-3xl'></i>
                <span class="ml-2 text-lg">
                    Clear search
                </span>
            </button>
        </div>
    <?php else: ?>
        <?php foreach ($movies as $movie) : ?>
            <div class="flex flex-col bg-gray-100 border border-transparent rounded-lg overflow-hidden relative h-[450px] relative hover:border-gray-700 hover:opacity-70 hover:scale-110 cursor-pointer">

                <!-- image -->
                <div class="absolute opacity-50 top-0 left-0 w-full h-full">
                    <img src="<?= $movie->poster; ?>" alt="<?= $movie->title; ?>" class="w-full h-full object-cover">
                </div>

                <!-- rating -->
                <div class="bg-rating top-2 right-2 px-2 py-1 rounded-full absolute flex items-center space-x-1 text-white">
                    <!-- raiting -->
                    <div class="font-bold text-lg mr-1">
                        <span>4,5</span>
                        <span class="text-gray-600 text-xs">/5</span>
                    </div>

                    <i class='bx bxs-star text-xl'></i>
                </div>

                <!-- title and year -->
                <div class="container bottom-2 left-2 absolute">
                    <h3 class="font-title text-lg text-white">
                        <?= $movie->title; ?>
                    </h3>

                    <!-- year -->
                    <span class="text-gray-700">
                        <?= $movie->genre; ?> • <?= $movie->year; ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>