# ZF3 Auth Example Based on ZF3 Skelethon App

## Introduction

This is a skeleton application using the Zend Framework MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with Zend Framework.


> ### Vagrant and VirtualBox
>
> The vagrant image is based on ubuntu/xenial64. If you are using VirtualBox as
> a provider, you will need:
>
> - Vagrant 1.8.5 or later
> - VirtualBox 5.0.26 or later

Vagrant Setup used: [Homestead(5.3.2)](https://github.com/laravel/homestead/releases/tag/v5.3.2)




### Nginx setup
Nginx Config file.
Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/zfauth.dev`
it should look something like below:

```nginx
server {
  listen 80;
  server_name zfauth.dev;

  root /vagrant/code/zfauth/public;


  location / {
    index index.php;
  }

  # Deny access to sensitive files.
  location ~ (\.inc\.php|\.tpl|\.sql|\.tpl\.php|\.db)$ {
    deny all;
  }
  location ~ \.htaccess {
    deny all;
  }

  # Rewrite rule adapted from zendapp/public/.htaccess
  if (!-e $request_filename) {
    rewrite ^.*$ /index.php last;
  }

  # PHP scripts will be forwarded to fastcgi processess.
  # Remember that the `fastcgi_pass` directive must specify the same
  # port on which `spawn-fcgi` runs.
  location ~ \.php$ {
    include /etc/nginx/fastcgi_params;

    fastcgi_pass   unix:/var/run/php/php7.1-fpm.sock;
    fastcgi_param APPLICATION_ENV development;    
    fastcgi_index  index.php;
  }

  location = /50x.html {
      root   /var/www/default;
  }
}
```