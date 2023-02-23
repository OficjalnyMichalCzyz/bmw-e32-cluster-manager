<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output;

class OutputTimeMapping
{
    public const NO_SCROLLING = 3600.0;
    public const VERY_SLOW_SCROLLING = 2.0;
    public const SLOW_SCROLLING = 1.5;
    public const NORMAL_SCROLLING = 1.0;
    public const FAST_SCROLLING = 0.75;
    public const VERY_FAST_SCROLLING = 0.5;
    public const PRESENTATION_SCROLLING = 0.25;
}
