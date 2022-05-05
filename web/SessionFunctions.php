<?php

/*
  Session related functions
  I don't remember if this actually used
  Joshua Sulouff Z1867688
*/

function IsAdmin() : bool {
  $sql = "select ID from ASSOCIATE where ID = :id and PRIVLEVEL = 5"
  $res = DB_doquery($sql, ['id' => $_SESSION['UID']]);
  if ($res->first()) {
    return true;
  }
  return false;
}

function GetUserQuotes() {
  $sql = "select QID from SQUOTE where OWNER = :id";
  $res = DB_doquery($sql, ['id' => $_SESSION['UID']]);
  $mstr = [];
  foreach ($res as $value) {
    $mstr[] = $res;
  }
  return $mstr
}

function IsQuoteOwner($qid) {
  $sql = "select OWNER from SQUOTE where QID = :qid";
  $res = DB_doquery($sql, ['id' =>  $qid]);
  if ($res['QID'] == $qid)
}

 ?>
