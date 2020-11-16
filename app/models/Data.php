<?php
namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;

class Data extends Model
{
    protected $table = 'datas';

    public function dstream($id)
    {
        $sql = sprintf("select value,UNIX_TIMESTAMP(created_at) from `%s` %s", $this->table, 'where `chart_id` = :chart_id');
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [":chart_id" => $id]);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function count($id)
    {
        $sql = sprintf("select count(id) from `%s` %s", $this->table, 'where `chart_id` = :chart_id');
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [":chart_id" => $id]);
        $sth->execute();
        return $sth->fetchAll();
    }
}