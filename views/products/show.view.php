<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

    <style>
        img {
            width: 250px;
            height: auto;
            max-height: 300px;
        }
    </style>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <img src="<?= getImage($product['image']); ?>" alt="Something went wrong."> <br>
            <h3 class="text-red-300">Name: <?= htmlspecialchars($product['name'])?></h3>
            <p>Description: <?= htmlspecialchars($product['description'])?></p> <br>
            <p>Price: <?= htmlspecialchars($product['price'])?>$</p>

            <p>Categories: <?= isset($product['category_names']) ? htmlspecialchars($product['category_names']) : "None"?></p>
            <br>
            <?php if (getCurrentUserId() !== null) : ?>

                <form action="/order" method="post">
                    <input type="hidden" name="id" value="<?= $product['id']?>">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" class="rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Add to cart</button>
                </form>

            <?php else : ?>

            <p>Log in to add to cart.</p>

            <?php endif; ?>

            <?php if(getCurrentUserRole() === 'admin') :?>
            <footer class="mt-6">
                <a href="product/edit?id=<?= $product['id'] ?>" class="text-green-300 text-xs mt-6 border border-current rounded px-4 py-2">Edit</a>
            </footer>
            <?php endif; ?>



            <p class="mt-4">Back to <a href="/products" class="text-red-300 hover:underline">All products</a></p>

        </div>
    </main>



<?php view('partials/footer.php') ?>