<?php

view("registration/create.view.php", [
    'header' => '',
    'errors' => \core\Session::get('errors') ?? []
]);