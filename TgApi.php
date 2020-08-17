<?php
namespace Tg;

/**
 * Класс для работы с Api телеграмм бота.
 * 
 * @package TgApi
 * @author Vitaliy Olkhin <ovvitalik@gmail.com>
 * @property int $chat_id
 * @property string $username
 * @property string $last_name
 * @property string $first_name
 * @property int $is_bot
 * @property string $language_code
 * @property int $data_output_json = false - OBject, true - array
 */

class TgApi {
    private $url = "https://api.telegram.org/bot";
    private $token = null;
    public $chat_id = null; //id чата
    public $username = null;
    public $last_name = null;
    public $first_name = null;
    public $is_bot = null;
    public $language_code = null;
    public $data_output_json = false;
    
    /**
     * Принимает телеграмм токен.
     * 
     * @param string $toket
     */
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
            if(isset($arr['message'])){
                $this->chat_id = $arr['message']['from']['id'];
                $this->username = !empty($arr['message']['from']['username']) ? $arr['message']['from']['username'] : null;
                $this->last_name = $arr['message']['from']['last_name'];
                $this->is_bot = ($arr['message']['from']['is_bot'] === true) ? 1 : 0; //Если верно то бот
                $this->language_code = $arr['message']['from']['language_code'];
                $this->first_name = $arr['message']['from']['first_name'];
            }
            
            return $arr;
        }
        else {
            return false;
        }
    }
    
    private function post(string $method="getMe", array $params=array(), string $get = null)
    {
        $ch = curl_init();
        $getParams = empty($get) ? '' : '?' . $get;
        curl_setopt($ch, CURLOPT_URL, $this->url . $this->token . "/" . $method . $getParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $arr = json_decode($output, $this->data_output_json);
        return $arr;
    }
    
    /**
     * Информация о боте
     * 
     * @return $array['ok']
     * @return $array['result']['id']
     * @return $array['result']['is_bot']
     * @return $array['result']['first_name']
     * @return $array['result']['username']
     * @return $array['result']['can_join_groups']
     * @return $array['result']['can_read_all_group_messages']
     * @return $array['result']['supports_inline_queries']
     */
    public function getMe()
    {
        return $this->post();
    }
}
