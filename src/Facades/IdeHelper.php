<?php

namespace Gdl2Studio\IdeHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gdl2Studio\IdeHelper\IdeHelper
 * @method static static cleanUpAppFacades()
 * @method static \Illuminate\Support\Collection getAppFacades()
 * @method static \Illuminate\Support\Collection getParsedFacades()
 * @method static static parseAppFacades()
 * @method static static withNoWrite()
 * @method static static withWrite(bool $write = true)
 */
class IdeHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gdl2studio.ide-helper';
    }
}
