<?php view('partials/head.php'); ?>
<?php view('partials/nav.php', ['header' => $header]); ?>

    <style>
        .form-group {
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-group label {
            display: inline-block;
            margin-bottom: 0.5rem;
            padding-right: 15px;
        }
        .form-group input {
            display: inline-block;
            width: 20%;
            padding: 0.5rem;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 0.5rem 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
    </style>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <a href="/my_orders" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >Go to my previous orders.</a><br><br>
            <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>. These are your profile data:</p>
            <p>Your role is: <?=getCurrentUserRole() ?? 'undefined'?>.</p>
            <p>Your id is: <?= getCurrentUserId() ?? 'undefined'?>.</p>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <form action="/profile" method="post">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?= $profile['first_name'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?= $profile['last_name'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $profile['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?= $profile['phone_number'] ?>">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?= $profile['city'] ?>">
                </div>
                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state" value="<?= $profile['state'] ?>">
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" value="<?= $profile['country'] ?>">
                </div>
                <div class="form-group">
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street" value="<?= $profile['street'] ?>">
                </div>
                <div class="form-group">
                    <button type="submit">Update profile</button>
                </div>
            </form>
        </div>
    </main>


<?php view('partials/footer.php') ?>