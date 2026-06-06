<?php

class SemanticAnalyzer
{
    private array $symbolTable = []; // Guarda las variables registradas y su tipo
    private array $errors = [];      // Almacena los errores semánticos encontrados

    /**
     * Ejecuta el análisis semántico sobre la lista de tokens.
     */
    public function analyze(array $tokens): array
    {
        $this->symbolTable = [];
        $this->errors = [];
        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) {
            $currentToken = $tokens[$i];

            // REGLA 1: Detección de asignación de variables (Declaración/Inferencia)
            // Patrón básico esperado: [T_ID] [T_ASIGNACION] [VALOR]
            if ($currentToken['token'] === 'T_ID') {
                $varName = $currentToken['lexema'];

                // Verificamos si el siguiente token es un signo de asignación '='
                if (isset($tokens[$i + 1]) && $tokens[$i + 1]['token'] === 'T_ASIGNACION') {
                    // El token que define el tipo será el subsiguiente (dos posiciones adelante)
                    if (isset($tokens[$i + 2])) {
                        $valueToken = $tokens[$i + 2];
                        $detectedType = $this->determineType($valueToken);

                        if ($detectedType !== 'UNKNOWN') {
                            // Registramos o actualizamos la variable en nuestra Tabla de Símbolos
                            $this->symbolTable[$varName] = [
                                'tipo' => $detectedType,
                                'lexema' => $varName
                            ];
                        }
                    }
                    // Saltamos el token de asignación en la siguiente iteración
                    $i++; 
                    continue;
                }

                // REGLA 2: Uso de variables no declaradas
                // Si encontramos un T_ID que no está siendo asignado, se está usando en una expresión
                if (!isset($this->symbolTable[$varName])) {
                    $this->errors[] = "Error Semántico: La variable '{$varName}' se utiliza sin haber sido declarada o asignada previamente.";
                }
            }

            // REGLA 3: Validación de operaciones matemáticas (Compatibilidad de tipos)
            // Patrón básico: [OPERANDO_1] [OPERADOR_MATEMÁTICO] [OPERANDO_2]
            if (in_array($currentToken['token'], ['T_SUMA', 'T_RESTA', 'T_MULTIPLICACION', 'T_DIVISION'])) {
                $prevToken = $tokens[$i - 1] ?? null;
                $nextToken = $tokens[$i + 1] ?? null;

                if ($prevToken && $nextToken) {
                    $type1 = $this->getOperandType($prevToken);
                    $type2 = $this->getOperandType($nextToken);

                    // Si alguno de los tipos es STRING en una operación aritmética (excepto sumas si permites concatenar)
                    if ($type1 === 'STRING' || $type2 === 'STRING') {
                        $this->errors[] = "Error Semántico: Operación aritmética no válida entre tipos incompatibles ('{$prevToken['lexema']}' de tipo {$type1} y '{$nextToken['lexema']}' de tipo {$type2}).";
                    }
                }
            }
        }

        return [
            'success' => empty($this->errors),
            'errors'  => $this->errors,
            'symbolTable' => $this->symbolTable
        ];
    }

/**
     * Determina el tipo de dato directo según el token primitivo.
     */
    private function determineType(array $token): string
    {
        return match($token['token']) {
            'T_NUMERO'          => 'NUMBER',
            'T_CADENA'          => 'STRING',
            'T_TRUE', 'T_FALSE' => 'BOOLEAN',
            default             => 'UNKNOWN'
        };
    }

    /**
     * Obtiene el tipo de dato de un operando (sea un valor directo o una variable en la tabla).
     */
    private function getOperandType(array $token): string
    {
        if ($token['token'] === 'T_ID') {
            return $this->symbolTable[$token['lexema']]['tipo'] ?? 'UNDEFINED';
        }
        return $this->determineType($token);
    }
}