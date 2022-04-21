<?php
namespace App\Repository\Timeline;

interface TimelineInterface
{
    /**
     * @return mixed
     */
    public function timeline();

    /**
     * @return mixed
     */
    public function topPicks();
}
