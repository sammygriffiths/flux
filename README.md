#Flux

Flux is a lightweight application that eases the creation of simple, multi-level websites that do not require the use of a CMS.

## Why Flux?

A lot of the websites we do here at Via are small 'brochure' sites with even smaller profit margins, rather than oversell the need for a bloated CMS (especially for clients with tight budgets) we created Flux. Abstracted just enough at it's core, Flux is built upon the outstanding microframework Silex and some select components. It Allows us to create a multitude of sites quickly while still providing enough flexibility with custom page routing to be dangerous to more complex projects.

## Installation

Simply clone down
```shell
git clone git@github.com:viacreative/flux.git
```

Then copy everything into a vagrant box
```shell
cp -R flux/* folder-name/
```

Start the vagrant machine and ssh in
```shell
vagrant up
```
```shell
vagrant ssh
```
```shell
cd /vagrant
```

Then install composer
```shell
sudo composer install
```

## To Do

It's still early days for Flux and there is a lot to do... 