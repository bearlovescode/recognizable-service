<?php
    namespace Bearlovescode\RecognizableService\Models;

    use Bearlovescode\Datamodels\DataModel;

    class Configuration extends DataModel
    {
        public string $host;

        // webfinger.
        public string $hrefTemplate = 'https://{host}/@{username}';
        public string $subjectTemplate = '{type}:{username}@{host}';
    }
