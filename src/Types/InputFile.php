<?php

namespace TelegramBot\Types;

use InvalidArgumentException;

/**
 * This object represents the contents of a file to be uploaded. Must be posted using
 * multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile
{
    /**
     * @var resource|false
     */
    protected $resource;

    /**
     * @var string|null
     */
    protected ?string $filename;

    /**
     * @param resource|string $resource
     * @param string|null $filename
     */
    public function __construct(mixed $resource, ?string $filename = null)
    {
        $this->filename = $filename;
        if (is_resource($resource)) {
            $this->resource = $resource;
        } elseif (is_string($resource) && file_exists($resource)) {
            $this->resource = fopen($resource, 'rb+');
        } else {
            throw new InvalidArgumentException('Invalid resource specified.');
        }
    }

    /**
     * @param resource|string $resource
     * @param string|null $filename
     * @return InputFile
     */
    public static function make(mixed $resource, ?string $filename = null): InputFile
    {
        return new self($resource, $filename);
    }

    /**
     * Set filename
     * @param string|null $filename
     * @return InputFile
     */
    public function filename(?string $filename): InputFile
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Get resource
     * @return resource|false
     */
    public function getResource(): mixed
    {
        return $this->resource;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename(): string
    {
        $metadata = stream_get_meta_data($this->resource);
        if ($this->filename === null && isset($metadata['uri'])) {
            return basename($metadata['uri']);
        }
        return basename($this->filename ?? uniqid(more_entropy: true));
    }
}
