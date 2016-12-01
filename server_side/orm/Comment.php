<?php
class Comment{
  private $id;
  private $userId;
  private $videoId;
  private $comment;
  private $date;

  public static function connect(){
    return new mysqli("127.0.0.1", "root", "", "catsvscats");
  }

  public static function create($userId, $videoId, $comment){
    $mysqli = Comment::connect();
    if($userId != null && $videoId != null && $comment != null){
      $result = $mysqli->query("insert into Comment values (default, '".$userId."', '".$videoId."', '".$mysqli->real_escape_string($comment)."', default)");
      if($result){
        $id = $mysqli->insert_id;
        return new Comment($id, $userId, $videoId, $comment, null);
      }
    }
    return null;
  }

  public static function findById($id){
    $mysqli = Comment::connect();
    $result = $mysqli->query("select * from Comment where id = '".$id."'");
    if($result){
      if($result->num_rows == 0){
        return null;
      }
      $comment_info = $result->fetch_array();
      return new Comment($comment_info['id'], $comment_info['user_id'], $comment_info['video_id'], $comment_info['comment'], $comment_info['date']);
    }
    return null;
  }

  public static function getAllIds(){
    $mysqli = Comment::connect();
    $result = $mysqli->query("select * from Comment");
    $id_array = array();
    if($result){
      while($next_row = $result->fetch_array()){
        $id_array[] = intval($next_row['id']);
      }
    }
    return $id_array;
  }

  public function __construct($id, $userId, $videoId, $comment, $date){
    $this->id = $id;
    $this->userId = $userId;
    $this->videoId = $videoId;
    $this->comment = $comment;
    $this->date = $date;
  }

  public function getId(){
    return $this->id;
  }

  public function getUserId(){
    return $this->userId;
  }

  public function getVideoId(){
    return $this->videoId;
  }

  public function getComment(){
    return $this->comment;
  }

  public function getDate(){
    return $this->date;
  }

  public function setUserId($userId){
    $this->userId = $userId;
    $this->update();
  }

  public function setVideoId($videoId){
    $this->videoId = $videoId;
    $this->update();
  }

  public function setComment($comment){
    $this->comment = $comment;
    $this->update();
  }

  public function update(){
    $mysqli = Comment::connect();
    $result = $mysqli->query("update Comment set user_id = '".$this->userId."', video_id = '".$this->videoId"', comment = '".$this->comment."', date = '".$this->date."' where id  = '".$this->id."'");
    return $result;
  }

  public function delete(){
    $mysqli = Comment::connect();
    return $mysqli->query("delete from Comment where id = '".$this->id."'");
  }

  public function getJSON(){
    $jsonObj = array('id' => $this->id, 'userId' => $this->userId, 'videoId' => $this->videoId, 'comment' => $this->comment, 'date' => $this->date);
    return json_encode($jsonObj);
  }
}

?>
