<?php

require_once('services/ApiCaller.php');

$apiCaller = new ApiCaller();

try {
  $news = $apiCaller->getNewsFromCountry('us');
} catch (Exception $e) {
  echo $e->getMessage();
}


/**
 * On va appeler les méthodes 
 * de notre ApiCaller pour
 * récupérer les informations
 * et les afficher dans la vue
 */


?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>US News</title>
</head>

<body>
  <div class="container pb-5">
    <!-- Bootstrap & Bootstrap icons dispo ainsi qu'un lien vers un fichier .css, un .js et un dossier img si besoin -->
    <h1 class="text-center py-5 title">Latest News From US</h1>
    <div class="row row-gap-5">
      <?php foreach ($news['articles'] as $article) : ?>
        <?php if ($article['urlToImage'] == null) continue; ?>
        <?php if ($article['description'] == null) continue; ?>
        <?php
        $publishedAt = $article['publishedAt'];
        $dateTime = new DateTime();
        $dateTime->setTimestamp(strtotime($publishedAt));
        $currentDate = time();
        $DT1 = new DateTime("@{$dateTime->getTimestamp()}");
        $DT2 = new DateTime("@{$currentDate}");
        $diff = $DT1->diff($DT2);
        ?>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="card h-100 shadow">
            <img src="<?php echo $article['urlToImage']; ?>" class="card-img-top" alt="Image de l'article">
            <div class="card-body d-flex flex-column">
              <h2 class="card-title fs-5 mb-3"><?php echo $article['title']; ?></h2>
              <p class="card-text"><?php echo $article['description']; ?></p>
              <!-- On affiche la date de publication de l'article 
              <p>Published at : <?php //echo $dateTime->format('d-m-Y H:i:s'); 
                                ?></p>-->
              <p>Published <?php //affiche depuis combien de temps l'article a été publié
                            echo $diff->d . ' day(s), ' . $diff->h . ' hour(s), ' . $diff->i . ' minute(s)'; ?> ago</p>
              <a href="<?php echo $article['url']; ?>" class="btn btn-info mt-auto" target="_blank">Read the article</a>
            </div>
          </div>
        </div>

      <?php endforeach; ?>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</body>

</html>