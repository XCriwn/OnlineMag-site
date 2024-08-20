<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>


<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>.</p>
        <p>Your role is: <?=getCurrentUserRole() ?? 'undefined'?>.</p>
        <p>Your id is: <?= getCurrentUserId() ?? 'undefined'?>.</p><br>
        <h1><strong>These are our newest products:</strong></h1>
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

                <br><hr><br>
            <?php endforeach; ?>
        </ul>
    </div>

</main>



<?php view('partials/footer.php') ?>