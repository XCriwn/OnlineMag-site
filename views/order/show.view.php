<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <ul>
                <?php
                $totalPrice = 0;
                foreach ($products as $product):
                    $totalPrice += $product['price'] * $product['item_count'];?>
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
                    <br>
                    <li>Count: <?= $product['item_count']?></li> <br>
                    <form action="/cart" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $product['id']?>">
                        <input type="hidden" name="order_id" value="<?= $order_id['id']?>">
                        <label for="quantity">Delete products:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" class="rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >Remove from cart</button>
                        <?php if(isset($errors['quantity'])) : ?>
                            <p class="text-red-500 text-xs mt-2"><?= $errors['quantity']?></p>
                        <?php endif; ?>
                    </form> <br>
                    <form action="/cart" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $product['id']?>">
                        <input type="hidden" name="order_id" value="<?= $order_id['id']?>">
                        <input type="hidden" name="quantity" value="<?= $product['item_count']?>">
                        <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >Remove All from cart</button>
                    </form>
                    <br><hr><br>
                <?php endforeach; ?>
                <?php if(empty($products )) : ?>
                    <p>There are no products in your cart.</p>
                    <p>Add some from the <a href="/products" class="text-red-300">products</a> page!</p>
                <?php endif; ?>
            </ul>
            <?php if(!empty($products)) :?>
                <p>Total Price: <?= htmlspecialchars($totalPrice) ?>$</p>

                <form action="/cart" method="post">
                    <input type="hidden" name="order_id" value="<?= $order_id['id']?>">
                    <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Submit Order</button>
                </form>
            <?php endif; ?>


            <p class="mt-4">Back to <a href="/products" class="text-red-300 hover:underline">All products</a></p>

        </div>
    </main>



<?php view('partials/footer.php') ?>