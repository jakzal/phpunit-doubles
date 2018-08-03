# Contributing

When contributing to this repository send a new pull request against the master branch.
If your change is big or complex, or you simply want to suggest an improvement,
please discuss the change you wish to make via an issue.

Please note we have a [code of conduct](CODE_OF_CONDUCT.md). Please follow it in all your interactions with the project.

## Pull Request Process

* Provide good commit messages describing what you've done.
* Provide tests for any code you write.
* Make sure all tests are passing.

## Running tests

### All tests

```bash
make test
```

### All tests (min dependencies)

```bash
make test-min
```

### PHPUnit

```bash
make phpunit
```

### Mutation testing

```bash
make infection
```

## Fixing coding standard violations

```bash
make cs-fix
```

## Verifying package inter-dependencies

```bash
make deptrac
```

## Creating the phar

```bash
make package test-package
```
