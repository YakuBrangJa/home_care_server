<?php

class Controller
{
    protected function render($view, $data = [])
    {
        $viewFile = dirname(__DIR__) . "/app/Views/$view.php";

        if (!file_exists($viewFile)) {
            throw new Exception("View file not found: $viewFile");
        }

        extract($data);

        include $viewFile;
    }
}