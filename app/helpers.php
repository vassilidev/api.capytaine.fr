<?php

/**
 * Formats JSON string for better readability.
 *
 * @throws JsonException
 */
function prettyJson(mixed $json): string
{
    $result = '';
    $level = 0;
    $inQuotes = false;
    $inEscape = false;
    $endsLineLevel = null;

    if (!is_string($json)) {
        $json = json_encode($json, JSON_THROW_ON_ERROR);
    }

    $jsonLength = strlen($json);

    for ($i = 0; $i < $jsonLength; $i++) {
        $char = $json[$i];
        $newLineLevel = null;
        $post = "";

        if ($endsLineLevel !== null) {
            $newLineLevel = $endsLineLevel;
            $endsLineLevel = null;
        }

        if ($inEscape) {
            $inEscape = false;
        } elseif ($char === '"') {
            $inQuotes = !$inQuotes;
        } elseif (!$inQuotes) {
            switch ($char) {
                case '}':
                case ']':
                    $level--;
                    $endsLineLevel = null;
                    $newLineLevel = $level;
                    break;

                case '{':
                case '[':
                    $level++;
                case ',':
                    $endsLineLevel = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ":
                case "\t":
                case "\n":
                case "\r":
                    $char = "";
                    $endsLineLevel = $newLineLevel;
                    $newLineLevel = null;
                    break;
            }
        } elseif ($char === '\\') {
            $inEscape = true;
        }

        if ($newLineLevel !== null) {
            $result .= "\n" . str_repeat("\t", $newLineLevel);
        }

        $result .= $char . $post;
    }

    return $result;
}

function extractContentFromHtml(?string $content): ?string
{
    if (empty($content)) {
        return null;
    }

    $contentStripped = strip_tags($content);
    $contentWithAccent = html_entity_decode($contentStripped);

    return preg_replace('/\xc2\xa0/', ' ', $contentWithAccent);
}