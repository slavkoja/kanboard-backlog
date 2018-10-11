<?php

namespace Kanboard\Plugin\Backlog\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\SwimlaneModel;
use Kanboard\Model\ColumnModel;


/**
 * Backlog Board
 *
 * @package controller
 * @author  creecros
 */
class BacklogBoardController extends BaseController {

    public function set() {
        $projectId = $this->request->getIntegerParam('project_id');

        $this->projectUsesBacklogBoardModel->setBacklogBoard($projectId);
        $this->backlogSwimlane($projectId);
        $this->backlogColumn($projectId);

        $this->flash->success(t('Backlog Board now activated.'));

        $this->response->redirect($this->helper->url->to('BoardViewController', 'show', array('project_id' => $projectId), true));
    }

    public function unset() {
        $projectId = $this->request->getIntegerParam('project_id');

        $this->projectUsesBacklogBoardModel->unsetBacklogBoard($projectId);
        $this->removeBacklogSwimlane($projectId, 0);
        $this->removeBacklogColumn($projectId, 1);

        $this->flash->success(t('Backlog Board now deactivated.'));

        $this->response->redirect($this->helper->url->to('BoardViewController', 'show', array('project_id' => $projectId), true));
    }
    
    public function backlogSwimlane($projectId) {
          $this->swimlaneModel->create($projectId, 'Backlog_Swimlane', 'Temporary Swimlane for Backlog Board');  
          $this->swimlaneModel->changePosition($projectId, $this->swimlaneModel->getByName($projectId, 'Backlog_Swimlane'), 1);
    }
    
    public function removeBacklogSwimlane($projecId) {
          $this->swimlaneModel->remove($projecId, $this->swimlaneModel->getByName($projectId, 'Backlog_Swimlane'));
    }
    
    
    public function backlogColumn($projectId) {
          $this->columnModel->create($projectId, 'Backlog_Board', 0, 'Main Column for Backlog Board', 0);
          $this->columnModel->changePosition($projecId, $this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'), 1);
    }
    
    public function removeBacklogColumn($projectId, $swimlane) {
        foreach ($swimlane['columns'] as $column) {
            if ($column['title'] === 'Backlog_Board') { 
                foreach ($column['tasks'] as $task) { $this->taskPostitionModel->movePosition($projectId, $task['id'], $column['id'], 0, $swimlane_id = 0, $fire_events = true, $onlyOpen = true); }
            }
        }
          $this->columnModel->remove($this->columnModel->getColumnIdByTitle($projectId, 'Backlog_Board'));
    }

}
