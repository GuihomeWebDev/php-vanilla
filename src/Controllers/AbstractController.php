<?php

namespace App\Controllers;

class AbstractController
{
    public function render( $currentRoute, array $params = null)
    {
        ob_start();
        $currentRoute = str_replace('.', DIRECTORY_SEPARATOR, $currentRoute);
        require TEMPLATES . $currentRoute . '.html.php';
        
        $render = ob_get_clean();
        require TEMPLATES . 'layout.html.php';
    }
}