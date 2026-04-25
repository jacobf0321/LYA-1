<?php

class LexerModel
{
    private array $catalog;
    private array $operatorLexemes = [];
    private array $punctuationLexemes = [];

    public function __construct(array $catalog)
    {
        $this->catalog = $catalog;

        $this->operatorLexemes = array_keys($catalog['operators']);
        usort($this->operatorLexemes, fn($a, $b) => strlen($b) <=> strlen($a));

        $this->punctuationLexemes = array_keys($catalog['punctuation']);
    }

    public function tokenize(string $input): array
    {
        $tokens = [];
        $length = strlen($input);
        $i = 0;

        while ($i < $length) {
            $char = $input[$i];

            if (ctype_space($char)) {
                $i++;
                continue;
            }

            // 1) Cadenas literales
            if ($char === '"' || $char === "'") {
                $quote = $char;
                $start = $i;
                $i++;
                $lexeme = $quote;

                while ($i < $length && $input[$i] !== $quote) {
                    if ($input[$i] === '\\' && $i + 1 < $length) {
                        $lexeme .= $input[$i] . $input[$i + 1];
                        $i += 2;
                        continue;
                    }
                    $lexeme .= $input[$i];
                    $i++;
                }

                if ($i < $length) {
                    $lexeme .= $input[$i];
                    $i++;
                }

                $tokens[] = [
                    'token' => 'T_CADENA',
                    'descripcion' => 'cadena literal',
                    'lexema' => $lexeme,
                    'atributo' => trim($lexeme, "\"'")
                ];
                continue;
            }

            // 2) Números enteros o decimales
            if (ctype_digit($char)) {
                $start = $i;
                $hasDot = false;

                while ($i < $length) {
                    if (ctype_digit($input[$i])) {
                        $i++;
                        continue;
                    }
                    if ($input[$i] === '.' && !$hasDot && $i + 1 < $length && ctype_digit($input[$i + 1])) {
                        $hasDot = true;
                        $i++;
                        continue;
                    }
                    break;
                }

                $lexeme = substr($input, $start, $i - $start);

                $tokens[] = [
                    'token' => 'T_NUMERO',
                    'descripcion' => 'constante numérica',
                    'lexema' => $lexeme,
                    'atributo' => is_numeric($lexeme) ? $lexeme + 0 : null
                ];
                continue;
            }

            // 3) Identificadores o palabras clave
            if (ctype_alpha($char) || $char === '_') {
                $start = $i;
                $i++;

                while ($i < $length && (ctype_alnum($input[$i]) || $input[$i] === '_')) {
                    $i++;
                }

                $lexeme = substr($input, $start, $i - $start);

                if (isset($this->catalog['keywords'][$lexeme])) {
                    $info = $this->catalog['keywords'][$lexeme];
                    $tokens[] = [
                        'token' => $info['token'],
                        'descripcion' => $info['descripcion'],
                        'lexema' => $lexeme,
                        'atributo' => null
                    ];
                } else {
                    $tokens[] = [
                        'token' => 'T_ID',
                        'descripcion' => 'identificador',
                        'lexema' => $lexeme,
                        'atributo' => $lexeme
                    ];
                }
                continue;
            }

            // 4) Operadores
            $matched = false;
            foreach ($this->operatorLexemes as $op) {
                $len = strlen($op);
                if (substr($input, $i, $len) === $op) {
                    $info = $this->catalog['operators'][$op];
                    $tokens[] = [
                        'token' => $info['token'],
                        'descripcion' => $info['descripcion'],
                        'lexema' => $op,
                        'atributo' => null
                    ];
                    $i += $len;
                    $matched = true;
                    break;
                }
            }
            if ($matched) {
                continue;
            }

            // 5) Signos de puntuación
            if (isset($this->catalog['punctuation'][$char])) {
                $info = $this->catalog['punctuation'][$char];
                $tokens[] = [
                    'token' => $info['token'],
                    'descripcion' => $info['descripcion'],
                    'lexema' => $char,
                    'atributo' => null
                ];
                $i++;
                continue;
            }

            // 6) Desconocido
            $tokens[] = [
                'token' => 'T_DESCONOCIDO',
                'descripcion' => 'símbolo no reconocido',
                'lexema' => $char,
                'atributo' => null
            ];
            $i++;
        }

        return $tokens;
    }
}