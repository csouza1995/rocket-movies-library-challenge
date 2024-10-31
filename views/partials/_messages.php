<div class="relative">
    <?php if ($successMessage = Session::get('message::success')) : ?>
        <div class="bg-green-700 text-green-200 p-4 rounded-md mb-5 absolute w-full" x-data="{ show: true }" x-show="show">
            <?= $successMessage ?>

            <button x-on:click="show = false"
                class="right-0 top-0 hover:bg-green-800 rounded-md float-right">
                <i class='bx bx-x'></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage = Session::get('message::error')) : ?>
        <div class="bg-red-700 text-red-200 p-4 rounded-md mb-5 absolute w-full" x-data="{ show: true }" x-show="show">
            <?= $errorMessage ?>

            <button x-on:click="show = false"
                class="right-0 top-0 hover:bg-red-800 rounded-md float-right">
                <i class='bx bx-x'></i>
            </button>
        </div>
    <?php endif; ?>
</div>