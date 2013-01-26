<?php

/* String API concept: Case Insensitive View
 *
 * This concept implements a way of handling case-insensitive search and replace operations
 * on strings. Instead of adding a new set of methods for case-insensitive operations (or
 * adding additional flags) this approach adds a caseInsensitive() method that returns a
 * case insensitive view on the string. The respective methods are then invoked on that
 * object.
 *
 * Usage Examples:
 *
 *     $str->caseInsensitive()->startsWith('foo')
 *     $str->caseInsensitive()->replace(['foo' => 'bar', 'bar' => 'foo'])
 *
 */

namespace str;

class HandlerWithCaseInsensitiveView extends Handler {
    return new CaseInsensitiveView($this);
}

class CaseInsensitiveView {
    protected $str;

    public function __construct($str) {
        $this->str = $str;
    }

    public function indexOf($string, $offset = 0) {
        return stripos($this->str, $string, $offset);
    }

    public function lastIndexOf($string, $offset = 0) {
        return strripos($this->str, $string, $offset);
    }

    public function contains($string) {
        return false !== $this->indexOf($string);
    }

    public function startsWith($string) {
        return 0 === $this->indexOf($string);
    }

    public function endsWith($string) {
        return $this->lastIndexOf($string) === $this->str->length() - $string->str->length();
    }

    public function count($string, $offset = 0, $length = null) {
        $slice = $string->slice($offset, $length);

        $index = 0;
        $count = 0;
        while (false !== $index = $this->indexOf($string, $index + $string->length())) {
            ++$count;
        }

        return $count;
    }

    public function replace($arg1, $arg2 = null) {
        if (null === $arg2) {
            $arg2 = array_values($arg1);
            $arg1 = array_keys($arg1);
        }

        return str_ireplace($arg1, $arg2, $this->str);
    }

    public function split($separator, $limit = PHP_INT_MAX) {
        /* TODO */
    }
}
