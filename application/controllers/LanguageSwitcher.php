<?php
class LanguageSwitcher extends CI_Controller
{
    public function __construct() {
        parent::__construct();     
    }
 
    function switchLang($language = "") {
        
        $language = ($language != "" && $language != "seleccione") ? $language : "spanish";
        $this->session->set_userdata('site_lang', $language);
        
        redirect($_SERVER['HTTP_REFERER']);
        
    }
}
