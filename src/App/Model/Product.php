<?php

namespace App\Model;

use Framework\Model;

class Product extends Model
{
    //everything inherited from Model

    //overrides
    protected $tableName = "product";


    public function validate(array $data): void
    {
        if (empty($data["name"])) {
            $this->addError("name", "missing name");
        }

//        return empty($this->errors);
    }
}