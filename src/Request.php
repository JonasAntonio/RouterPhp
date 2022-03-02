<?php

namespace Src;

class Request
{
   /**
    * Retorna o endpoint da request
    */
   public static function getUrl(): string
   {
      return $_GET['url'] ?? '';
   }

   /**
    * Retorna o método da requisição
    */
   public static function getMethod(): string
   {
      return $_SERVER['REQUEST_METHOD'];
   }

   /**
    * Retorna um array com os dados recebidos na requisição
    * @return array
    */
   public function getData(): array
   {
      return json_decode($this->getJson(), 1) ?? [];
      /**
       * switch (self::getMethod()) {
       *    case 'GET':
       *       return $_GET;
       *    case 'POST':
       *       $data = json_decode(file_get_contents('php://input'), 1);
       *       if (is_null($data))  $data = $_POST;
       *       if (!empty($_FILES)) $data = array_merge($data, $_FILES);
       *       return (array) $data;
       *    default:
       *       $data = json_decode(file_get_contents('php://input'), 1);
       *       if (is_null($data)) $data = $_POST;
       *       return (array) $data;
       * }
       */
   }

   /**
    * Retorna um objeto com os dados recebidos na requisição
    * @return object
    */
   public function getObj(): object
   {
      return json_decode($this->getJson()) ?? (object) [];
   }

   /**
    * Retorna um json com os dados recebidos na requisição
    * @return string
    */
   public function getJson(): string
   {
      return @$GLOBALS['json'] ?? '';
   }

   public static function lowerCaseHeader()
   {
      $header = apache_request_headers();
      foreach ($header as $key => $h) $header[strtolower($key)] = $h;
      return $header;
   }
}
