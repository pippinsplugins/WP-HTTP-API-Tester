WP HTTP API Tester
==================

Provides an interface for testing remote requests via the WP HTTP API.

The idea is to provide an easy way to test remote requests to other servers, similar to what [Postman](https://chrome.google.com/webstore/detail/postman-rest-client/fdmmgilgnpjigdojojpjoooidkmcomcm?hl=en) does.

Usage
=====

1. Select the method to use
2. Enter the URL you wish to send the request to
3. Enter the data you wish to send to the URL in a JSON format

Use Cases
=========

You could use this for several purposes:

1. To check if your remote server is accepting and processing requests correctly. For example, a [Stripe webhook](https://stripe.com/docs/webhooks) listener.
2. To check if your server (the one this plugin is running on) is able to send remote requests.
3. To check that your remote server is returning the correct response and code.