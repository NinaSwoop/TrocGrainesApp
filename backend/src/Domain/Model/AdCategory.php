<?php
declare(strict_types=1);

namespace App\Domain\Model;

enum AdCategory
{
    case PLANTS;
    case CUTTINGS;
    case SEEDS;
    case GARDENING_TOOLS;
    case CONSUMABLES;
}
