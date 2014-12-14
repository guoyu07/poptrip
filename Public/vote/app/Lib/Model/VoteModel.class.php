<?php
class VoteModel extends Model
{
    // 数据表前缀
    protected $tablePrefix  =   ' ';
    // 模型名称
    protected $name = 'VoteModel';
    // 数据表名（不包含表前缀）
    protected $tableName = 'vote_list';

    public function addVote ($params)
    {
        return $this->add($params);
    }

    public function getVoteById ($voteId)
    {
        $voteInfo = $this->find($voteId);
        return $voteInfo;
    }

    public function getVote ($where=array(), $orderBy=array())
    {
        $sqlWhere = array();
        if($where['voteId']) {
            $sqlWhere[] = 'vote_id = ' . intval($where['voteId']);
        }

        $sql = 'SELECT * FROM ' . $this->tablePrefix . $this->tableName;
        if ($sqlWhere) {
            $sql = $sql . ' WHERE ' . join (' AND ', $sqlWhere);
        }
        return $this->query($sql);
    }

    public function updateVote ($voteId, $params)
    {

    }

    public function deleteVote ($voteId)
    {
        return $this->delete(intval($voteId));
    }
}