<?php view('partials/head.php');?>
<?php view('partials/nav.php', ['header' => $header]); ?>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p>Current Image:</p>
            <?php //dd($product); ?>
            <img src="<?= getImage($product['image']); ?>" alt="Something went wrong." height="100px" width="100px">
            <form method="POST" action="/product" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="<?= $product['id']?>">
                <input type="hidden" id="selected-categories" name="selected_categories" value="">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="name" class="block text-sm font-medium leading-6 ">Name:</label>
                                <div class="mt-2">
                                    <input
                                            id="name"
                                            name="name"
                                            type="text"
                                            value="<?= $product['name'] ?>"
                                            placeholder="Write here the name of the item..."
                                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    >

                                    <?php if(isset($errors['name'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['name']?></p>
                                    <?php endif; ?>
                                </div>
                                <label for="description" class="block text-sm font-medium leading-6">Description:</label>
                                <div class="mt-2">
                                    <textarea
                                            id="description"
                                            name="description"
                                            rows="3"
                                            placeholder="Write here the description of the item..."
                                            class="textarea_class block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    ><?= $product['description'] ?></textarea>

                                    <?php if(isset($errors['description'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['description']?></p>
                                    <?php endif; ?>
                                </div>
                                <label for="price" class="block text-sm font-medium leading-6 ">Price:</label>
                                <div class="mt-2">
                                    <input
                                            id="price"
                                            name="price"
                                            type="number"
                                            step="0.01"
                                            value="<?= $product['price'] ?>"
                                            placeholder="Write here the price of the item..."
                                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    >

                                    <?php if(isset($errors['price'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['price']?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-2"><br>

                                    <label for="image">Update the image: </label>
                                    <input type="file" id="image" name="image" value="<?= $product['image'] ?? ""?>" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">

                                    <?php if(isset($errors['image'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['image']?></p>
                                    <?php endif; ?>

                                </div>

                                <div class="mt-2"><br>
                                    <label for="category">Category: </label>
                                    <select id="category" name="category" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" id="add-category" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                                    >+</button>
                                </div>

                                <div class="mt-2"><br>
                                    <label>Selected Categories:</label>
                                    <ul id="category-list" class="list-disc pl-5">
                                        <!-- JavaScript will append categories here -->
                                        <?php
                                        if (!empty($product['category_names'])): $selectedCategories = explode(',', $product['category_names']); endif;
                                        if (!empty($_POST['selected_categories'])): $selectedCategories = explode(',', $_POST['selected_categories']); endif;
                                        if(!empty($selectedCategories)):
                                            foreach ($selectedCategories as $selectedCategory): ?>
                                                <li>
                                                    <?= htmlspecialchars($selectedCategory) ?>
                                                    <button type="button" class="ml-2 rounded-md bg-red-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-500" onclick="this.parentElement.remove(); updateSelectedCategories();">-</button>
                                                </li>
                                        <?php endforeach; endif;?>
                                    </ul>
                                    <?php if(isset($errors['selectedCategories'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['selectedCategories']?></p>
                                    <?php endif; ?>


                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">

                    <a href="/product?id=<?= $product['id'] ?>" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Update</button>
                </div>
            </form>
            <form action="/product" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value="<?= $product['id']?>">
                <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >Delete Product</button>
            </form>


<!--            <form method="POST" class="mt-4">-->
<!--                <input type="hidden" name="_method" value="DELETE">-->
<!--                <input type="hidden" name="id" value="--><?php //=$note['id']?><!--">-->
<!--                <button type="submit" class="text-green-300 text-xs mt-4">Delete</button>-->
<!--            </form><br>-->


            <p class="mt-6">Back to <a href="/products" class="text-red-300 hover:underline">All Products</a></p>

        </div>
    </main>



<?php view('partials/footer.php'); ?>


<script>
    document.getElementById('add-category').addEventListener('click', function() {
        var categorySelect = document.getElementById('category');
        var selectedCategory = categorySelect.options[categorySelect.selectedIndex].text.trim();
        var categoryList = document.getElementById('category-list');
        var selectedCategoriesInput = document.getElementById('selected-categories');
        // Check if selectedCategoryInput has anything and put it in the categoryList if it does

        // Check if the category already exists in the list
        var exists = false;
        categoryList.querySelectorAll('li').forEach(function(item) {
            if (item.textContent.replace(' -', '').replace('-', '').trim() === selectedCategory) {
                exists = true;
            }
        });

        if (exists) {
            alert('Category already exists in the list.');
            return;
        }

        var listItem = document.createElement('li');
        listItem.textContent = selectedCategory;

        var removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.className = 'ml-2 rounded-md bg-red-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-500';
        removeButton.addEventListener('click', function() {
            categoryList.removeChild(listItem);
            updateSelectedCategories();
        });

        listItem.appendChild(removeButton);
        categoryList.appendChild(listItem);
        updateSelectedCategories();
    });

    function updateSelectedCategories() {
        var categoryList = document.getElementById('category-list');
        var selectedCategories = [];
        categoryList.querySelectorAll('li').forEach(function(item) {
            selectedCategories.push(item.textContent.replace(' -', '').replace('-', '').trim());
        });
        document.getElementById('selected-categories').value = selectedCategories.join(',');
    }

    updateSelectedCategories();
</script>

