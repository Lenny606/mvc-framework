<?php

namespace Framework;

class MVCTemplateViewer implements TemplateViewerInterface
 {
    public function render(string $template, array $data = []) : string
    {
        $code = file_get_contents(dirname(__DIR__, 2) . "/views/$template");
        //php code for execution
        $code= $this->replaceVariables($code);
        $code= $this->replacePHP($code);

        //creates variables from array
        extract($data,EXTR_SKIP);

        //buffers the template and return all content
        ob_start();
        //require __DIR__ . "/../../views/$template";
        //using instead eval()
        eval("?>".$code);

        return ob_get_clean();
    }

    private function replaceVariables(string $code){
       return preg_replace('#{{\s*(\S+)\s*}}#', "<?= htmlspecialchars(\$$1) ?>", $code);
    }

    private function replacePHP(string $code){
        return preg_replace('#{%\s*(.+)\s*%}#', "<?php $1 ?>", $code);
    }

}