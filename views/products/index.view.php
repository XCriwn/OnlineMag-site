<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>
<?php //view(null, [], 'products/index.view.css') ?>

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
    /*todo we might put these into a separate stylesheet, loaded at start, for all pages to use*/
    .small-input {
        width: 90px; /* Adjust the width to be smaller */
        height: 30px;
    }

    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Adjust the gap between products as needed */
    }

    .product-item {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center align items horizontally */
        justify-content: center; /* Center align items vertically */
        flex: 1 1 calc(25% - 20px);
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    .product-item img {
        width: 250px;
        height: 250px;
    }

</style>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <button id="toggle-filters" class="rounded-md bg-blue-600 ml-5 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Display Filters</button>
            <div id="filter_form" style="display: none;">
                <form action="/products" method="post">

                    <h3>Filter by: </h3>
                    <div class="filter-group">
                        <label for="filter_name" class="block text-sm font-medium leading-6">Name:</label>
                        <input name="filter_name" id="filter_name" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_name") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_price_min" class="block text-sm font-medium leading-6">Min Price:</label>
                        <input name="filter_price_min" id="filter_price_min" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_price_min") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_price_max" class="block text-sm font-medium leading-6">Max Price:</label>
                        <input name="filter_price_max" id="filter_price_max" type="text" value="<?= \core\Session::getArrayKey("old_post", "filter_price_max") ?>" class="small-input">
                    </div>
                    <div class="filter-group">
                        <label for="filter_category" class="block text-sm font-medium leading-6">Category:</label>
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
            <div><br>
                <?php if(\core\Session::get("index_products_filter") === 1) : ?>
                <p>Now sorting by: <?php foreach($categories as $category): if($category['id'] == \core\Session::getArrayKey("old_post", "filter_category")) :?> <?= $category['name'] ?> <?php endif; endforeach;?> </p>
                <?php else : ?>
                <p>No category sorting filters active.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="mt-6">
                <?php if(getCurrentUserRole() === 'admin') :?>
                    <a href="product/create" class="text-red-100 hover:underline">Add new product</a>
                <?php endif; ?>
            </p>
            <br><hr><br>
            <ul class="product-list">
                <?php foreach ($products as $product): ?>
                    <li class="product-item">
                        <img src="<?= getImage($product['image']); ?>" alt="Something went wrong."> <br>
                        <h3>Name: <a href="/product?id=<?= $product['id'] ?>" class="text-red-300 hover:underline"><?= htmlspecialchars($product['name']) ?></a></h3>
                        <h4>Price: <?= htmlspecialchars($product['price']) ?>$</h4>
                        <a href="/product?id=<?= $product['id'] ?>" class="text-red-300 hover:underline">See more...</a>
                        <?php if (getCurrentUserRole() === 'admin') : ?>
                            <footer class="mt-6">
                                <a href="product/edit?id=<?= $product['id'] ?>" class="text-green-300 text-xs mt-6 border border-current rounded px-4 py-2">Edit</a>
                            </footer>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
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
