<?php
    namespace Bearlovescode\RecognizableService\Exceptions\Webfinger;

    use Throwable;

    class WebfingerResourceNotFoundException extends \Exception
    {
        public function __construct(?Throwable $previous = null)
        {
            parent::__construct('Resource not found', 404, $previous);
        }
    }