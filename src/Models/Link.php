<?php
    namespace Bearlovescode\RecognizableService\Models;

    use Bearlovescode\Datamodels\DataModel;

    class Link extends DataModel
    {
        public string $rel;
        public string $type;
        public string $href;
    }