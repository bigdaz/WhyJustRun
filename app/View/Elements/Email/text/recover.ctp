Dear <?php echo $user['User']['username']; ?>,

Someone is attempting to reset your password.

If you wish to continue, you may reset your password by
following this link:

    <?php echo Router::url(array('controller' => 'users', 'action' => 'verify', $token), true); ?>


If you did not initiate this action, please contact
support. You can log in to change your password
at this address:

    <?php echo Router::url(array('controller' => 'users', 'action' => 'login'), true); ?>
