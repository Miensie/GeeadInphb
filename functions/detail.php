<?php
if (isset($_GET["recherche"])){
    $code=$_GET["recherche"];
    header("Location:menu.php?Recherche=". urlencode($code));
    exit; // Toujours sortir après une redirection
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
            padding-top: 12rem;
        }
        
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            margin: 0 auto 1.5rem;
            border: none;
            opacity: 0.9;
            /* Suppression de la hauteur fixe pour adapter à son contenu */
            height: auto;
            max-width: 900px;
            width: 90%;
        }

        .text-none{
            color: rgb(59, 126, 59);
            text-align: center;
            width: 100%;
        }
        
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .image-card {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .image-card1 {
            padding-top: 30px;
            height: 350px;
            width: 450px;
            object-fit: cover;
            border-radius: 10px;
            margin: 0 auto;
            display: block;
        }
        
        .card-body {
            padding: 2rem;
            background-color: #fff;
        }
        
        .card-text {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
            /* Préserver les sauts de ligne */
            white-space: pre-line;
        }
        
        .card-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .card-subtitle {
            color: #666;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .date-info {
            font-style: italic;
            color: #777;
            margin-bottom: 1.5rem;
            display: block;
        }
        
        .content-area {
            margin-top: 1.5rem;
            /* Assurer que le texte n'est pas coupé */
            overflow: visible;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card {
                width: 95%;
            }
            
            .image-card1 {
                width: 100%;
                max-width: 350px;
                height: auto;
                padding-top: 7px;
            }
        }
    </style>
</head>
<body>
    <div id="menu-page" class="page-menu">
        <div class="background-image"></div>
        <nav class="navbar">
            <div class="container-fluid Navcc">
                <a class="navbar-brand" href="./menu.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    <span class="textre">REMINDER</span>
                </a>
            </div>
        </nav>
        <div class="container mt-5 pt-5">
            <div class="text-center">
                <img src="./assets/css/image.jpg" class="image-card1" alt="Prédication">
            </div>
            
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
                    curl_close($ch);

                    if ($http_code == 200) {
                        return json_decode($response, true);
                    } else {
                        return [];
                    }
                }

                // Récupérer la prédication par ID
                if(!empty($_GET["Detail"])){
                    $search_term = $_GET['Detail'];
                    $predications = fetch_data("/rest/v1/predication?select=*&id=eq.". $search_term, $supabase_url, $supabase_key);
                
                    if (!empty($predications) && is_array($predications) && count($predications) > 0) {
                        $predication = $predications[0]; // Prendre le premier résultat
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="text-align:center"><?= htmlspecialchars($predication['theme']) ?></h5>
                                
                                <?php if (!empty($predication['texte'])): ?>
                                <h6 class="card-subtitle">
                                <?php 
                                    // Préserver les sauts de ligne du contenu
                                    $content = nl2br(htmlspecialchars($predication['texte']));
                                    echo $content;
                                    ?>
                                </h6>
                                <?php endif; ?>
                                
                                <span class="date-info"><?= htmlspecialchars($predication['dated']) ?></span>
                                
                                <div class="content-area" style="text-align:justify">
                                    <?php 
                                    // Préserver les sauts de ligne du contenu
                                    $content = nl2br(htmlspecialchars($predication['contenu']));
                                    echo $content;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<div class="card"><div class="card-body"><h5 class="card-title text-center">Prédication non trouvée</h5></div></div>';
                    }
                } else {
                    echo '<div class="card"><div class="card-body"><h5 class="card-title text-center">Aucun identifiant de prédication fourni</h5></div></div>';
                }
            ?>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>