<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

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
            height: auto;
            max-height: 250px;
        }

    </style>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>.</p> <br>
<!--        <p>Your role is: --><?php //=getCurrentUserRole() ?? 'undefined'?><!--.</p>-->
<!--        <p>Your id is: --><?php //= getCurrentUserId() ?? 'undefined'?><!--.</p><br>-->
        <h1><strong>These are our newest products:</strong></h1>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
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