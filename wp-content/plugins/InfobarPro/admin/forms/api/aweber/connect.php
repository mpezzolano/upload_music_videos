<?php
require_once('aweber_api.php');
// Replace with the keys of your application
// NEVER SHARE OR DISTRIBUTE YOUR APPLICATIONS'S KEYS!
$consumerKey    = "AkrKSYMkyxSzH5tfpU282XJI";
$consumerSecret = "LtLq9Pilg62ytgv0LYf6U0W6zAiWHujclMJIP80J";

$aweber = new AWeberAPI($consumerKey, $consumerSecret);

if (empty($_COOKIE['accessToken'])) {
    if (empty($_GET['oauth_token'])) {
        $callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        list($requestToken, $requestTokenSecret) = $aweber->getRequestToken($callbackUrl);
        setcookie('requestTokenSecret', $requestTokenSecret);
        setcookie('callbackUrl', $callbackUrl);
        header("Location: {$aweber->getAuthorizeUrl()}");
        exit();
    }

    $aweber->user->tokenSecret = $_COOKIE['requestTokenSecret'];
    $aweber->user->requestToken = $_GET['oauth_token'];
    $aweber->user->verifier = $_GET['oauth_verifier'];
    list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();
    setcookie('accessToken', $accessToken);
    setcookie('accessTokenSecret', $accessTokenSecret);
    header('Location: '.$_COOKIE['callbackUrl']);
    exit();
}

# set this to true to view the actual api request and response
$aweber->adapter->debug = false;

$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);
//end of file 
if(isset($account)){
//set cookie 
	setcookie("aweberToken", $_COOKIE['accessToken'], time()+3600, '/');
	setcookie("aweberTokenSecret", $_COOKIE['accessTokenSecret'], time()+3600, '/');
?>
	<html>
	<head>
	<script type="text/javascript">
	<!--
	function redirect_delay(){
	    window.location.href = "<?php echo $_GET['redirect']; ?>";
	}
	//-->
	</script>
	</head>
	<body onLoad="setTimeout('redirect_delay()', 5000)">
	You have connected to Aweber, you will be re-direct back to your Mailing List. If you are not re-directed, please <a href="<?php echo $_GET['redirect'] ?>">click here</a>
	</body></html>
<?php }

?>
