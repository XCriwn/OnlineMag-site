<!--//todo write here code to display all products currently in the cart-->
<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

<!--TODO product stuff-->
<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <button id="toggle-filters" class="rounded-md bg-blue-600 ml-5 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Display Filters</button>
        <div id="filter_form" style="display: none;">
            <form action="/manage" method="post">
                <h3>Filter by: </h3>
                <div class="filter-group">
                    <label for="filter" class="block text-sm font-medium leading-6 text-gray-900">Status:</label>
                    <select id="filter" name="filter" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <option value="0">None</option>
                        <option value="PENDING">PENDING</option>
                        <option value="CANCELLED">CANCELLED</option>
                        <option value="COMPLETED">COMPLETED</option>
                    </select>
                    <br><br>
                </div>
                <div class="filter-group">
                    <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                    >Filter
                    </button>
                </div>
            </form>
        </div>
        <br><br>
        <?php if(!empty($parameters)) :?>
            <p>Currently filtering by: <?= $parameters["status"]?></p>
        <?php else: ?>
            <p>No filters are currently active.</p>
        <?php endif; ?>
    </div>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <ul>
            <hr>
            <?php foreach ($orders as $order):?>
                <li>Order number:
                    <?= htmlspecialchars($order['id'])?>
                </li>
                <li>Status: <?= htmlspecialchars($order['status'])?></li>
                <li>
                    <form action="/my_order" method="get">
                        <input type="hidden" name="order_id" value="<?=$order['id']?>">
                        <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >See more</button>
                    </form>
                </li>
                <br>
                <li>
                    <form action="/update_status" method="post">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="order_id" value="<?=$order['id']?>">
                        <select name="status">
                            <option value="PENDING">Pending</option>
                            <option value="CANCELLED">Cancelled</option>
                            <option value="COMPLETED">Completed</option>
                        </select>
                        <button type="submit" class="rounded-md bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >Set status</button>
                    </form>
                </li>
                <br><hr><br>
            <?php endforeach; ?>
        </ul>
        <p class="mt-4">Back to <a href="/products" class="text-red-300 hover:underline">All products</a></p>

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

