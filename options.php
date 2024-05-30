<!DOCTYPE html>
<html>
    <head>
        <title>Projet de Blog</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="module" src="Client/options.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="CSS/header.css" rel="stylesheet"/>
        <link href="CSS/options.css" rel="stylesheet"/>
        <link href="CSS/main.css" rel="stylesheet"/>
        <link href="CSS/footer.css" rel="stylesheet"/>
    </head>
    <body>
        <header>
            <?php include("header.html"); ?>
        </header>
        <main>
            <section id="central">
                <section id="settings-form">
                    <article id="settings-article">
                        <form id="form-settings">
                        <h2> Options du blog </h2>
                            <div>
                                <label for="ticketsPerPage">Billets par page : </label>
                                <select name='ticketsPerPage'>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <hr>
                            <div>
                                <label for="commentsPerPage">Commentaires par page : </label>
                                <select name='commentsPerPage'>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select> 
                            </div>
                            <hr>
                            <div>
                                <label for="colorPage"> Couleur du site : </label>
                                <select name='colorPage'>
                                    <option value="default"> Default </option>
                                    <option value="night"> Nuit </option>
                                    <option value="pink"> Baby Pink </option>
                                    <option value="green"> Jade </option>
                                    <option value="purple"> Améthyste </option>
                                    <option value="coquelicot"> Ruby </option>
                                    <option value="gold"> Gold </option>
                                    
                                    
                                </select>
                            </div>
                            <button type='submit'>Sauvegarder</button>
                        </form>
                        <form id="form-account">
                            <h2> Options du compte </h2>
                            <input type="hidden" name="username0">
                            <div>
                                <label for="username">Nom d'utilisateur : </label>
                                <input type="text" name="username">
                            </div>
                            <hr>
                            <div>
                                <label for="password">Nouveau mot de passe : </label>
                                <input type="password" name="password" required>
                            </div>
                            <div>
                                <label for="password2">Confirmer le mot de passe : </label>
                                <input type="password" name="password2" required>
                            </div>
                            <hr>
                            <div id="current-password">
                                <label for="password3">Mot de passe actuel : </label>
                                <input type="password" name="password3">
                            </div>
                            <button type='submit'>Sauvegarder</button>
                        </form>
                    </article> 
                </section>
            </section>
        </main>
        <footer>
            <?php include("footer.html"); ?>
        </footer>
    </body>
</html>