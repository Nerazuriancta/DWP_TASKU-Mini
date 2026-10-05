<?php
// Escape output yang berasal dari input pengguna sebelum dicetak ke HTML.
function e($value)
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
