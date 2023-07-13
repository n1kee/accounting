<?php

namespace App\Type;

enum ClientTypes: int
{
    case INDIVIDUAL = 0;
    case LEGAL_ENTITY = 1;
}
