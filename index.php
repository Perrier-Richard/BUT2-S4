<!DOCTYPE html>
<html>
    <head>
        <title>Projet de Blog</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"
          data-cfasync="false"></script>
        <script  type="module" src="Client/cookieconsent.js" defer></script>

        <script type="module" src="Client/home.js" defer></script>

        <link href="CSS/header.css" rel="stylesheet"/>
        <link href="CSS/home.css" rel="stylesheet"/>
        <link href="CSS/main.css" rel="stylesheet"/>
        <link href="CSS/footer.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css"
        rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>
            <?php include("header.html"); ?>
        </header>
        <main>
            <script type="module" src="Client/home.js" defer></script>
            <section id="central">
                <template id="template-billet">
                    <article class="billet textcolor">
                        <div class="selector">
                            <div class="text-billet">
                                <span class="titre-billet">Titre</span>
                                <span class="contenu-billet">Content</span>
                            </div>
                            <div class="detail-billet">
                                <span class="post-date">00/00/0000</span>
                                <span class="comment-count">X Commentaires</span>
                            </div>
                        </div>
                    </article>
                </template>

                <template id="add-ticket-template">
                    <div id="add-ticket-holder">
                        <button id="add-ticket">Ajouter un billet</button>
                    </div>
                </template>
                <section id="liste-billets">
                    <span class="billet">/!\ Unable to load content /!\</span>
                </section>
                <section id="page-selector">
                        <button class="page-select first">|<</button>
                        <button class="page-select previous"><</button>
                        <span id="page-number">X</span>
                        <button class="page-select next">></button>
                        <button class="page-select last">>|</button>
                </section>
            </section>
        </main>
        <footer>
            <?php include("footer.html"); ?>
        </footer>
    </body>
</html>