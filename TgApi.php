<?php
/**
 * Класс для работы с Api телеграмм бота.
 * 
 * @package TgApi
 * @author Vitaliy Olkhin <ovvitalik@gmail.com>
 */
namespace Tg;

class TgApi {
    private $url = "https://api.telegram.org/bot";
    private $token = null;
    
    function __construct($toket) {
        $this->token = $toket;
    }
    
    /**
     * Принимает отправленные запросы от телеграмм бота.
     * Возвращает набор массива декодированного json формата.
     * 
     * @return array
     */
    public function WebHook()
    {
        $json = file_get_contents('php://input');
        $arr = json_decode($json, true);
        
        if(is_array($arr)){
            return $arr;
        }
        else {
            return false;
        }
    }
}
