<?php
// 本类由系统自动生成，仅供测试用途
class VoteAdminAction extends Action
{
    private $_voteModel = null;
    private $_optionModel = null;

    public function _initialize ()
    {
        $this->_voteModel = D('Vote');
        $this->_optionModel = D('Option');
    }

    public function index()
    {
        $voteId = isset($_REQUEST['voteId']) ? $_REQUEST['voteId'] : 0;
        if ($voteId) {// 查看一个投票数据
            $voteInfo = $this->_voteModel->getVoteById($voteId);
            if ($voteInfo) {
                $voteInfo['options'] = json_decode($voteInfo['options'], true);
                $voteOptions = $this->_optionModel->getOptionsByVoteId($voteId);
                $this->assign('voteInfo', $voteInfo);
                $this->assign('voteOptions', $voteOptions);
                $this->display('ViewVote');
            } else {
                $url = defined(GROUP_NAME)&&GROUP_NAME ? (GROUP_NAME.'/'.MODULE_NAME.'/index')
                                 : (MODULE_NAME.'/index');
                $url = U($url);

                $this->error('没找到ID为'.$voteId . '投票数据', $url);
            }
        } else {
            $voteList = $this->_voteModel->getVote();
            $this->assign('voteList', $voteList);
            $this->display('Index');
        }
    }

    public function addVote ()
    {
        $voteInfo = array();
        if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') {
            $voteInfo['vote_title'] = isset($_POST['vote_title']) ? $_POST['vote_title'] : '';
            $voteInfo['vote_desc'] = isset($_POST['vote_desc']) ? $_POST['vote_desc'] : '';
            $voteInfo['is_public'] = isset($_POST['is_public']) ? $_POST['is_public'] : '';
            $voteInfo['start_time'] = isset($_POST['start_time']) ? $_POST['start_time'] : '';
            $voteInfo['end_time'] = isset($_POST['end_time']) ? $_POST['end_time'] : '';
            $voteInfo['options'] = array();
            $voteInfo['options']['display_style'] = isset($_POST['display_style']) ? $_POST['display_style'] : '';
            $voteInfo['options']['count_duplicate_ip'] = isset($_POST['count_duplicate_ip']) ? $_POST['count_duplicate_ip'] : 'No';
            $voteInfo['options']['count_duplicate_session'] = isset($_POST['count_duplicate_session']) ? $_POST['count_duplicate_session'] : 'No';
            $voteInfo['options'] = json_encode($voteInfo['options']);
            $result = $this->_voteModel->addVote($voteInfo);
            $voteId = $this->_voteModel->getLastInsID();
            if ($result) {
                $this->success('添加成功', U('addOptions', array('voteId'=>$voteId)));
                return;
            } else {
                $this->error('添加失败');
                return;
            }
        }
        $this->assign('action', 'add');
        $this->assign('voteInfo', $voteInfo);

        $this->display('Edit');
    }

    public function updateVote ()
    {
        $voteId = isset($_REQUEST['voteId']) ? intval($_REQUEST['voteId']) : 0;
        if (!$voteId) {
            $this->error('未找到指定投票信息', U('index'));
        }
        $voteInfo = array();
        if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') {
            $voteInfo['vote_title'] = isset($_POST['vote_title']) ? $_POST['vote_title'] : '';
            $voteInfo['vote_desc'] = isset($_POST['vote_desc']) ? $_POST['vote_desc'] : '';
            $voteInfo['is_public'] = isset($_POST['is_public']) ? $_POST['is_public'] : '';
            $voteInfo['start_time'] = isset($_POST['start_time']) ? $_POST['start_time'] : '';
            $voteInfo['end_time'] = isset($_POST['end_time']) ? $_POST['end_time'] : '';
            $voteInfo['options'] = array();
            $voteInfo['options']['display_style'] = isset($_POST['display_style']) ? $_POST['display_style'] : '';
            $voteInfo['options']['count_duplicate_ip'] = isset($_POST['count_duplicate_ip']) ? $_POST['count_duplicate_ip'] : 'No';
            $voteInfo['options']['count_duplicate_session'] = isset($_POST['count_duplicate_session']) ? $_POST['count_duplicate_session'] : 'No';
            $voteInfo['options'] = json_encode($voteInfo['options']);
            $voteInfo['vote_id'] = $voteId;
            $result = $this->_voteModel->save($voteInfo);
            if (false!==$result) {
                $this->success('修改成功', U('index'));
            } else {
                $this->error('修改失败');
            }
            return;
        } else {
            $voteInfo = $this->_voteModel->getVoteById($voteId);

            if ($voteInfo) {
                $voteInfo['options'] = json_decode($voteInfo['options'], true);
                $options = $this->_optionModel->getOptionsByVoteId ( $voteInfo ['vote_id'] );
            } else {
                $options = array ();
            }
        }

        $this->assign('voteInfo', $voteInfo);
        $this->assign('action', 'edit');

        $this->display('Edit');
    }

    public function deleteVote ()
    {
        $voteId = isset($_REQUEST['voteId']) ? intval($_REQUEST['voteId']) : 0;
        if (!$voteId) {
            $this->error('未找到指定投票信息', U('index'));
        }
        $result = $this->_voteModel->deleteVote($voteId);
        if ($result) {
            $this->_optionModel->deleteOptionsByVoteId($voteId);
            $this->success('删除成功', U('index'));
        } else {
            $this->error('删除失败', U('index'));
        }
    }

    public function getOptions ()
    {

    }

    public function addOptions ()
    {
        $voteId = isset($_REQUEST['voteId']) ? intval($_REQUEST['voteId']) : 0;
        if (!$voteId) {
            $this->error('未找到指定投票信息', U('index'));
        }
        if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') {
            foreach ($_POST['option_title'] as $key=>$_title) {
                if($_title=='' && $_POST['option_desc'][$key]=='') {
                    continue;
                }
                $optionInfo = array('option_title'=>$_title,
                        'option_desc' => $_POST['option_desc'][$key],
                        'vote_id'     => $voteId,
                        );
                if (!empty($_POST['optionIds'][$key])) {
                    $optionInfo['option_id'] = $_POST['optionIds'][$key];
                    $this->_optionModel->save($optionInfo);
                } else {
                    $this->_optionModel->add($optionInfo);
                }
            }
            $this->success('操作成功', U('index', array('voteId'=>$voteId)));
        } else {
            $voteInfo = $this->_voteModel->getVoteById($voteId);
            $this->assign('voteInfo', $voteInfo);
            $this->assign('options', array());
            $this->display('VoteOption');
        }
    }

    public function updateOptions ()
    {
        $voteId = isset($_REQUEST['voteId']) ? intval($_REQUEST['voteId']) : 0;
        if (!$voteId) {
            $this->error('未找到指定投票信息', U('index'));
        }
        if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') {
            foreach ($_POST['option_title'] as $key=>$_title) {
                if($_title=='' && $_POST['option_desc'][$key]=='') {
                    continue;
                }
                $optionInfo = array('option_title'=>$_title,
                        'option_desc' => $_POST['option_desc'][$key],
                        'vote_id'     => $voteId,
                        );
                if (!empty($_POST['optionIds'][$key])) {
                    $optionInfo['option_id'] = $_POST['optionIds'][$key];
                    $this->_optionModel->save($optionInfo);
                } else {
                    $this->_optionModel->add($optionInfo);
                }
            }
            $this->success('操作成功', U('index', array('voteId'=>$voteId)));
        } else {
            $voteInfo = $this->_voteModel->getVoteById($voteId);
            $options = $this->_optionModel->getOptionsByVoteId($voteId);
            $this->assign('voteInfo', $voteInfo);
            $this->assign('options', $options);
            $this->display('VoteOption');
        }
    }

    public function deleteOptions ()
    {
        $voteId = isset($_REQUEST['voteId']) ? intval($_REQUEST['voteId']) : 0;
        $optionId = isset($_REQUEST['optionId']) ? intval($_REQUEST['optionId']) : 0;

        $result = $this->_optionModel->deleteOption ($voteId, $optionId);
        if ($result) {
            echo '<result><i class="ok">OK</i></result>';
        } else {
            echo '<result><i class="fail">Fail</i></result>';
        }
    }
}
