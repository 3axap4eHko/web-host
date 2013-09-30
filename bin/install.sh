#!/bin/bash
cd `dirname $0`

WEBHOST_PHP="php `pwd`/web-host.php"

WEBHOST=$(cat <<WEBHOST
#!/bin/sh
sudo $WEBHOST_PHP
WEBHOST
)

WEBHOST_COMPLETE=$(cat <<WEBHOST_COMPLETE
# bash completion for Debian web-host tool
 _web_host(){
    COMPREPLY=()
    cur="\${COMP_WORDS[COMP_CWORD]}"
    # list of web-host commands
    commands=(\`$WEBHOST_PHP commands\`)

    subcommands_1="\${commands[*]}"

    if [[ \${COMP_CWORD} == 1 ]] ; then
        COMPREPLY=( \$(compgen -W "\${subcommands_1}" -- \${cur}) )
        return 0
    fi
    }
complete -F _web_host web-host
WEBHOST_COMPLETE
)

sudo sh -c "echo '$WEBHOST \$*'>/usr/bin/web-host"
sudo chmod +x /usr/bin/web-host
sudo sh -c "echo '$WEBHOST_COMPLETE'>/etc/bash_completion.d/web-host"
web-host setup