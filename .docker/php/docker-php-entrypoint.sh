#!/usr/bin/env bash
set -e

warn() { echo "$@" >&2; }
die() { warn "Fatal: $@"; exit 1; }

configure_user() {
    echo "Configuring user. I am currently: $(whoami)";

    USERNAME=php
    HOST_UID=$(stat -c %u .)
    HOST_GID=$(stat -c %g .)

    groupadd -f -g $HOST_GID $USERNAME || true
    useradd -o --shell /bin/bash -u $HOST_UID -g $HOST_GID -m $USERNAME || true
}

configure_xdebug() {
    echo "XDEBUG - Deleting old config"
    rm -f $PHP_INI_DIR/conf.d/xdebug.ini

    echo "XDEBUG - Reconfiguring"
    echo "xdebug.idekey=PHPSTORM" > "$PHP_INI_DIR/conf.d/xdebug.ini"
    echo "xdebug.remote_enable=On" >> "$PHP_INI_DIR/conf.d/xdebug.ini"
    echo "xdebug.profiler_output_dir=/app/storage/framework/profiling" >>  "$PHP_INI_DIR/conf.d/xdebug.ini"
    echo "xdebug.profiler_output_name=cachegrind.out.%t.%H.%R" >> "$PHP_INI_DIR/conf.d/xdebug.ini"

    if [ ! -z "$XDEBUG_PROFILER" ]; then
      echo "xdebug.profiler_enable_trigger=1" >> "$PHP_INI_DIR/conf.d/xdebug.ini"
    fi

    if [ ! -z "$XDEBUG_REMOTE_CONNECT_BACK" ]; then
        echo "XDEBUG - Enabling connect back"
        echo "xdebug.remote_connect_back=On" >> "$PHP_INI_DIR/conf.d/xdebug.ini"
    fi

    if [ ! -z "$XDEBUG_REMOTE_HOST" ]; then
        echo "XDEBUG - Remote host set to '$XDEBUG_REMOTE_HOST'"
        echo "xdebug.remote_host=$XDEBUG_REMOTE_HOST" >> "$PHP_INI_DIR/conf.d/xdebug.ini"
    fi
}

configure_timezone() {
    echo "TIMEZONE - Configuring TIMEZONE"
    echo "date.timezone = \"Europe/Amsterdam\"" > "$PHP_INI_DIR/conf.d/timezone.ini"
}

configure_aliases() {
    if [ -e '/home/php/alias_set' ]; then
        warn 'Aliases already set'
    else
        echo "Configuring aliases for php user! Very much handy :)"
        touch /home/php/alias_set
        echo '
alias ..="cd .."
alias ...="cd ../.."

alias h="cd ~"
alias c="clear"
alias pa="php artisan"

alias vapor="php vendor/bin/vapor"

alias yrd="yarn run dev"
alias yrw="yarn run watch"
alias yrwp="yarn run watch-poll"
alias yrh="yarn run hot"
alias yrp="yarn run production"' >> /home/php/.bashrc
    fi
}

configure_user
configure_xdebug
configure_timezone
configure_aliases

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

echo ">> Running CMD '$@'"
exec "$@"
