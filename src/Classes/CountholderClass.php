<?php

namespace App\Classes;

class CountholderClass
{
    /**
     * @method mixed countholder()
     *
     * @uses CountdownTrait euwtimer() natimer()
     */
    use CountdownTrait;

    public function countholder()
    {
        ?>
            <div id="countholder">
                <div><span class="days" id="days"></span>
                    <div class="smalltext">Day(s)</div>
                </div>
                <div><span class="hours" id="hours"></span>
                    <div class="smalltext">Hour(s)</div>
                </div>
                <div><span class="minutes" id="minutes"></span>
                    <div class="smalltext">Minute(s)</div>
                </div>
                <div><span class="seconds" id="seconds"></span>
                    <div class="smalltext">Second(s)</div>
                </div>
            </div>
            <?php
    }
}