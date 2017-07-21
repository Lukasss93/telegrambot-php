<?php

namespace TelegramBot\Types;

/** This object represents a sticker. */
class MaskPosition
{
    /** @var string The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”. */
    public $point;

    /** @var float Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing -1.0 will place mask just to the left of the default mask position. */
    public $x_shift;

    /** @var float Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will place the mask just below the default mask position. */
    public $y_shift;

    /** @var float Mask scaling coefficient. For example, 2.0 means double size. */
    public $zoom;
}