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
    var $messageLayout = [];
    function set($data)
    {
        $this->vars = array_merge($this->vars, $data);
    }

    function render($filename, $isFileDir = false)
    {

        extract($this->vars);
        ob_start();
        if(!$isFileDir){
            include_once(ROOT . "Views\\" . ucfirst(str_replace('Controller', '', get_class($this))) . '\\' . $filename . '.php');
        } else include_once($filename);
        $content_for_layout = ob_get_clean();
        if ($this->layout == false) {
            $content_for_layout;
        } else {
            require_once(ROOT . "Views\\Layouts\\" . $this->layout . '.php');
        }
    }

    public function popup($urlRedirect,$popupMessage, $popupImage = false){
        $this->layout = "blankLayout";
        $data["popupMessage"] = $popupMessage;
        $data["popupImage"] = $popupImage;
        $data["urlRedirect"] = $urlRedirect;
        $this->set($data);
        $this->render(ROOT."Views\\Layouts\\Common\\popup.php",true);
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
