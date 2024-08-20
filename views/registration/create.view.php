<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>


    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Register for a new account</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" action="/register" method="POST">

                        <div>
                            <div class="flex justify-between space-x-4">
                                <div class="flex-1">
                                    <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                                    <div class="mt-2">
                                        <input id="first_name" name="first_name" type="text" placeholder="First name..." autocomplete="first_name" value="<?= old('first_name') ?>" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                                    <div class="mt-2">
                                        <input id="last_name" name="last_name" type="text" placeholder="Last name..." autocomplete="" value="<?= old('last_name') ?>" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($errors['first_name'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['first_name']?></p>
                            <?php endif; ?>
                            <?php if(isset($errors['last_name'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['last_name']?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="flex justify-between space-x-4">
                                <div class="flex-1">
                                    <label for="address_country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                                    <div class="mt-2">
                                        <input id="address_country" name="address_country" type="text" placeholder="Country..." autocomplete="" value="<?= old('address_country') ?>"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <label for="address_state" class="block text-sm font-medium leading-6 text-gray-900">State</label>
                                    <div class="mt-2">
                                        <input id="address_state" name="address_state" type="text" placeholder="State..." autocomplete="" value="<?= old('address_state') ?>"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <label for="address_city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                                    <div class="mt-2">
                                        <input id="address_city" name="address_city" type="text" placeholder="City..." autocomplete="" value="<?= old('address_city') ?>"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($errors['address_country'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['address_country']?></p>
                            <?php endif; ?>
                            <?php if(isset($errors['address_state'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['address_state']?></p>
                            <?php endif; ?>
                            <?php if(isset($errors['address_city'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['address_city']?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="flex justify-between space-x-4">
                                <div class="flex-1">
                                    <label for="address_street" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
                                    <div class="mt-2">
                                        <input id="address_street" name="address_street" type="text" placeholder="Street..." autocomplete="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="phone_number" class="block text-sm font-medium leading-6 text-gray-900">Phone number</label>
                                    <div class="mt-2">
                                        <input id="phone_number" name="phone_number" type="text" placeholder="Phone number..." autocomplete="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($errors['address_street'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['address_street']?></p>
                            <?php endif; ?>
                            <?php if(isset($errors['phone_number'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['phone_number']?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" placeholder="Email..." autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if(isset($errors['email'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['email']?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            </div>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" placeholder="Password..." autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if(isset($errors['password'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['password']?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>



<?php view('partials/footer.php') ?>