<?php

namespace TelegramBot;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Traits\Macroable;
use JsonException;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use stdClass;
use TelegramBot\Endpoints\AvailableMethods;
use TelegramBot\Endpoints\Games;
use TelegramBot\Endpoints\GettingUpdates;
use TelegramBot\Endpoints\InlineMode;
use TelegramBot\Endpoints\Passport;
use TelegramBot\Endpoints\Payments;
use TelegramBot\Endpoints\Stickers;
use TelegramBot\Endpoints\UpdatesMessages;
use TelegramBot\Types\File;
use TelegramBot\Types\InputFile;
use TelegramBot\Types\Message;

/**
 * @mixin TelegramBot
 */
trait Client
{
    use GettingUpdates, AvailableMethods, Games, InlineMode, Passport, Payments, Stickers, UpdatesMessages;
    use Macroable;

    /**
     * Send generic request.
     * @param string $endpoint
     * @param array $parameters
     * @param array $clientOpt
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function sendRequest(string $endpoint, array $parameters = [], array $clientOpt = []): mixed
    {
        return $this->requestMultipart($endpoint, $parameters, clientOpt: $clientOpt);
    }

    /**
     * Send a JSON request.
     * @param string $endpoint
     * @param array|null $json
     * @param string $mapTo
     * @param array $options
     * @return mixed
     * @throws JsonException
     * @throws TelegramException
     * @throws GuzzleException
     */
    protected function requestJson(string $endpoint, ?array $json = null, string $mapTo = stdClass::class, array $options = []): mixed
    {
        try {
            $response = $this->http->post($endpoint, array_merge([
                'json' => $json,
            ], $options));
            return $this->mapResponse($response, $mapTo);
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * Send a multipart/form-data request.
     * @param string $endpoint
     * @param array|null $multipart
     * @param string $mapTo
     * @param array $clientOpt
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    protected function requestMultipart(string $endpoint, ?array $multipart = null, string $mapTo = stdClass::class, array $clientOpt = []): mixed
    {
        $parameters = array_map(static fn ($name, $contents) => match (true) {
            $contents instanceof InputFile => [
                'name' => $name,
                'contents' => $contents->getResource(),
                'filename' => $contents->getFilename(),
            ],
            $contents instanceof JsonSerializable => [
                'name' => $name,
                'contents' => json_encode($contents),
            ],
            default => [
                'name' => $name,
                'contents' => $contents,
            ]
        }, array_keys($multipart), $multipart);
        try {
            $response = $this->http->post($endpoint, array_merge(['multipart' => $parameters], $clientOpt));
            return $this->mapResponse($response, $mapTo);
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * Send a common multipart/form-data request with fallback to JSON.
     * @param int|string $chat_id
     * @param string $endpoint
     * @param string $param
     * @param mixed $value
     * @param array $opt
     * @param array $clientOpt
     * @return Message|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    protected function sendAttachment(int|string $chat_id, string $endpoint, string $param, mixed $value, array $opt = [], array $clientOpt = []): ?Message
    {
        $required = [
            'chat_id' => $chat_id,
            $param => $value,
        ];
        if (is_resource($value) || $value instanceof InputFile) {
            $required[$param] = $value instanceof InputFile ? $value : new InputFile($value);
            return $this->requestMultipart($endpoint, array_merge($required, $opt), Message::class, $clientOpt);
        }
        return $this->requestJson($endpoint, array_merge($required, $opt), Message::class);
    }

    /**
     * Map a response to a given class.
     * @param ResponseInterface $response
     * @param string $mapTo
     * @param Exception|null $clientException
     * @return mixed
     * @throws TelegramException
     * @throws JsonException
     */
    protected function mapResponse(ResponseInterface $response, string $mapTo, Exception $clientException = null): mixed
    {
        $json = json_decode((string)$response->getBody(), flags: JSON_THROW_ON_ERROR);
        if ($json?->ok) {
            return match (true) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => $this->hydrator->hydrateArray($json->result, new $mapTo),
                default => $this->hydrator->hydrate($json->result, new $mapTo)
            };
        }
        throw new TelegramException(
            $json?->description ?? 'Client exception',
            $json?->error_code ?? 0,
            $clientException
        );
    }

    /**
     * Get the download url for a File object.
     * @param File $file
     * @return string|null
     */
    public function downloadUrl(File $file): string|null
    {
        if ($this->config['is_local']) {
            return $file->file_path;
        }

        return $this->getFileUrl($file->file_path);
    }

    /**
     * Save file to disk.
     * @param File $file
     * @param string $path
     * @param array $clientOpt
     * @return bool
     * @throws GuzzleException
     */
    public function downloadFile(File $file, string $path, array $clientOpt = []): bool
    {
        if (!is_dir(dirname($path)) && !mkdir($concurrentDirectory = dirname($path), true,
                true) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Error creating directory "%s"', $concurrentDirectory));
        }

        $response = $this->http->get($this->downloadUrl($file), array_merge(['sink' => $path], $clientOpt));
        return $response->getStatusCode() === 200;
    }
}
