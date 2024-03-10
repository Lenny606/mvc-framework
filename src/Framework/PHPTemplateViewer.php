<?php

namespace Framework;

class PHPTemplateViewer
{
    public function render(string $template, array $data = []) : string
    {
        //creates variables from array
        extract($data,EXTR_SKIP);

        //buffers the template and return all content
        ob_start();
        require __DIR__ . "/../../views/$template";

        return ob_get_clean();
    }

}