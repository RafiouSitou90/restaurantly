<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    
    public function boot(): void
    {
        parent::boot();

        /** @var string $appTimezone */
        $appTimezone = $this->getContainer()->getParameter('app.timezone');
        date_default_timezone_set($appTimezone);
    }
}
