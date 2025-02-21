# Tus plugin for BEdita

[![Github Actions PHP](https://github.com/bedita/tus/workflows/php/badge.svg)](https://github.com/bedita/tus/actions?query=workflow%3Aphp)
[![codecov](https://codecov.io/gh/bedita/tus/branch/master/graph/badge.svg)](https://codecov.io/gh/bedita/tus)
[![phpstan](https://img.shields.io/badge/PHPStan-level%201-brightgreen.svg)](https://phpstan.org)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bedita/tus/badges/quality-score.png)](https://scrutinizer-ci.com/g/bedita/tus/)
[![Version](https://img.shields.io/packagist/v/bedita/tus.svg?label=stable)](https://packagist.org/packages/bedita/tus)
[![License](https://img.shields.io/badge/License-LGPL_v3-orange.svg)](https://github.com/bedita/tus/blob/master/LICENSE.LGPL)

This plugin enable BEdita API to use [tus](https://tus.io/) protocol to upload files and create associated BEdita media object types.

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require bedita/tus
```

## Configuration

The `config/config.php` contains the configurations needed.

## Usage

By default the plugin exposes a route `/tus` (configurable via `endpoint` key) on which the tus server will respond.
The client must send a tus request to `/tus/{type}` where `{type}` is the object type that you want
associate to the file uploaded.
The upload request must contain a bearer authorization header as expected from BEdita API.

At the end of the upload a BEdita object `{type}`will be created and the tus response will be decorated
with the headers

```
BEdita-Object-Id: <id>
BEdita-Object-Type: <type>
```

containing the BEdita object id and type.
