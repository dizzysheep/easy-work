<?php

namespace Framework\Handles;

use Framework\App;
use Framework\router\EasyRouter;

class RouterHandle
{
    /**
     * @desc
     * @param App $app
     */
    public function register(App $app)
    {
        (new EasyRouter())->init($app);
    }
}