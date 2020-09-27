<?php

namespace App\Listeners;

use App\Events\DefaultProviderChanged;

abstract class DefaultProviderChangedListener
{
    /**
     * Handle the event.
     *
     * @param  DefaultProviderChanged  $event
     * @return void
     */
    abstract public function handle(DefaultProviderChanged $event);
}
