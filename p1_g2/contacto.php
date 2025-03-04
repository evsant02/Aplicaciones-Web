<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="autor" content="Eva Santos Sanchez">
    <title>Contacto</title>
</head>
<body>

    <h2>FORMULARIO DE CONTACTO</h2>
    <form action="mailto:evsant02@ucm.es" method="post" enctype="text/plain">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required>
        
        <br><br>
        
        <label for="email">Dirección de email:</label><br>
        <input type="email" id="email" name="email" required>
        
        <br><br>
        
        <fieldset>
            <legend>Motivo de la consulta:</legend>
            <input type="radio" id="evaluacion" name="motivo" value="Evaluación" required>
            <label for="evaluacion">Evaluación</label>
            
            <input type="radio" id="sugerencias" name="motivo" value="Sugerencias">
            <label for="sugerencias">Sugerencias</label>
            
            <input type="radio" id="criticas" name="motivo" value="Críticas">
            <label for="criticas">Críticas</label>
        </fieldset>
        
        <br>
        
        <label for="consulta">Escriba su consulta:</label><br>
        <textarea id="consulta" name="consulta" rows="4" cols="80" required></textarea>
        
        <br><br>
        
        <input type="checkbox" id="terminos" name="terminos" required>
        <label for="terminos">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
        
        <br><br>
                
        <input type="reset" name="borrar" value="Borrar formulario">
        <input type="submit" name="enviar" value="Enviar">
        
    </form>
    
    <br><br>
    
</body>
</html>