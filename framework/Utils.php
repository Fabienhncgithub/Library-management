<?php

require_once 'View.php';

class Utils {

    /**
     * Permet d'encoder une string au format base64url, c'est-à-dire un format base64 dans 
     * lequel les caractères '+' et '/' sont remplacés respectivement par '-' et '_', ce qui
     * permet d'utiliser le résultat dans un URL.
     *
     * @param string $data La string à encoder.
     * @return string La string encodée.
     */
    private static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    /**
     * Permet de décoder une string encodée au format base64url.
     *
     * @param string $data La string à décoder.
     * @return string La string décodée.
     */
    private static function base64url_decode($data) {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }
    /**
     * Permet d'encoder une structure de donnée (par exemple un tableau associatif ou un
     * objet) au format base64url.
     *
     * @param mixed $data La structure de données à encoder.
     * @return string La string résultant de l'encodage.
     */
    public static function url_safe_encode($data) {
        return self::base64url_encode(gzcompress(json_encode($data), 9));
    }
    /**
     * Permet d'encoder une structure de donnée (par exemple un tableau associatif ou un
     * objet) au format base64url.
     *
     * @param mixed $data La structure de données à encoder.
     * @return string La string résultant de l'encodage.
     */
    public static function url_safe_decode($data) {
        return json_decode(@gzuncompress(self::base64url_decode($data)), true, 512, JSON_OBJECT_AS_ARRAY);
    }

    /*
     * Redirige le navigateur vers l'action demandée.
     * Remarque : si un des paramètres est vide (null ou string vide), les suivants sont ignorés.
     */

    public function redirect($controller = "", $action = "index", $param1 = "", $param2 = "", $param3 = "", $statusCode = 303) {
        $web_root = Configuration::get("web_root");
        $default_controller = Configuration::get("default_controller");
        if (empty($controller)) {
            $controller = $default_controller;
        }
        if (empty($action)) {
            $action = "index";
        }
        $header = "Location: $web_root$controller/$action";
        if (!empty($param1)) {
            $header .= "/$param1";
            if (!empty($param2)) {
                $header .= "/$param2";
                if (!empty($param3)) {
                    $header .= "/$param3";
                }
            }
        }
        header($header, true, $statusCode);
        die();
    }

}
