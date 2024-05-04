<?php

class userAuth
{
  public $read_permission_list = [];
  public $create_permission_list = [];
  public $update_permission_list = [];
  public $delete_permission_list = [];
  public $conn;

  function __construct($conn)
  {
    $this->conn = $conn;
    $this->getPermisstionList();

  }

  function isAdmin() {
    if (count($this->read_permission_list) == 0) {
      return false;
    } else return true;
  }

  function getPermisstionList()
  {
    $role_id = null;
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['userData'])) {
      $role_id = $_SESSION['userData']['roleId'];
      $sql = "SELECT chucnangId, action FROM role_chucnang WHERE roleId = $role_id";
      $role_features_actions = $this->conn->query($sql);
      while ($row = $role_features_actions->fetch_assoc()) {
        if ($row['action'] == 'read') {
          $this->read_permission_list[] = $row['chucnangId'];
        }
        if ($row['action'] == 'create') {
          $this->create_permission_list[] = $row['chucnangId'];
        }
        if ($row['action'] == 'update') {
          $this->update_permission_list[] = $row['chucnangId'];
        }
        if ($row['action'] == 'delete') {
          $this->delete_permission_list[] = $row['chucnangId'];
        }
      }
    } else {
      header("Location:../pages/login.php");
      exit();
    }
  }

  function checkReadPermission($feature_id)
  {
    if (in_array($feature_id, $this->read_permission_list)) {
      return;
    } else {
      header("Location:../index.php");
      exit();
    }
  }

  function checkCreatePermission($feature_id)
  {
    if (in_array($feature_id, $this->create_permission_list)) {
      return true;
    } else {
      return false;
    }
  }

  function checkUpdatePermission($feature_id)
  {
    if (in_array($feature_id, $this->update_permission_list)) {
      return true;
    } else {
      return false;
    }
  }

  function checkDeletePermission($feature_id)
  {
    if (in_array($feature_id, $this->delete_permission_list)) {
      return true;
    } else {
      return false;
    }
  }
}
