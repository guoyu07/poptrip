<?php
class OptionModel extends Model
{
    // 数据表前缀
    protected $tablePrefix  =   ' ';
    // 模型名称
    protected $name = 'OptionModel';
    // 数据表名（不包含表前缀）
    protected $tableName = 'vote_option';

    public function getOptionById ($optionId)
    {

    }

    public function getOptions ($params)
    {
        $sql = 'SELECT * FROM ' . $this->tablePrefix . $this->tableName;
        $sqlWhere = array();
        if (isset($params['voteId'])) {
            $sqlWhere[] = ' vote_id = ' . intval($params['voteId']);
        }

        if ($sqlWhere) {
            $sql = $sql . ' WHERE ' . join(' AND ', $sqlWhere);
        }

        return $this->query($sql);
    }

    public function getOptionsByVoteId($voteId)
    {
        $params = array('voteId'=>intval($voteId));
        return $this->getOptions($params);
    }

    public function addOptions ($params)
    {

    }

    public function updateOptions ($optionId, $params)
    {

    }

    public function deleteOptions ($optionId)
    {

    }

    public function deleteOptionsByVoteId ($voteId)
    {

    }
}
