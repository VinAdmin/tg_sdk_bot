<?php
/**
 * Класс работы с Api для телеграмм бота TgApi
 *
 * @author Vitaliy Olkhin <ovvitalik@gmail.com>
 */
namespace Tg;

class TgApi {
    private $url = "https://api.telegram.org/bot";
    private $token = null;
    
    function __construct($toket) {
        $this->token = $toket;
    }
}
