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
        if (!$isFileDir) {
            require_once(ROOT . "Views\\" . ucfirst(str_replace('Controller', '', get_class($this))) . '\\' . $filename . '.php');
        } else require_once($filename);
        $content_for_layout = ob_get_clean();
        if ($this->layout == false) {

            $content_for_layout;
        } else {

            require_once(ROOT . "Views\\Layouts\\" . $this->layout . '.php');
        }
        return;
    }

    public function popup($urlRedirect, $popupMessage, $popupImage = false)
    {
        $this->layout = "blankLayout";
        $data["popupMessage"] = $popupMessage;
        $data["popupImage"] = $popupImage;
        $data["urlRedirect"] = $urlRedirect;
        $this->set($data);
        $this->render(ROOT . "Views\\Layouts\\Common\\popup.php", true);
        die();
    }
    public function dropUploadedFile($filePath)
    {
        $isCustomURL = preg_match("/^http?/", $filePath);
        $isUploadedFileDir =  preg_match('/^\/public\/upload\/?/', $filePath);
        if ((!$isCustomURL) && $isUploadedFileDir) {
            $fullPath = ROOT . "WEBROOT" . str_replace("/", "\\", $filePath);

            if (is_file($fullPath)) {
                unlink($fullPath);
            }
        }
    }
    public function dateTimeTransfom(string $dateTimeString, $currentTimeZone = CURRENT_TIME_ZONE, $targetTimeZone = null){
        $container = explode(" ", $dateTimeString);
        $dateContainer  = explode("-", $container[0]);
        $timeContainer = explode(":", $container[1]);
        if($targetTimeZone){
            $timeContainer[0] = ((int)$timeContainer) - $currentTimeZone + $targetTimeZone;
        }
        $dateTimeResult = mktime($timeContainer[0], $timeContainer[1], $timeContainer[2], $dateContainer[1], $dateContainer[2], $dateContainer[0] );
        return date(DATE_TIME_FORMAT, $dateTimeResult);
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
