#!/bin/sh

HOOK_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/.."
GIT_HOOK_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/../../../.git/hooks"

# Add Commit Message check
ln -sf $HOOK_DIR/commit-msg.php $GIT_HOOK_DIR/commit-msg
echo "Commit Message Check Added."

# Add checkout action
ln -sf $HOOK_DIR/post-checkout.php $GIT_HOOK_DIR/commit-msg
echo "Checkout Action Added."

## Add Pre Push check
ln -sf $HOOK_DIR/pre-push.php $GIT_HOOK_DIR/pre-push
echo "Push Check Added."
