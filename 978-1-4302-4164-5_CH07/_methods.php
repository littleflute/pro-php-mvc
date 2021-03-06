<?php

namespace Framework
{
    class StringMethods
    {
        private static $_delimiter = "#";
        
        private function __construct()
        {
            // do nothing
        }
        
        private function __clone()
        {
            // do nothing
        }
        
        private static function _normalize($pattern)
        {
            return self::$_delimiter.trim($pattern, self::$_delimiter).self::$_delimiter;
        }
        
        public static function getDelimiter()
        {
            return self::$_delimiter;
        }
        
        public static function setDelimiter($delimiter)
        {
            self::$_delimiter = $delimiter;
        }
        
        public static function match($string, $pattern)
        {
            preg_match_all(self::_normalize($pattern), $string, $matches, PREG_PATTERN_ORDER);
            
            if (!empty($matches[1]))
            {
                return $matches[1];
            }
            
            if (!empty($matches[0]))
            {
                return $matches[0];
            }
            
            return null;
        }
        
        public static function split($string, $pattern, $limit = null)
        {
            $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
            return preg_split(self::_normalize($pattern), $string, $limit, $flags);
        }
    }    
    
    class ArrayMethods
    {
        private function __construct()
        {
            // do nothing
        }
        
        private function __clone()
        {
            // do nothing
        }
        
        public static function clean($array)
        {
            return array_filter($array, function($item) {
                return !empty($item);
            });
        }
        
        public static function trim($array)
        {
            return array_map(function($item) {
                return trim($item);
            }, $array);
        }
        
        public static function toObject($array)
        {
            $result = new \stdClass();
            
            foreach ($array as $key => $value)
            {
                if (is_array($value))
                {
                    $result->{$key} = self::toObject($value);
                }
                else
                {
                    $result->{$key} = $value;
                }
            }
            
            return $result;
        }
        
        public function flatten($array, $return = array())
        {
            foreach ($array as $key => $value)
            {
                if (is_array($value) || is_object($value))
                {
                    $return = self::flatten($value, $return);
                }
                else
                {
                    $return[] = $value;
                }
            }
            
            return $return;
        }
    }
}