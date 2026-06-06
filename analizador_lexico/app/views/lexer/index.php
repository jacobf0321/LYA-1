<?php
function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analizador Léxico y Semántico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f7f7f7; }
        .container { max-width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        textarea { width: 100%; height: 120px; padding: 10px; font-size: 16px; box-sizing: border-box; }
        button { padding: 10px 18px; font-size: 16px; margin-top: 10px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #222; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
        
        /* Nuevos estilos para la sección Semántica */
        .error-box { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin-top: 20px; border-radius: 5px; }
        .error-box ul { margin: 5px 0 0 20px; padding: 0; }
        .success-box { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin-top: 20px; border-radius: 5px; }
        .symbol-th { background: #1b4f72; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <h1>Analizador Léxico y Semántico</h1>

    <form method="POST">
        <label for="input">Escribe tu flujo de caracteres:</label>
        <textarea name="input" id="input"><?= e($input ?? '') ?></textarea>
        <br>
        <button type="submit">Analizar Código</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if (!$semanticResult['success']): ?>
            <div class="error-box">
                <strong>⚠️ Errores Semánticos Detectados:</strong>
                <ul>
                    <?php foreach ($semanticResult['errors'] as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?> </ul>
            </div>
        <?php else: ?>
            <div class="success-box">
                <strong>✅ Análisis Semántico correcto:</strong> No se detectaron errores de tipos ni variables indefinidas.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <?php if (!empty($tokens)): ?>
            <div style="flex: 1; min-width: 450px;">
                <h2>Salida de tokens (Léxico)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Descripción informal</th>
                            <th>Lexema</th>
                            <th>Atributo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tokens as $t): ?>
                            <tr>
                                <td><?= e($t['token']) ?></td>
                                <td><?= e($t['descripcion']) ?></td>
                                <td><?= e($t['lexema']) ?></td>
                                <td><?= e((string)($t['atributo'] ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div style="flex: 1; min-width: 350px;">
                <h2>Tabla de Símbolos (Semántico)</h2>
                <?php if (!empty($semanticResult['symbolTable'])): ?>
                    <table>
                        <thead>
                            <tr>
                                <th class="symbol-th">Variable (Lexema)</th>
                                <th class="symbol-th">Tipo Asignado / Inferido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($semanticResult['symbolTable'] as $name => $info): ?>
                                <tr>
                                    <td><strong><?= e($name) ?></strong></td>
                                    <td><?= e($info['tipo']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="color: #666; font-style: italic; margin-top: 20px;">No se registraron variables en este bloque.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
</body>
</html>