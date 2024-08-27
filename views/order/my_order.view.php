<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <hr><br>
        <p>Order id: <?= $orders['id'] ?></p>
        <p>Status: <?= $orders['status'] ?>
        <ul>
            <li>Client details:</li>
            <li>
                Full name: <?= htmlspecialchars($orders['last_name']) . " " . htmlspecialchars($orders['first_name'])?>
            </li>
            <li>
                Email: <?= htmlspecialchars($orders['email'])?>
            </li>
            <li>
                Country: <?= !empty(htmlspecialchars($orders['country'])) ? htmlspecialchars($orders['country']) : "-"?>, State: <?= !empty(htmlspecialchars($orders['state'])) ? htmlspecialchars($orders['state']) : "-"?>, City: <?= !empty(htmlspecialchars($orders['city'])) ? htmlspecialchars($orders['city']) : "-"?>, Street: <?= !empty(htmlspecialchars($orders['street'])) ? htmlspecialchars($orders['street']) : "-"?>
            </li>
        </ul>
        <br>
        <?php if(getCurrentUserRole() === 'admin') : ?>
        <form action="/update_status" method="post">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="order_id" value="<?=$orders['id']?>">
            <select name="status" class="input_class">
                <option value="PENDING">Pending</option>
                <option value="CANCELLED">Cancelled</option>
                <option value="COMPLETED">Completed</option>
            </select>
            <button type="submit" class="rounded-md bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >Set status</button>
        </form>
        <?php endif; ?>
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