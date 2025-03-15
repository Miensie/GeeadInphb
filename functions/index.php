<!DOCTYPE html>
<html>

<head>
  <base href="/">

  <meta charset="UTF-8">
  <meta content="IE=Edge" http-equiv="X-UA-Compatible">
  <meta name="description" content="Flet application.">

  <!-- iOS meta tags & icons -->
  
  <meta http-equiv="refresh" content="4;url=accueil.php">
  <link rel="icon" href="assets/img/icon.png" sizes="32x32" type="image/png">

  <title>Reminder GEEAD INPHB</title>
  <link rel="manifest" href="manifest.json">
</head>

<body>
  <div id="loading">
    <style>
      body {
        inset: 0;
        overflow: hidden;
        margin: 0;
        padding: 0;
        position: fixed;
      }

      #loading {
        align-items: center;
        display: flex;
        height: 100%;
        justify-content: center;
        width: 100%;
      }

      #loading img {
        animation: 1s ease-in-out 0s infinite alternate breathe;
        opacity: .66;
        transition: opacity .4s;
      }

      #loading.main_done img {
        opacity: 1;
      }

      #loading.init_done img {
        animation: .33s ease-in-out 0s 1 forwards zooooom;
        opacity: .05;
      }

      @keyframes breathe {
        from {
          transform: scale(0.4);
          opacity: 1.0;
        }

        to {
          transform: scale(0.35);
          opacity: .7;
        }
      }

      @keyframes zooooom {
        from {
          transform: scale(0.4)
        }

        to {
          transform: scale(10)
        }
      }
    </style>
    <img src="./assets/css/bible.jpg" alt="Loading..." />
  </div>
</body>
</html>