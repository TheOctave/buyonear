<?php

// Stripe init
\Stripe\Stripe::setApiKey(Config::getStripeSecret());

\Clarifai\Clarifai::setAppName(Config::getClarifaiAppName());
\Clarifai\Clarifai::setApiClientId(Config::getClarifaiClientId());
\Clarifai\Clarifai::setApiClientSecret(Config::getClarifaiClientSecret());


?>
