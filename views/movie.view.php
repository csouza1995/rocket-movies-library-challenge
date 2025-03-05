<div x-data="{
    open: '<?= isset($_GET['modal']) ? ($_GET['modal'] ? 'true' : 'false') : 'false'; ?>' === 'true',
    rating_id: null,
    rating: 0,
    description: '',
    preRating: 0,
    deleteRequired: 0,
    deleteInterval: null,
    method: 'POST',
    clear() {
        this.rating_id = null;
        this.rating = 0;
        this.description = '';
        this.preRating = 0;
    },
    newReview() {
        this.clear();
        this.rating_id = null;
        this.open = true;
    },
    editReview(id, rating, description) {
        this.clear();
        this.rating_id = id;

        this.rating = rating;
        this.description = description;

        this.open = true;
    },
    deleteReview() {
        if (this.deleteRequired == 0) {
            this.deleteRequired = 10;

            this.deleteInterval = setInterval(() => {
                this.deleteRequired--;

                if (this.deleteRequired == 0) {
                    clearInterval(this.deleteInterval);
                }
            }, 1000);

            return;
        } else {
            this.method = 'DELETE';

            this.$nextTick(() => {
                this.$refs.form.submit();
            });
        }
    },
}">
    <section class="grid grid-cols-1 md:grid-cols-3 gap-10 text-gray-700 mb-32">
        <!-- grid 1/3 -->
        <div class="col-span-1">
            <div class="bg-gray-300 flex items-center justify-center h-[600px] w-full rounded-3xl text-purple-base">
                <img src="<?= $movie->getImage() ?>" class="h-full rounded-3xl" style="overflow: hidden; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.5); min-width: 100%;" />
            </div>
        </div>

        <!-- grid 2/3 -->
        <div class="col-span-1 md:col-span-2 text-gray-600">
            <button
                type="button"
                x-on:click="window.history.back()"
                class="text-gray-500 hover:text-purple-light text-sm py-2 rounded-lg mr-4 flex items-center space-x-2">
                <i class='bx bx-arrow-back text-xl'></i>
                <span class="text-lg">
                    Back
                </span>
            </button>

            <p class="font-title text-4xl font-bold my-6 text-gray-700">
                <?= $movie->title; ?>
            </p>

            <p class="text-lg">
                <strong>Genre:</strong> <?= $movie->genre; ?>
                <br>
                <strong>Year:</strong> <?= $movie->year; ?>
            </p>

            <p class="text-2xl mt-6">
                <?php for ($i = 0; $i < floor($movie->rating); $i++) : ?>
                    <i class='bx bxs-star text-purple-light'></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - floor($movie->rating); $i++) : ?>
                    <i class='bx bx-star text-purple-light'></i>
                <?php endfor; ?>

                <strong class="text-gray-600 ml-2">
                    <?= number_format($movie->rating, 1); ?>
                </strong>

                <span class="text-gray-600 text-lg">
                    (<?= $movie->review_count; ?> reviews)
                </span>
            </p>

            <p class="mt-16">
                <?= $movie->description; ?>
            </p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-10 text-gray-700">
        <div class="flex items-center justify-between">
            <p class="font-title text-2xl font-bold text-gray-700">
                Reviews
            </p>

            <button
                type="button"
                x-on:click="newReview"
                class="bg-purple-base hover:bg-purple-light text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                <i class='bx bx-star text-xl'></i>
                <span class="ml-2 text-lg">
                    Rate movie
                </span>
            </button>
        </div>

        <?php if (empty($reviews)) : ?>
            <div class="flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <i class='bx bx-message-square-x text-6xl'></i>
                    <p class="text-lg mt-4">
                        No reviews yet
                        <br>
                        How about sending the first comment?
                    </p>
                </div>
            </div>
        <?php else : ?>
            <div class="space-y-4">
                <?php foreach ($reviews as $review) : ?>
                    <div class="block md:flex bg-gray-200 p-6 rounded-lg">
                        <div class="w-full md:w-3/12 flex border-r border-gray-300 pr-4">
                            <img src="https://placehold.co/30x30" alt="avatar" class="size-14 rounded">

                            <div class="ml-4">
                                <p class="font-bold text-lg">
                                    <?= $review->user_name; ?>
                                    <?php if ($review->user_id == auth()->id) : ?>
                                        <span class="bg-purple-light text-white px-2 py-0 rounded-lg text-xs ml-1">
                                            You
                                        </span>
                                    <?php endif; ?>
                                </p>
                                <p class="text-gray-500 text-sm font-title">
                                    <?= $review->user_review_count; ?> movies rated
                                </p>

                                <?php if ($review->user_id == auth()->id) : ?>
                                    <button type="button" class="text-gray-500 hover:text-purple-light mt-2 flex items-center space-x-2" x-on:click="editReview(<?= $review->id; ?>, '<?= $review->rating; ?>', '<?= $review->description; ?>')">
                                        <i class="bx bx-edit"></i>
                                        <span>Edit</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="w-full md:w-8/12 pl-8 my-4 md:my-0 text-justify text-gray-500">
                            <?= $review->description; ?>
                        </div>
                        <div class="w-full md:w-1/12 text-center">
                            <div class="bg-gray-300 px-2 py-1 rounded-lg flex items-center justify-center text-white">
                                <!-- raiting -->
                                <div class="font-bold text-lg mr-1">
                                    <span>
                                        <?= number_format($review->rating, 0); ?>
                                    </span>
                                    <span class="text-gray-600 text-xs">/5</span>
                                </div>

                                <i class='bx bxs-star text-xl text-purple-light'></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- modal review -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <form method="POST" action="/review" class="bg-gray-100 rounded-2xl p-8 w-full md:w-2/6 space-y-6" x-on:click.away="open = false" x-ref="form">
            <input type="hidden" name="movie_id" value="<?= $movie->id; ?>">
            <input type="hidden" name="rating" x-model="rating" value="<?= old('rating') ?>">
            <input type="hidden" name="id" x-model="rating_id" value="<?= old('id') ?>">
            <input type="hidden" name="_method" x-model="method" value="POST">

            <div class="flex items-center justify-between">
                <p class="font-title text-xl font-bold text-gray-700">
                    Rate movie
                </p>
                <button
                    type="button"
                    x-on:click="open = false"
                    class="text-gray-500 bg-gray-300 hover:bg-gray-400 px-2 py-1 rounded-lg flex items-center space-x-2">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>

            <div class="flex space-x-6 space-y-0">
                <div class="w-1/4">
                    <div class="bg-gray-300 flex items-center justify-center h-[200px] w-full rounded-3xl text-purple-base">
                        <img src="<?= $movie->getImage() ?>" class="h-full rounded-3xl" style="overflow: hidden; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.5); min-width: 100%;" />
                    </div>
                </div>

                <div class="w-3/4 text-gray-700">
                    <p class="font-title text-2xl font-bold mb-6">
                        <?= $movie->title; ?>
                    </p>

                    <p class="">
                        <strong>Genre:</strong> <?= $movie->genre; ?>
                        <br>
                        <strong>Year:</strong> <?= $movie->year; ?>
                    </p>

                    <p class="mt-6">
                        Your rating:
                    </p>

                    <p class="text-4xl">
                        <template x-for="i in 5" :key="i">
                            <i
                                x-on:click="rating = i"
                                x-on:mouseover="preRating = i"
                                x-on:mouseleave="preRating = 0"
                                :class="{ 'bx bxs-star text-purple-light': i <= rating, 'bx bx-star text-purple-light': i > rating, 'bx bxs-star text-purple-light opacity-50': i <= preRating }"
                                class="cursor-pointer hover:text-purple-light pr-2">
                            </i>
                        </template>
                    </p>

                    <?php if ($error = error('rating')) : ?>
                        <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="w-full">
                <textarea
                    x-model="description"
                    name="description" s
                    class="w-full h-32 bg-gray-200 rounded-lg p-4 text-gray-700 border border-gray-300"
                    placeholder="Write your review here..."><?= old('description') ?></textarea>

                <?php if ($error = error('description')) : ?>
                    <div class="text-error-base text-xs mt-2"><?= $error ?></div>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <!-- delete -->
                <button
                    type="button"
                    class="flex items-center space-x-2 rounded-lg text-gray-500 hover:text-red-500 px-4 py-2"
                    x-on:click="deleteReview"
                    :disabled="!rating_id"
                    :class="{'text-gray-500 hover:text-red-500': rating_id && deleteRequired == 0, 'text-gray-200': !rating_id, 'bg-red-500 text-white': deleteRequired > 0}">
                    <i class="bx bx-trash"></i>
                    <span class="text-lg" x-show="deleteRequired == 0">
                        Delete review
                    </span>
                    <span class="text-lg" x-show="deleteRequired > 0">
                        Confirm deletion
                    </span>
                    <strong x-show="deleteRequired > 0" x-text="deleteRequired" class="text-xs text-white px-2 py-0 ml-2"></strong>
                </button>

                <!-- submit -->
                <button type="submit" class="bg-purple-base hover:bg-purple-light text-white px-4 py-2 rounded-lg flex items-center space-x-2 float-right">
                    <i class="bx bx-star"></i>
                    <span class="ml-2 text-lg">
                        Rate movie
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>