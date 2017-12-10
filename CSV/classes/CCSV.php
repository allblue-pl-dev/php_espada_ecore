<?php namespace EC\CSV;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class CCSV
{

    private $separators = null;
    private $charset = '';

    private $separator = '';

    private $file = null;
    private $rowIndex = 0;
    private $line0 = null;
    private $line1 = null;

    public function __construct($separators = [';', ','], $charset = '')
    {
        $this->separators = $separators;
        $this->charset = $charset;
    }

    public function close()
    {
        if ($this->file !== null)
            fclose($this->file);
        $this->file = null;

        $this->rowIndex = 0;

        $this->line0 = null;
        $this->line1 = null;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function open($file_path)
    {
        if ($this->file !== null)
            throw new \Exception('Close `CSV` before opening.');

        if (!file_exists($file_path))
            return false;

        $this->file = fopen($file_path, 'r');
        if ($this->file === false) {
            $this->close();
            return false;
        }

        $this->line0 = null;
        $this->line1 = null;

        $this->line0 = fgets($this->file);
        if ($this->line0 === false) {
            $this->line0 = null;
            return true;
        }

        $this->determineSeparator();

        if ($this->line1 === false) {
            $this->close();
            return true;
        }

        return true;
    }

    public function nextRow()
    {
        $line = null;
        $row = null;
        if ($this->rowIndex === 0)
            $line = $this->line0;
        else if ($this->rowIndex === 1) {
            $line = $this->line1;
        } else {
            $line = fgets($this->file);
            $line = $line === false ? null : $line;
        }

        if ($line === null)
            return null;

        if ($this->charset !== '') {
            $row = $this->readRow(EC\Strings\HEncoding::Convert($line,
                    'utf-8', $this->charset));
        } else
            $row = $this->readRow($line);

        $this->rowIndex++;

        return $row;
    }


    private function determineSeparator()
    {
        if ($this->charset !== '') {
            $this->line0 = EC\Strings\HEncoding::Convert($this->line0,
                    'utf-8', $this->charset);
        }

        $this->line1 = fgets($this->file);
        if ($this->charset !== '') {
            $this->line1 = EC\Strings\HEncoding::Convert($this->line1,
                    'utf-8', $this->charset);
        }

        if (count($this->separators) === 1) {
            $this->separator = $this->separators[0];
            return;
        }

        $this->separator = null;
        $max_count = -1;
        if ($this->line1 !== false) {
            foreach ($this->separators as $separator) {
                $line0_count = substr_count($this->line0, $separator);
                $line1_count = substr_count($this->line1, $separator);

                if ($line0_count === 0)
                    continue;

                if ($line0_count === $line1_count) {
                    if ($line0_count > $max_count)
                        $this->separator = $separator;
                }
            }
        }

        if ($this->separator === null)
            throw new \Exception('Cannot determine separator.');
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

        return $row;
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
