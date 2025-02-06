<?php
declare(strict_types=1);

namespace App\Domain\Model;

enum AdCategory: string
{
    case PLANTS = 'plantes';
    case CUTTINGS = 'boutures';
    case SEEDS = 'graines';
    case GARDENING_TOOLS = 'matériel';
    case CONSUMABLES = 'consommables';
}
