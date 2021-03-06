#! / usr / bin / env bash
# entrypoint.sh
set -euo pipefail # quit on errors

export XDEBUG_CONFIG = "remote_host=$(ip route show | awk '/default/ {print $ 3}')"

exec "$ @" # execute the rest of the command line