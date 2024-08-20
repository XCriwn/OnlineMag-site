<!--//todo write here code to display all products currently in the cart-->
<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

<!--TODO product stuff-->
<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <hr><br>
        <p>Order id: <?= $orders['id'] ?></p>
        <p>Status: <?= $orders['status'] ?>
        </p><br><hr><br>

        <ul>
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
                <br>
                <li>Count: <?= $product['item_count']?></li>
                <br><hr><br>
            <?php endforeach; ?>
            <?php if(empty($products)) : ?>
                <p>There are no products in your order.</p>
                <p>It should not be possible to see this...</p>
            <?php endif; ?>
        </ul>

        <?php if(getCurrentUserRole() !== 'admin') : ?>
            <p class="mt-4">Back to <a href="/my_orders" class="text-red-300 hover:underline">Your orders.</a></p>
        <?php else: ?>
            <p class="mt-4">Back to <a href="/manage" class="text-red-300 hover:underline">Manage orders.</a></p>
        <?php endif; ?>
    </div>
</main>



<?php view('partials/footer.php') ?>