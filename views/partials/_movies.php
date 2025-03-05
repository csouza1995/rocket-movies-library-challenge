<?php if (empty($movies)) : ?>
    <div class="col-span-full text-center text-gray-400">
        <i class='bx bx-movie-play text-6xl mb-6'></i>

        <p class="font-body text-xl text-gray-500">
            No one movie found
            <br>
            How about another search?
        </p>

        <button
            type="button"
            class="px-4 py-2 hover:text-purple-light flex items-center mx-auto mt-4 rounded-lg"
            x-on:click="clearSearch">
            <i class='bx bx-x text-3xl'></i>
            <span class="ml-2 text-lg">
                Clear search
            </span>
        </button>
    </div>
<?php else: ?>
    <?php foreach ($movies as $movie) : ?>
        <div class="flex flex-col bg-gray-100 border border-transparent rounded-lg overflow-hidden relative h-[450px] relative hover:border-gray-700 hover:opacity-70 cursor-pointer">

            <!-- image -->
            <div class="absolute opacity-50 top-0 left-0 w-full h-full">
                <img src="<?= $movie->getImage(); ?>" alt="<?= $movie->title; ?>" class="w-full h-full object-cover">
            </div>

            <!-- actions -->
            <?php if ($form_control ?? false) : ?>
                <a class="top-2 left-2 px-2 py-1 rounded-full absolute flex items-center space-x-1 text-white hover:bg-purple-light" href="/movies-form?id=<?= $movie->id; ?>">
                    <i class='bx bxs-edit text-xl'></i>
                </a>
            <?php else : ?>
                <form method="post" action="/my-favorites">
                    <input type="hidden" name="movie_id" value="<?= $movie->id; ?>">

                    <?php if ($movie->is_my_movie) : ?>
                        <!-- remove -->
                        <input type="hidden" name="action" value="remove">
                        <button class="top-2 left-2 px-2 py-1 rounded-full absolute flex items-center space-x-1 text-red-500 hover:text-gray-600 border border-transparent hover:border-gray-600">
                            <i class='bx bxs-heart text-xl'></i>
                        </button>
                    <?php else : ?>
                        <!-- add -->
                        <input type="hidden" name="action" value="add">
                        <button class="top-2 left-2 px-2 py-1 rounded-full absolute flex items-center space-x-1 text-gray-600 hover:text-red-500 border border-transparent hover:border-red-500">
                            <i class='bx bxs-heart text-xl'></i>
                        </button>
                    <?php endif; ?>
                </form>
            <?php endif; ?>

            <!-- rating -->
            <div class="bg-rating top-2 right-2 px-2 py-1 rounded-full absolute flex items-center space-x-1 text-white">
                <!-- raiting -->
                <div class="font-bold text-lg mr-1">
                    <span>
                        <?= number_format($movie->rating, 1); ?>
                    </span>
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