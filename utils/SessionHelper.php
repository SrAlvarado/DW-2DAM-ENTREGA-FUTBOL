<?php

/**
 * class SessionUtils
 *
 * Contains util methods to deal with SESSIONS.
 *
 * @version    0.2
 *
 * @author     Ander Frago & Miguel Goyena (Modificado por Markel Alvarado)
 */
class SessionHelper {

  /**
   * Compreueba si la sesión está iniciada, si no lo está la inicia.
   */
  static function startSessionIfNotStarted() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start([
          'cookie_lifetime' => 86400,
        ]);
    }
  }

  static function destroySession() {
    self::startSessionIfNotStarted();
    $_SESSION = array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time() - 2592000, '/');

    session_destroy();
  }

  static function setSession($user) {
    self::startSessionIfNotStarted();
    $_SESSION['user'] = $user;
    if (!isset($_SESSION['CREATED'])) {
      $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {

      session_regenerate_id(true);
      $_SESSION['CREATED'] = time();
    }
  }

  static function loggedIn(): bool
  {
    self::startSessionIfNotStarted();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {

      session_unset();
      session_destroy();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
    if (isset($_SESSION['user'])) {
      return true;
    } else {
      return false;
    }
  }

  static function getUser(): string{
      self::startSessionIfNotStarted();
      if (isset($_SESSION['user'])) {
          return $_SESSION['user'];
      } else {
          return "Invitado";
      }
  }

}