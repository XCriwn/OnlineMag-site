<?php
view('partials/head.php');
view('partials/nav.php', ['header' => "300. Please login to view this page."]);
?>

    <div class="mx-auto max-w-7xl ">
        <br><hr><br>
        <h1 class="text-3xl font-bold tracking-tight">You have to be logged in to view this page.</h1>
        <br><hr><br>
        <p><a href="/login" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 bg-green-700 hover:bg-gray-200 hover:text-white">Log In.</a></p>
        <br>
        <p><a href="/register" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 bg-green-700 hover:bg-gray-200 hover:text-white">Don't have an account? Register here.</a></p>
    </div>
<?php view('partials/footer.php'); ?>