<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Thomas Garcia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            display: flex;
        }
        .left-column {
            width: 35%;
            padding-right: 20px;
            border-right: 1px solid #333;
        }
        .right-column {
            width: 65%;
            padding-left: 20px;
        }
        h1 {
            margin-bottom: 5px;
            font-size: 24px;
        }
        h2 {
            font-size: 18px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-top: 25px;
        }
        h3 {
            font-size: 16px;
            margin-bottom: 5px;
            margin-top: 20px;
        }
        .subtitle {
            font-weight: bold;
            margin-top: 0;
            font-size: 14px;
        }
        ul {
            margin-top: 5px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 3px;
        }
        .divider {
            border-top: 1px solid #333;
            margin: 15px 0;
        }
        .contact-info {
            margin-top: 15px;
        }
        .contact-item {
            margin-bottom: 5px;
        }
        .experience {
            margin-bottom: 20px;
            display: flex;
        }
        .experience-date {
            font-weight: bold;
            width: 120px;
            flex-shrink: 0;
        }
        .experience-content {
            flex-grow: 1;
        }
        .experience-company {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .experience-position {
            font-style: italic;
            margin-bottom: 5px;
        }
        .skills-columns {
            display: flex;
            justify-content: space-between;
        }
        .skills-column {
            width: 48%;
        }
        .profile-photo {
            width: 150px;
            height: 150px;
            background-color: #ddd;
            margin-bottom: 20px;
            border: 1px solid #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Colonne de gauche -->
        <div class="left-column">
            <div class="profile-photo"></div>
            <h1>Thomas Garcia</h1>
            <p class="subtitle">COMMERCIAL</p>

            <h3>PROFIL</h3>
            <p>Déterminé, sérieux, autonome et conscient du travail qui m'attend, je suis persuadé que je serais un élément majeur au sein de votre structure !</p>
            
            <div class="divider"></div>
            
            <h3>CONTACT</h3>
            <div class="contact-info">
                <div class="contact-item">125 Anywhere St., AnyCity</div>
                <div class="contact-item">helloareollygreatsite.com</div>
                <div class="contact-item">125-456-7890</div>
                <div class="contact-item">Permis</div>
            </div>
            
            <div class="divider"></div>
            
            <h3>SCOSTS:</h3>
            <p>Football, Vélo, Natation</p>
            
            <h3>VOYAGES:</h3>
            <p>Italie, Espagne, Angleterre</p>
        </div>

        <!-- Colonne de droite -->
        <div class="right-column">
            <h2>FORMATION</h2>
            <h3>2022 - Master spécialisé en marketing - École de commerce</h3>
            <p>2020 - Licence commerce vente et marketing - École 1</p>
            <p>2019 - BTS communication - Lycée 2</p>
            <p>2017 - Bac littéraire (spécialité cinéma) - Lycée 1</p>
            
            <h2>EXPÉRIENCES</h2>
            
            <div class="experience">
                <div class="experience-date">12/12/2024</div>
                <div class="experience-content">
                    <div class="experience-company">Durrence Média</div>
                    <div class="experience-position">CHARGÉ DE COMMUNICATION & MARKETING</div>
                    <ul>
                        <li>Lancement complète d'une marque</li>
                        <li>Communication : gestion des réseaux sociaux</li>
                        <li>BP (communiqués et dossiers de presse)</li>
                        <li>Pixel (où est calculé, catalogue)</li>
                    </ul>
                </div>
            </div>
            
            <div class="experience">
                <div class="experience-date"></div>
                <div class="experience-content">
                    <div class="experience-position">ASSISTANTE MARKETING SERVICE SUPPORT</div>
                    <ul>
                        <li>Soleur / Femme</li>
                        <li>Organisation des vitres lycées pour les chargés de recrutement</li>
                    </ul>
                </div>
            </div>
            
            <div class="experience">
                <div class="experience-date"></div>
                <div class="experience-content">
                    <div class="experience-position">CHARGÉE DE COMMUNICATION</div>
                    <ul>
                        <li>Réduction hautmarque, banderoles, affiches, post sur les réseaux sociaux</li>
                        <li>Mise en place d'un passecom : prospection des lots</li>
                        <li>Service accueil et photographie</li>
                    </ul>
                </div>
            </div>
            
            <div class="experience">
                <div class="experience-date"></div>
                <div class="experience-content">
                    <div class="experience-position">CHARGÉ DE COMMUNICATION</div>
                    <ul>
                        <li>Réduction plaquette commerciale, logo, affiches...</li>
                        <li>Organisation d'événements (événements, tournoi de pétanque)</li>
                        <li>Gestion administrative, site web, réseaux sociaux, publipostages</li>
                        <li>Interviews sur le terrain, journaliste sportive, montage, publication</li>
                    </ul>
                </div>
            </div>
            
            <h2>COMPÉTENCES</h2>
            
            <div class="skills-columns">
                <div class="skills-column">
                    <h3>LANGUES</h3>
                    <p>Anglais : Bilingue</p>
                    <p>Anglais : Niveau scolaire</p>
                    <p>Espagnol : Niveau scolaire</p>
                </div>
                <div class="skills-column">
                    <h3>LOGICIELS MAÎTRISÉS</h3>
                    <p>Logiciel 1</p>
                    <p>Logiciel 2</p>
                    <p>Logiciel 3</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>