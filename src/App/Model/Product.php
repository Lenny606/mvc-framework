<?php

namespace App\Model;

use Framework\Model;

class Product extends Model
{
    //everything inherited from Model

    //overrides
    protected $tableName = "product";
}