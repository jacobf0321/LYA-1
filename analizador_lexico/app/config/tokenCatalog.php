<?php

return [
    'keywords' => [
        'if'     => ['token' => 'T_IF', 'descripcion' => 'palabra clave condicional'],
        'else'   => ['token' => 'T_ELSE', 'descripcion' => 'palabra clave alternativa'],
        'while'  => ['token' => 'T_WHILE', 'descripcion' => 'palabra clave de repetición'],
        'for'    => ['token' => 'T_FOR', 'descripcion' => 'palabra clave de ciclo'],
        'return' => ['token' => 'T_RETURN', 'descripcion' => 'palabra clave de retorno'],
        'true'   => ['token' => 'T_TRUE', 'descripcion' => 'valor lógico verdadero'],
        'false'  => ['token' => 'T_FALSE', 'descripcion' => 'valor lógico falso'],
        'function' => ['token' => 'T_FUNCTION', 'descripcion' => 'palabra clave de función'],
        'echo'   => ['token' => 'T_ECHO', 'descripcion' => 'salida de texto'],
    ],

    'operators' => [
        '===' => ['token' => 'T_IDENTICO', 'descripcion' => 'comparación idéntica'],
        '!==' => ['token' => 'T_NO_IDENTICO', 'descripcion' => 'comparación no idéntica'],
        '=='  => ['token' => 'T_IGUAL', 'descripcion' => 'comparación'],
        '!='  => ['token' => 'T_DIFERENTE', 'descripcion' => 'diferente'],
        '<='  => ['token' => 'T_MENOR_IGUAL', 'descripcion' => 'menor o igual'],
        '>='  => ['token' => 'T_MAYOR_IGUAL', 'descripcion' => 'mayor o igual'],
        '&&'  => ['token' => 'T_AND', 'descripcion' => 'operador lógico AND'],
        '||'  => ['token' => 'T_OR', 'descripcion' => 'operador lógico OR'],
        '++'  => ['token' => 'T_INCREMENTO', 'descripcion' => 'incremento'],
        '--'  => ['token' => 'T_DECREMENTO', 'descripcion' => 'decremento'],
        '+'   => ['token' => 'T_SUMA', 'descripcion' => 'suma'],
        '-'   => ['token' => 'T_RESTA', 'descripcion' => 'resta'],
        '*'   => ['token' => 'T_MULTIPLICACION', 'descripcion' => 'multiplicación'],
        '/'   => ['token' => 'T_DIVISION', 'descripcion' => 'división'],
        '%'   => ['token' => 'T_MODULO', 'descripcion' => 'módulo'],
        '='   => ['token' => 'T_ASIGNACION', 'descripcion' => 'asignación'],
        '<'   => ['token' => 'T_MENOR_QUE', 'descripcion' => 'menor que'],
        '>'   => ['token' => 'T_MAYOR_QUE', 'descripcion' => 'mayor que'],
        '!'   => ['token' => 'T_NEGACION', 'descripcion' => 'negación'],
    ],

    'punctuation' => [
        '(' => ['token' => 'T_PAR_IZQ', 'descripcion' => 'paréntesis izquierdo'],
        ')' => ['token' => 'T_PAR_DER', 'descripcion' => 'paréntesis derecho'],
        '{' => ['token' => 'T_LLAVE_IZQ', 'descripcion' => 'llave izquierda'],
        '}' => ['token' => 'T_LLAVE_DER', 'descripcion' => 'llave derecha'],
        '[' => ['token' => 'T_CORCHETE_IZQ', 'descripcion' => 'corchete izquierdo'],
        ']' => ['token' => 'T_CORCHETE_DER', 'descripcion' => 'corchete derecho'],
        ',' => ['token' => 'T_COMA', 'descripcion' => 'coma'],
        ';' => ['token' => 'T_PUNTO_Y_COMA', 'descripcion' => 'punto y coma'],
        '.' => ['token' => 'T_PUNTO', 'descripcion' => 'punto'],
    ],
];