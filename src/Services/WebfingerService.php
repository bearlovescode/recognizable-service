<?php
    namespace Bearlovescode\RecognizableService\Services;

    use App\Models\User;
    use Bearlovescode\RecognizableService\Exceptions\Webfinger\WebfingerResourceNotFoundException;
    use Bearlovescode\RecognizableService\Models\Configuration;
    use Bearlovescode\RecognizableService\Models\Link;
    use Bearlovescode\RecognizableService\Models\WebfingerResource;
    use Illuminate\Support\Facades\Request;

    class WebfingerService
    {
        public function __construct(
            private readonly Configuration $config
        ) {}

        public function findUserResource(string $rsrc): WebfingerResource
        {
            list($username, $host) = explode('@', $rsrc);

            if ($host !== Request::getHost() ||
                    !User::where('username', $username)->exists())
                throw new WebfingerResourceNotFoundException();

            $trans = [
                '{username}' => $username,
                '{host}' => $this->config->host
            ];

            $record = new WebfingerResource([
                'subject' => strtr($this->config->subjectTemplate, $trans),
            ]);

            $record->addLink(new Link([
                'rel' => 'self',
                'type' => 'application/activity+json',
                'href' => strtr($this->config->hrefTemplate, $trans),
            ]));

            return $record;
        }
    }