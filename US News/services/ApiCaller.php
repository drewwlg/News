<?php

class ApiCaller
{

  /**
   * Les informations concernant l'api à contacter
   */
  private string $base_url =  'https://newsapi.org/v2';

  private string $appId = '44d79cb547584bc98f194293fa523aab';


  /**
   * Les différentes méthodes pour interroger
   */
  public function getNewsFromCountry(string $country): array
  {

    $url = $this->base_url . '/top-headlines?country=' . urlencode($country) . '&apiKey=' . urlencode($this->appId);
    return $this->callApi($url);
  }

  /**
   * Effectue une requête à l'API en utilisant cURL.
   * 
   * @param string $url L'URL de l'API.
   * @return array Les données de la réponse à l'API.
   * @throws Exception En cas d'erreur lors de la requête cURL.
   */
  private function callApi(string $url): array
  {
    // Initialisation de l'objet cURL
    $ch = curl_init();

    // Configuration de l'URL de la requête
    curl_setopt($ch, CURLOPT_URL, $url);

    //Ajout du User Agent
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

    // Indique à cURL de retourner le résultat sous forme de chaîne
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Désactiver temporairement la vérification du certificat SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Exécution de la requête
    $response = curl_exec($ch);

    // Vérification des erreurs lors de l'exécution de la requête
    if ($response === false) {
      throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    // Fermerture de la session cURL
    curl_close($ch);

    // Retourne la réponse de l'API décodée depuis JSON vers un tableau associatif
    return json_decode($response, true);
  }
}
