Gitonomy website
================

This is sourcecode of `gitonomy.com <http://gitonomy.com>`_.

Installation
------------

First, clone repository to local folder, using **git**:

.. code-block:: bash

    $ cd /var/www
    $ git clone git@github.com:gitonomy/website.git

When it's done, go to the downloaded directory and install your dependencies with `composer <http://getcomposer.org>`_.

.. code-block:: bash

    $ cd /var/www/website
    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install

Finally, create a Apache host to *web/* folder:

.. code-block:: apache

    <VirtualHost *:80>
        ServerName gitonomy.com
        DocumentRoot /var/www/website
    </VirtualHost>
