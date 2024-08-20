<?php

view('sessions/create.view.php', [
    'header' => '',
    'errors' => \core\Session::get('errors') ?? []
]);