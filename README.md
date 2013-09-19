poche version based on Restler

Steps to install it:

```
composer.phar install 
```

Create a vhost on ./public folder.

Copy / paste your poche.sqlite file in ./db

Edit ./Poche/poche/define.inc.php to change POCHE_API by the URL defined in your vhost + 'api'. Ex: your vhost is "poche.localhost", then change POCHE_API to "http://poche.localhost/api" (without trailing slash).