<?php 
include_once ("/vendor/autoload.php");

echo pageHeader("Service Account Access");
/************************************************
  Make an API request authenticated with a service
  account.
 ************************************************/
$client = new Google_Client();
/************************************************
  ATTENTION: Fill in these values, or make sure you
  have set the GOOGLE_APPLICATION_CREDENTIALS
  environment variable. You can get these credentials
  by creating a new Service Account in the
  API console. Be sure to store the key file
  somewhere you can get to it - though in real
  operations you'd want to make sure it wasn't
  accessible from the webserver!
  Make sure the Books API is enabled on this
  account as well, or the call will fail.
 ************************************************/
if ($credentials_file = checkServiceAccountCredentialsFile()) {
  // set the location manually
  $client->setAuthConfig($credentials_file);
} elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
  // use the application default credentials
  $client->useApplicationDefaultCredentials();
} else {
  echo missingServiceAccountDetailsWarning();
  return;
}
$client->setApplicationName("Client_Library_Examples");
$client->setScopes(['https://www.googleapis.com/auth/books']);
$service = new Google_Service_Books($client);
/************************************************
  We're just going to make the same call as in the
  simple query as an example.
 ************************************************/
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
?>

<h3>Results Of Call:</h3>
<?php foreach ($results as $item): ?>
  <?= $item['volumeInfo']['title'] ?>
  <br />
<?php endforeach ?>

<?php pageFooter(__FILE__); ?>
?>
