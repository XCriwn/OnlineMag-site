<!--//todo write here code to display all products currently in the cart-->
<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

<!--TODO product stuff-->
<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <ul>
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
                <br><hr><br>
            <?php endforeach; ?>
        </ul>
        <p class="mt-4">Back to <a href="/products" class="text-red-300 hover:underline">All products</a></p>

    </div>
</main>



<?php view('partials/footer.php') ?>