<div
    x-data="{ 
        search: '<?= $_GET['search'] ?? '' ?>', 
        clearSearch: () => { this.search = ''; location.href = '/my-movies' }
    }">
    <section class="flex justify-between items-center text-gray-600 my-20 w-full">
        <!-- title -->
        <h1 class="font-display text-4xl">
            My Movies
        </h1>

        <!-- search -->
        <form method="get" action="/my-movies" class="flex items-center">
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
                    x-on:click="clearSearch"
                    type="button"
                    class="hover:text-purple-light flex items-center rounded-lg">
                    <i class='bx bxs-x-circle text-2xl'></i>
                </button>
            </div>

            <!-- create -->
            <a href="/movies-form" class="flex items-center bg-purple-base text-white font-semibold rounded-lg px-4 py-2 ml-4 hover:bg-purple-light">
                <i class='bx bx-plus text-xl mr-2'></i>
                Add Movie
            </a>
        </form>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php include ROOT . '/views/partials/_movies.php'; ?>
    </section>
</div>