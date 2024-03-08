<?php
    namespace Bearlovescode\RecognizableService\Models;

    use Bearlovescode\Datamodels\DataModel;

    class WebfingerResource extends DataModel
    {
        public string $subject;
        public array $links = [];

        public function addLink(Link $link): void
        {
            $this->links[] = $link;
        }
    }