<?php
    namespace Bearlovescode\RecognizableService\Services;

    use App\Models\User;
    use Bearlovescode\RecognizableService\Exceptions\Webfinger\WebfingerResourceNotFoundException;
    use Bearlovescode\RecognizableService\Models\Configuration;
    use Bearlovescode\RecognizableService\Models\Link;
    use Bearlovescode\RecognizableService\Models\WebfingerResource;

    class WebfingerService
    {
        public function __construct(
            private readonly Configuration $config
        ) {}

        public function findUserResourceByUsername(string $username): WebfingerResource
        {

            if (!User::where('username', $username)->exists())
                throw new WebfingerResourceNotFoundException();

            $trans = [
                '{username}' => $username,
                '{host}' => $this->config->host
            ];

            $rsrc = new WebfingerResource([
                'subject' => strtr($this->config->subjectTemplate, $trans),
            ]);

            $rsrc->addLink(new Link([
                'rel' => 'self',
                'type' => 'application/activity+json',
                'href' => strtr($this->config->hrefTemplate, $trans),
            ]));

            return $rsrc;
        }
    }