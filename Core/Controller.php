<?php

namespace Controller;

/**
 * BaseController:
 * - All controller will improve base on this
 */
class BaseController
{
    //BaseController Statement

    var $vars = [];
    var $layout = "defaultAplication";

    function set($data)
    {
        $this->vars = array_merge($this->vars, $data);
    }

    function render($filename)
    {

        extract($this->vars);
        ob_start();
        include_once(ROOT . "Views/" . ucfirst(str_replace('Controller', '', get_class($this))) . '/' . $filename . '.php');
        $content_for_layout = ob_get_clean();
        if ($this->layout == false) {
            $content_for_layout;
        } else {
            require_once(ROOT . "Views/Layouts/" . $this->layout . '.php');
        }
    }

    private function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    protected function secure_form($form)
    {
        foreach ($form as $key => $value) {
            $form[$key] = $this->secure_input($value);
        }
    }
}
