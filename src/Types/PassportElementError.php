<?php

namespace TelegramBot\Types;

use RuntimeException;

/**
 * This object represents an error in the Telegram Passport element
 * which was submitted that should be resolved by the user. It should be one of:
 * @see https://core.telegram.org/bots/api#passportelementerror
 */
class PassportElementError
{
    use PassportElementErrorDataField;
    use PassportElementErrorFile;
    use PassportElementErrorFiles;
    use PassportElementErrorFrontSide;
    use PassportElementErrorReverseSide;
    use PassportElementErrorSelfie;
    use PassportElementErrorTranslationFile;
    use PassportElementErrorTranslationFiles;
    use PassportElementErrorUnspecified;

    public function getType(): string
    {
        return match ($this->source) {
            'data' => PassportElementErrorDataField::class,
            'front_side' => PassportElementErrorFrontSide::class,
            'reverse_side' => PassportElementErrorReverseSide::class,
            'selfie' => PassportElementErrorSelfie::class,
            'file' => PassportElementErrorFile::class,
            'files' => PassportElementErrorFiles::class,
            'translation_file' => PassportElementErrorTranslationFile::class,
            'translation_files' => PassportElementErrorTranslationFiles::class,
            'unspecified' => PassportElementErrorUnspecified::class,
            default => throw new RuntimeException('Invalid PassportElementError type'),
        };
    }

}
