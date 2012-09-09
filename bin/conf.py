# -*- coding: utf-8 -*-

import sys, os

from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer

sys.path.insert(0, os.path.abspath('../vendor/fabpot/sphinx-php'))
needs_sphinx = '1.0'

extensions = ['sphinx.ext.autodoc', 'sphinx.ext.doctest',
              'sphinx.ext.todo', 'sphinx.ext.coverage', 'sphinx.ext.ifconfig',
              'sphinx.ext.viewcode', 'sphinx.ext.extlinks', 'sensio.sphinx.refinclude',
              'sensio.sphinx.configurationblock', 'sensio.sphinx.phpcode']

templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'index'
exclude_patterns = ['_build']

html_copy_source = True

lexers['php'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)

primary_domain = 'php'
