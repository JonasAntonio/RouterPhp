<?php

namespace Src;

class Str
{
    /**
     * Formata a url para o padrão
     * @author Jonas Vicente
     * @param string $url
     * @return string
     */
    public static function setUrlPattern(string $url): string
    {
        $url = explode('?', $url);
        return preg_replace('/\/$/', '', preg_replace('/^\//', '', trim($url[0])));
    }
}