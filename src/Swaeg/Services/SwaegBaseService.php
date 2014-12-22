<?php

namespace Swaeg\Services;

use Silex\Application;

class SwaegBaseService {

	private $app;

        public function __construct(Application $app) {
                if($app !== null) {
                        $this->app = $app;
                }
        }

        public function getSilexApplication() {
                return $this->app;
        }

}

