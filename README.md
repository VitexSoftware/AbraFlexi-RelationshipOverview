Konvertor Faktury přiaté na závazek
===================================



Instalace
---------

V browseru je třeba ručně otevřít stránku [install.php](src/install.php)

Do formuláře se vyplní přístupové údaje do FlexiBee. 
Pokud jsou tyto správné, vytvoří se ve FlexiBee v evidencí přijatých a vydaných faktur spouštěcí tlačítko.
Po stisku tohoto tlačítka se uživateli otevře okno ve kterém uvdí odkaz na stránku s nastaveními.
Tam je třeba zvolit si které účetní rozvrhy budou zahrnuty do přepočtu nákladů a výnosů.
Po uložení formuláře je možné se vrátit na předchozí obrazovku, kde se již zobrazí nějaké výsledky.

Vysledky formuláře budou současně odeslány mailem.


Provoz
------

V kontejneru běží Fast-CGI verze PHP

Na stroji v internetu je třeba nastavit tuto minimální konfiguraci:

```
<VirtualHost *:80>
        ServerName ${NAME}.d.cnnc.cz

        ProxyPass / "http://localhost:8999/"
        ProxyPassReverse / "http://localhost:8999/"

        ErrorLog ${APACHE_LOG_DIR}/${NAME}_error.log
        CustomLog ${APACHE_LOG_DIR}/${NAME}_access.log combined
</VirtualHost>

```


ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9025/var/www/html/catalog/$1
DirectoryIndex /index.php index.php

Testování
---------

Pokud není stránka volána s parametry $authSessionId && $companyUrl pokusí se načíst konfigurák ../testing/client.json
