<?php

namespace Framework;

class MVCTemplateViewer implements TemplateViewerInterface
{
    public function render(string $template, array $data = []): string
    {
        $views_directory = dirname(__DIR__, 2) . "/views/";

        $code = file_get_contents($views_directory . "$template");

        if (preg_match('#^{% extends "(?<template>.*)" %}#', $code, $matches) === 1) {
            $base = file_get_contents($views_directory . $matches["template"]);

            $blocks = $this->getBlock($code);
            $code = $this->replaceYields($base, $blocks);
        }

        //includes should go first
        $code = $this->loadIncludes($views_directory, $code);

        //php code for execution
        $code = $this->replaceVariables($code);
        $code = $this->replacePHP($code);

        //creates variables from array
        extract($data, EXTR_SKIP);

        //buffers the template and return all content
        ob_start();
        //require __DIR__ . "/../../views/$template";
        //using instead eval()
        eval("?>" . $code);

        return ob_get_clean();
    }

    private function replaceVariables(string $code): string
    {
        return preg_replace('#{{\s*(\S+)\s*}}#', "<?= htmlspecialchars(\$$1 ?? '') ?>", $code);
    }

    private function replacePHP(string $code): string
    {
        return preg_replace('#{%\s*(.+)\s*%}#', "<?php $1 ?>", $code);
    }

    private function getBlock(string $code): array
    {
        preg_match_all("#{% block (?<name>\w+) %}(?<content>.*?){% endblock %}#s", $code, $matches, PREG_SET_ORDER);

        $blocks = array();

        foreach ($matches as $match) {
            $blocks[$match["name"]] = $match["content"];
        }

        return $blocks;
    }

    private function replaceYields(string $code, array $blocks): string
    {
        preg_match_all("#{% yield (?<name>\w+) %}#", $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = $match["name"];
            $block = $blocks[$name];

            $code = preg_replace("#{% yield $name %}#", $block, $code);
        }

        return $code;
    }

    private function loadIncludes(string $dir, string $code) : string
    {
        preg_match_all('#{% include "(?<template>.*?)" %}#', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $template = $match["template"];
            $content = file_get_contents($dir . $template);

            $code = preg_replace("#{% include \"$template\" %}#", $content, $code);
        }
        return $code;
    }
}