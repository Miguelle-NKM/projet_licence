 <?php
        // Récupérer le paramètre 'page' de l'URL
        $page = isset($_GET['page']) ? $_GET['page'] : 'accueil'; // Page par défaut

        // Nettoyer le nom de la page pour éviter les injections de chemin
        $page = htmlspecialchars($page);

        // Définir les pages autorisées
        $allowed_pages = [
            'accueil',          // Nouvelle page d'accueil (public)
            'rooms_public',     // Page des chambres (public)
            'event_hall',       // Page de la salle de fête (public)
            'restaurants',      // Page des restaurants (public)
            'contact',          // Page de contact (public)
            'search_results',   // Page des résultats de recherche de chambres
            'menu_view',        // Page pour consulter le menu du restaurant
            'login',            // Page de connexion (pour l'admin ou les clients)

            // Pages de l'administration (si elles coexistent dans le même index.php)
            'dashboard',
            'bookings',
            'rooms_tariffs',
            'clients',
            'reports',
            'settings',
            'logout'
        ];

        // Vérifier si la page demandée est autorisée
        if (in_array($page, $allowed_pages)) {
            $file_path = 'pages/' . $page . '.php'; // Chemin vers le fichier de la page

            // Vérifier si le fichier de la page existe
            if (file_exists($file_path)) {
                include $file_path; // Inclure le contenu de la page
            } else {
                // Si le fichier n'existe pas, afficher une erreur ou rediriger
                echo '<div class="text-center text-red-500 font-bold text-xl p-8">Page non trouvée.</div>';
            }
        } else {
            // Si la page n'est pas autorisée, afficher une erreur ou rediriger vers la page d'accueil
            echo '<div class="text-center text-red-500 font-bold text-xl p-8">Accès non autorisé à cette page.</div>';
            // Optionnel: Rediriger vers la page d'accueil
            // header('Location: ?page=accueil');
            // exit();
        }
        ?>