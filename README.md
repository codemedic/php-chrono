# PHP Chrono

[![Build Status](https://travis-ci.com/codemedic-oss/php-chrono.svg?branch=master)](https://travis-ci.com/codemedic-oss/php-chrono)

Clock and time utilities with focus on accuracy and testability.

The design is influenced by [`chrono`](https://en.cppreference.com/w/cpp/chrono) library in C++ and [`time.Duration`](https://golang.org/pkg/time/) library in golang.

The one reason, if you need convincing, to use this library would be to enhance the testability of your code that relies on system-time. See [examples](examples).

### API Reference
Documentation can be [found here](docs/phpdoc.md).

# How to contribute?

Please feel free to fork and submit a pull request. Bug fixes, improvements, unit-tests and usability comments are most welcome.

If you are to contribute code, please do log an issue before starting to work on the code. Your changes should come with working unit tests; all tests must pass.

Coding standard followed here is `PSR-2`.

## License

This library is licensed under [MIT license](LICENSE).
