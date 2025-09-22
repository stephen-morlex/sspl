<?php

namespace App\Enums;

enum LineupStatus: string
{
    case Starting = 'starting';
    case Substituted = 'substituted';
    case Bench = 'bench';
}