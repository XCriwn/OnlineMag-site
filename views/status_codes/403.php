<?php
view('partials/head.php');
view('partials/nav.php', ['header' => "403. Forbidden."]);
?>
    <br><hr><br>
<h1 class="text-3xl font-bold tracking-tight">You are not authorized to view this page.</h1>
    <br><hr><br>
<p><a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 bg-gray-700 hover:bg-gray-200 hover:text-white">Go back home.</a></p>

<?php view('partials/footer.php'); ?>