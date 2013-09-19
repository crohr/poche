# poche version based on Restler

Steps to install it:

```
composer.phar install 
```

Create a vhost on ./public folder.

Copy / paste your poche.sqlite file in ./db

Edit ./Poche/poche/define.inc.php to change POCHE_API by the URL defined in your vhost + 'api'. Ex: your vhost is "poche.localhost", then change POCHE_API to "http://poche.localhost/api" (without trailing slash).

You have to add 2 entried in users_config table: 

```sql
INSERT INTO "users_config" VALUES(3,1,'api','b06d30f765ad484bbe468a1291424c1e7d878b52');
INSERT INTO "users_config" VALUES(4,1,'role','user');
```