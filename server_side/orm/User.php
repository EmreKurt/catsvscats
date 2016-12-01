<?php
class User{
  private $id;
  private $name;
  private $email;
  private $password;
  private $favoriteVideoId;
  private $activityScore;

  public static function connect(){
    return new mysqli("127.0.0.1", "root", "", "catsvscats");
  }

  public static function create($name, $email, $password){
    $mysqli = User::connect();
    if($name != null && $email != null && $password != null){
      $result = $mysqli->query("insert into User values (default, '" . $name . "', '" . $email . "', '" . $password . "', 'null', 0)");
      if($result){
        $id = $mysqli->insert_id;
        return new User($id, $name, $email, $password, $favoriteVideoId, $activityScore);
      }
    }
    return null;
  }

  public static function findById($id){
    $mysqli = User::connect();
    $result = $mysqli->query("select * from User where id = " . $id);
    if($result){
      if($result->num_rows == 0){
        return null;
      }
      $user_info = $result->fetch_array();
      return new User(intval($user_info['id']),
        $user_info['name'],
        $user_info['email'],
        $user_info['password'],
        $user_info['favorite_video_id'],
        $user_info['activity_score']
      );
    }
    return null;
  }

  public static function getAllIds(){
    $mysqli = User::connect();
    $result = $mysqli->query("select * from User");
    $id_array = array();
    if($result){
      while($next_row = $result->fetch_array()){
        $id_array[] = intval($next_row['id']);
      }
    }
    return $id_array;
  }

  private function __construct($id, $name, $email, $password, $favoriteVideoId, $activityScore){
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->favoriteVideoId = $favoriteVideoId;
    $this->activityScore = $activityScore;
  }

  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getFavoriteVideoId(){
    return $this->favoriteVideoId;
  }

  public function getActivityScore(){
    return $this->activityScore;
  }

  public function setName($name){
    $this->name = $name;
    return $this->update();
  }

  public function setEmail($email){
    $this->email = $email;
    return $this->update();
  }

  public function setPassword($password){
    $this->password = $password;
    return $this->update();
  }

  public function setFavoriteVideoId($favoriteVideoId){
    $this->favoriteVideoId = $favoriteVideoId;
    return $this->update();
  }

  public function setActivityScore($activityScore){
    $this->activityScore = $activityScore;
    return $this->update();
  }

  private function update(){
    $mysqli = User::connect();
    $result = $mysqli->query("update User set name = '" . $this->name . "', email = '".$this->email."', password = '".$this->password."', favorite_video_id = '".$this->favoriteVideoId."', activity_score = '".$this->activityScore."' where id = '".$this->id."'");
    return $result;
  }

  public function delete(){
    $mysqli = User::connect();
    $mysqli->query("delete from User where id = '".$this->id."'");
  }

  public function getJSON(){
    $jsonObj = array('id' => $this->id, 'name' => $this->name, 'email' => $this->email, 'password' => $this->password, 'favoriteVideoId' => $this->favoriteVideoId, 'activityScore' => $this->activityScore);
    return json_encode($jsonObj);
  }
}
?>
