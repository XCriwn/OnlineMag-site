<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

<!-- TODO not notes but product, we will show a list of 10 products and some filters, with arrows to see more pages -->
<style>
    .filter-group {
        margin-bottom: 1rem;
    }

    .filter-group label,
    .filter-group input,
    .filter-group select {
        display: inline-block;
        vertical-align: middle;
    }
    .filter-group input,
    .filter-group select {
        margin-left: 10px;
    }

    .small-input {
        width: 90px; /* Adjust the width to be smaller */
        height: 30px;
    }
</style>
    <main>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <button id="toggle-filters" class="rounded-md bg-blue-600 ml-5 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Display Filters</button>
            <div id="filter_form" style="display: none;">
                <form action="/products" method="post">

                    <h3>Filter by: </h3>
                    <div class="filter-group">
                        <label for="filter_name" class="block text-sm font-medium leading-6 text-gray-900">Name:</label>
                        <input name="filter_name" id="filter_name" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_name") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_price_min" class="block text-sm font-medium leading-6 text-gray-900">Min Price:</label>
                        <input name="filter_price_min" id="filter_price_min" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_price_min") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_price_max" class="block text-sm font-medium leading-6 text-gray-900">Max Price:</label>
                        <input name="filter_price_max" id="filter_price_max" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_price_max") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_category" class="block text-sm font-medium leading-6 text-gray-900">Category:</label>
                        <select id="filter_category" name="filter_category" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <option value="0">None</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $category['id'] == \core\Session::getArrayKey("old_post", "filter_category") ? 'selected' : '' ?>><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                        >Submit
                        </button>
                    </div>

                </form>
                <form action="/products" method = "post">
                    <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                    >Clear all filters
                    </button>
                </form>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <ul><hr><br>
            <?php foreach ($products as $product):?>
                <li>Name:
                    <a href="/product?id=<?= $product['id']?>" class="text-red-300 hover:underline">
                    <?= htmlspecialchars($product['name'])?>
                    </a>
                </li>
                <img src="<?= getImage($product['image']); ?>" alt="Something went wrong." height="100px" width="100px">

                <li>Description: <?= htmlspecialchars($product['description'])?></li>
                <li>Price: <?= htmlspecialchars($product['price'])?>$</li>
                <li>Categories: <?= isset($product['category_names']) ? htmlspecialchars($product['category_names']) : "None"?></li>

                <li>
                    <a href="/product?id=<?= $product['id']?>" class="text-red-300 hover:underline">
                        See more...
                    </a>
                </li>
                <?php if(getCurrentUserRole() === 'admin') :?>
                    <footer class="mt-6">
                        <a href="product/edit?id=<?= $product['id'] ?>" class="text-green-300 text-xs mt-6 border border-current rounded px-4 py-2">Edit</a>
                    </footer>
                <?php endif; ?>
                <br><hr><br>
            <?php endforeach; ?>
            </ul>
            <p class="mt-6">
                <?php if(getCurrentUserRole() === 'admin') :?>
                <a href="product/create" class="text-red-100 hover:underline">Add new product</a>
                <?php endif; ?>
            </p>
        </div>
    </main>

<?php view('partials/footer.php') ?>

<script>
    document.getElementById('toggle-filters').addEventListener('click', function() {
        var filterForm = document.getElementById('filter_form');
        if (filterForm.style.display === 'none') {
            filterForm.style.display = 'block';
        } else {
            filterForm.style.display = 'none';
        }
    });
</script>
