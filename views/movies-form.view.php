<div x-data="{
    image: '<?= $movie->poster ? $movie->getImage() : '' ?>' ,
    loadFile(e) {
        const $vm = this;
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onloadend = () => {
            $vm.image = reader.result;
        }

        reader.readAsDataURL(file);
    },
}">
    <form method="post" action="/movies-form" class="grid grid-cols-1 md:grid-cols-3 gap-10 text-gray-700" enctype="multipart/form-data">
        <?php if ($movie->id) : ?>
            <input type="hidden" name="id" value="<?= $movie->id ?>">
        <?php else : ?>
            <input type="hidden" name="id" value="<?= old('id') ?>">
        <?php endif; ?>

        <!-- grid 1/3 -->
        <div class="col-span-1">
            <input type="file" name="poster" class="hidden" accept="image/*" x-ref="poster" x-on:change="loadFile" />

            <div
                class="bg-gray-300 flex items-center justify-center h-[600px] w-full rounded-3xl text-purple-base hover:bg-gray-400 hover:text-purple-light cursor-pointer parent-hover"
                x-on:click="$refs.poster.click()">

                <img :src="image" x-show="image" class="h-full rounded-3xl opacity-50" style="overflow: hidden; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.5); min-width: 100%;" />

                <div class="show-parent-hover text-center grid absolute" :class="{ 'hidden': image }">
                    <i class="bx bx-upload text-6xl"></i>
                    <span class="text-lg mt-4 text-gray-500">
                        Upload your movie poster
                    </span>
                </div>
            </div>
        </div>

        <!-- grid 2/3 -->
        <div class="col-span-1 md:col-span-2">
            <p class="font-title text-2xl font-bold mb-6">
                Movie information
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg pl-4 pr-1 py-1">
                        <i class='bx bx-movie-play text-xl'></i>

                        <input
                            type="text"
                            name="title"
                            required
                            placeholder="Your movie title"
                            class="pl-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"
                            value="<?= old('title', $movie->title ?? '') ?>">
                    </div>
                    <?php if ($error = error('title')) : ?>
                        <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1">
                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg pl-4 pr-1 py-1">
                        <i class='bx bx-calendar-alt text-xl'></i>

                        <input
                            type="number"
                            name="year"
                            required
                            placeholder="Year"
                            class="pl-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"
                            min="1900"
                            max="<?= date('Y') ?>"
                            value="<?= old('year', $movie->year ?? date('Y')) ?>">
                    </div>
                    <?php if ($error = error('year')) : ?>
                        <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1">
                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg pl-4 pr-1 py-1">
                        <i class='bx bxs-purchase-tag text-xl'></i>

                        <input
                            type="text"
                            name="genre"
                            required
                            placeholder="Genre"
                            class="pl-4 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"
                            value="<?= old('genre', $movie->genre ?? '') ?>">
                    </div>
                    <?php if ($error = error('genre')) : ?>
                        <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center text-gray-500 border border-gray-400 rounded-lg pl-4 pr-1 py-1">
                        <textarea
                            name="description"
                            placeholder="Description"
                            rows="10"
                            class="px-0 py-2 rounded-lg bg-gray-100 focus:outline-none placeholder-gray-500 w-full"><?= old('description', $movie->description ?? '') ?></textarea>
                    </div>
                    <?php if ($error = error('description')) : ?>
                        <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button
                    type="button"
                    x-on:click="window.history.back()"
                    class="text-gray-500 hover:text-purple-light text-sm px-4 py-2 rounded-lg mt-6 mr-4">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="bg-purple-base hover:bg-purple-light text-white px-4 py-2 rounded-lg mt-6">
                    Confirm
                </button>
            </div>
        </div>
    </form>
</div>