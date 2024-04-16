<?php
class Database
{
  private $host;
  private $username;
  private $password;
  private $dbname;
  private $conn;

  public function __construct()
  {
    $this->host = "localhost:3307";
    $this->username = "root";
    $this->password = "";
    $this->dbname = "db_cuahangthoitrang";
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

    if ($this->conn->connect_error) {
      die("Kết nối không thành công: " . $this->conn->connect_error);
    }
  }
  public function query($sql)
  {
    $result = $this->conn->query($sql);

    // Kiểm tra và xử lý lỗi nếu có
    if (!$result) {
      die("Lỗi truy vấn: " . $this->conn->error);
    }

    return $result;
  }

  // Phương thức ngắt kết nối
  public function close()
  {
    $this->conn->close();
  }
}
