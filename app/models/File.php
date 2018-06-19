<?php

namespace Model;

class File extends \PicORM\Model
{
    protected static $_tableName = 'transfer_infos';
    protected static $_primaryKey = 'id';
    protected static $_relations = array();

    protected static $_tableFields = array(
        'creator_email','recipient_email','file_name','creator_message','creator_ip', 'random_id',
    );

    public $id;
    public $creator_email;
    public $recipient_email;
    public $file_name;
    public $random_id;
    public $creator_message;
    public $ip;
}