<h1?php
if (isset($_GET["recherche"])){
    $code=$_GET["recherche"];
    header("Location:menu.php?Recherche=". urlencode($code));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reminder GEEAD INPHB</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/icon.png" sizes="32x32" type="image/png">
    <style>
        /* Styles pour améliorer l'affichage des cards */
        .categories-grid {
            padding-top: 5rem;
        }

        
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 0 auto 1.5rem;
            border: none;
            opacity:0.9;
            top: 100;
            height:400px;
        }

        .text-none{
            color: rgb(59, 126, 59);
            text-align: center;
            width: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .image-card {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .card-body {
            padding: 1.25rem;
            background-color: #fff;
        }
        
        .card-text {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card {
                width: 100% !important;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div id="menu-page" class="page-menu">
        <div class="background-image"></div>
        <nav class="navbar">
            <div class="container-fluid Navcc">
                <a class="navbar-brand" href="./index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    <span class="textre">REMINDER</span>
                </a>
            </div>
        </nav>
        <div class="container">
            <form action="" method="get">
                <div class="input-group mb-4 mt-3">
                    <input type="text" class="form-control" placeholder="Rechercher une prédication" aria-describedby="button-addon2" id="recherche" name="recherche">
                    <button class="btt" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        
        <section class="categories-grid">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php

                    $supabase_url = "https://liqycycrxtpgelbtiotf.supabase.co";
                    $supabase_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImxpcXljeWNyeHRwZ2VsYnRpb3RmIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDAzOTQ2MTksImV4cCI6MjA1NTk3MDYxOX0.OmmJHySBlj75xFnvikUiIN7ADjyt3Z1UgTMijRU4OYY";

                    function fetch_data($path, $supabase_url, $supabase_key) {
                        $url = $supabase_url . $path;
                        
                        $headers = [
                            "apikey: $supabase_key",
                            "Authorization: Bearer $supabase_key",
                            "Content-Type: application/json",
                            "Accept: application/json",
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);
                        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                        if ($http_code == 200) {
                            return json_decode($response, true);
                        } else {
                            return [];
                        }
                    }

                    // Fonction pour tronquer le texte
                    function truncate_text($text, $length = 50) {
                        if (strlen($text) > $length) {
                            return substr($text, 0, $length) . "..."; // Tronquer et ajouter des points de suspension
                        }
                        return $text; // Retourner le texte tel quel s'il est plus court que la longueur spécifiée
                    }

                    // Récupérer toutes les prédications
                    if(isset($_GET["Recherche"]) && !empty($_GET["Recherche"])){
                        $search_term = $_GET['Recherche'];
                        $all_predications = fetch_data("/rest/v1/predication?select=*&theme=ilike.". urlencode("%$search_term%"), $supabase_url, $supabase_key);
                    }
                    else{
                        $all_predications = fetch_data("/rest/v1/predication?select=*", $supabase_url, $supabase_key);
                    }

                    // Vérifier si des données ont été retournées
                    if (!empty($all_predications)) {
                        // Parcourir les prédications avec une boucle foreach
                        foreach ($all_predications as $predication) { ?>
                            <!-- Card 1 -->
                            <div class="col">
                                    <div class="card">
                                        <a href="./detail.php?Detail=<?= $predication["id"] ?>"><img src="./assets/css/image.jpg" class="image-card" alt="Prédication"></a>
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size:20px;font-weight:bold"><?= $predication['theme'] ?></h5>
                                            <p class="card-text"><?= truncate_text($predication['contenu'], 50) ?></p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted"><?= $predication['dated'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    <?php }?>
                    <?php } else { ?>
                        <h2 class="text-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clipboard-x-fill" viewBox="0 0 16 16">
  <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"/>
  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4 7.793 1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
</svg> <br> Aucune prédication disponible</h2>
                    <?php }?>
                </div>
            </div>
        </section>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>