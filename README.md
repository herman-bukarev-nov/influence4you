# Influence4you Project

This project based on [Laravel Project](https://github.com/drupal-composer/drupal-project) 
dependencies with [Composer](https://getcomposer.org/).

## Installation

1. Clone repository from [Github](https://github.com/herman-bukarev-nov/influence4you)

``` bash
git clone https://github.com/herman-bukarev-nov/influence4you.git
```
2. Build the application
``` bash
make install app=influence4you
```

> Additional variables:\
> `port`: You may set web port from default 80 to 8080 or another, if 80 port is occupied on your host  \
> `no-interaction`: Do not ask any interactive question.

##### Examples
Install Project called *influence4you*
```bash
make install project=influence4you port=8080
```

##### Another Commands
You may find more useful commands by type
`make help`

inside the root directory of the project.

If you don't have `make` utill you may install it `apt-get install -y make`
or just copy `.env.example` file to `.env` and fill all required values.
