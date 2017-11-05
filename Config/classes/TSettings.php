<?php namespace EC\Sys;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC,
    EC\Database;

class TSettings extends Database\TTable
{

    public function __construct(EC\MDatabase $db)
    {
        parent::__construct($db, 'Config_Settings', 's');

        $this->setColumns([
            'Name'  => new Database\FVarchar(true, 32),
            'Value' => new Database\FText(true, 'medium'),
        ]);

        /* Column Parsers */
        $this->setColumnParser('TablesIds', [
            'out' => function($row, $name, $value) {
                return [
                    $name => json_decode($value, true),
                ];
            },
            'in' => function($row, $name, $value) {
                return json_encode((object)$value);
            }
        ]);
    }

}
