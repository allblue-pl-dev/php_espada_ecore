<?php namespace EC\CSV;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class CCSV
{

    private $separators = null;
    private $charset = '';

    private $separator = '';
    private $rows = [];

    public function __construct($separators = [';', ','])
    {
        $this->separators = $separators;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function read($file_path)
    {
        if (!file_exists($file_path))
            return false;

        $convert_charset = $this->charset !== '';

        $file = fopen($file_path, 'r');

        if ($file === false)
            return false;

        $first_line = null;
        $second_line = null;

        $first_line = fgets($file);
        if ($first_line === false) {
            fclose($file);
            return true;
        }
        if ($convert_charset)
            $first_line = iconv($this->charset, 'utf-8', $first_line);

        $second_line = fgets($file);
        if ($convert_charset)
            $second_line = iconv($this->charset, 'utf-8', $second_line);

        $this->separator = null;
        $max_count = -1;
        if ($second_line !== false) {
            foreach ($this->separators as $separator) {
                $first_line_count = substr_count($first_line, $separator);
                $second_line_count = substr_count($second_line, $separator);

                if ($first_line_count === 0)
                    continue;

                if ($first_line_count === $second_line_count) {
                    if ($first_line_count > $max_count)
                        $this->separator = $separator;
                }
            }
        }
        if ($this->separator === null)
            throw new \Exception('Cannot determine separator.');

        $this->readRow($first_line);
        if ($second_line === false) {
            fclose($file);

            return true;
        }

        $this->readRow($second_line);

        while (($line = fgets($file)) !== false) {
            if ($convert_charset) {
                $this->readRow(iconv($this->charset, 'utf-8', $line));
            } else
                $this->readRow($line);
        }

        fclose($file);

        return true;
    }

    public function getRowsLength()
    {
        return count($this->rows);
    }

    public function getRow($i)
    {
        if ($i < 0 || $i >= $this->getRowsLength())
            throw new \Exception("Cannot read row {$i}.");

        return $this->rows[$i];
    }

    private function readRow($line)
    {
        $row = new CRow();

        $line = $this->readRow_ParseQuatations($line);

        $columns = explode($this->separator, $line);

        foreach ($columns as $column) {
            $column = str_replace('&#44;', ',', $column);
            $row->addColumn($column);
        }

        $this->rows[] = $row;
    }

    private function readRow_ParseQuatations($line)
    {
        $regexp = '#(^|,)"(.*?)"($|,)#';

        preg_match_all($regexp, $line, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $match_2 = str_replace(',', '&#44;', $match[2]);

            $line = str_replace($match[0], $match[1] . $match_2 . $match[3],
                    $line);
        }

        return $line;
    }

}
