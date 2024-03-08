<?php
    namespace Bearlovescode\RecognizableService\Http\Controllers;

    use Bearlovescode\RecognizableService\Exceptions\InvalidResourceRequestExcepiton;
    use Bearlovescode\RecognizableService\Exceptions\Webfinger\WebfingerResourceNotFoundException;
    use Bearlovescode\RecognizableService\Exceptions\WebfingerException;
    use Bearlovescode\RecognizableService\Models\WebfingerResource;
    use Bearlovescode\RecognizableService\Services\WebfingerService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Response;

    class WebfingerController
    {

        public function __construct(
            private readonly WebfingerService $webfingerService
        ) {}

        public function __invoke(Request $request)
        {
            if (!$request->has('resource'))
                return Response::json(['error' => 'Invalid resource provided '], 400);

            try {
                list($type, $rsrc) = explode(':', $request->get('resource'));

                $data = match ($type) {
                    'acct' => $this->handleAccountResource($rsrc)
                };

                return Response::json($data);

            }
            catch (InvalidResourceRequestExcepiton $e)
            {
                return $this->handleRequestError($e);
            }

            catch (WebfingerResourceNotFoundException $e) {
                return $this->handleRequestError($e, 404);
            }
        }

        /**
         * @param string $resource
         * @return WebfingerResource
         */
        public function handleAccountResource(string $rsrc): WebfingerResource
        {
            // extract username

            // retrive user record.
            return $this->webfingerService->findAccountResource($username);
        }


        /**
         * @param \Exception $e
         * @param int $httpStatus
         * @return \Illuminate\Http\JsonResponse
         */
        private function handleRequestError(\Exception $e, int $httpStatus = 400)
        {
            return Response::json(['error' => $e->getMessage()], $httpStatus);
        }
    }