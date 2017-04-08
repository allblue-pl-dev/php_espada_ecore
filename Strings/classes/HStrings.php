<?php namespace EC\Strings;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class HStrings
{

    static public $CharacterTypes = [ 'digits', 'letters', 'special' ];


    static public function GetCharsRegexp($types = [], $extra = '',
            $langs = null)
    {
        foreach ($types as $type) {
            if (!in_array($type, $types))
                throw new Exception("Unknown chars type `{$type}`.");
        }

        $chars = '';

        if (in_array('digits', $types))
            $chars .= '0-9';
        if (in_array('letters', $types))
            $chars .= 'a-zA-Z' . self::GetLangsSpecialCharacters();
        if (in_array('special', $types)) {
            $chars .= ' `!@#%&_=/<>:;",\'' .
                '\\\\' . '\\^' . '\\$' . '\\.' . '\\[' .'\\]' . '\\|' .
                '\\(' . '\\)' . '\\?' . '\\*' . '\\+' . '\\{' . '\\}' .
                '\\-';
        }

        return $chars . self::EscapeRegexpChars($extra);
    }

    static public function GetCharsRegexp_Basic()
    {
        return self::GetCharsRegexp([ 'digits', 'letters', 'special' ]);
    }

    static public function GetLangsSpecialCharacters($langs = null)
    {
        if ($langs === null)
            $langs = [ 'pl' ];

        $chars = '';
        if (in_array('pl', $langs))
            $chars .= 'ąćęłńóśźż' . 'ĄĆĘŁŃÓŚŹŻ';

        return $chars;
    }

    static public function EscapeLangCharacters($str, $langs = [])
    {
        $replace_from   = ['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż',
                           'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'];
        $replace_to     = ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z',
                           'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'];

        return str_replace($replace_from, $replace_to, $str);
    }

    static public function EscapeRegexpChars($str)
    {
        $replace_from = [ '\\', '^', '$', '.', '[' .']', '|', '(' .
                ')', '?', '*', '+', '{', '}', '-', '#' ];
        $replace_to = [ '\\\\', '\\^', '\\$', '\\.', '\\[' .'\\]', '\\|', '\\(' .
                '\\)', '\\?', '\\*', '\\+', '\\{', '\\}', '\\-', '\\#' ];

        return str_replace($replace_from, $replace_to, $str);
    }

    static public function RemoveCharacters($stri, $chars,
            $allowed = true)
    {
        $new_str = '';
        for ($i = 0; $i < mb_strlen($str); $i++) {
            if (mb_strpos($chars, $str[$i]))
                $new_str .= $str[$i];
        }

        return $new_str;
    }

    static public function StripDoubles($str, $doubles)
    {
        while (true) {
            $str = str_replace('--', '-', $str, $count);
            if ($count === 0)
                return $str;
        }
    }

}
