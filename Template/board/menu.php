<?php if ($this->task->projectUsesBacklogBoardModel->isset($project['id'])): ?>
        <li>
        <i class="fa fa-plus-square-o fa-fw"></i>
        <?= $this->url->link(t('Change to Normal Board'), 'BacklogBoardController', 'unset', ['plugin' => 'backlog', 'project_id' => $project['id']]) ?>
        </li>
<?php else: ?>
        <li>
        <i class="fa fa-plus-square-o fa-fw"></i>
        <?= $this->url->link(t('Change to Backlog Board'), 'BacklogBoardController', 'set', ['plugin' => 'backlog', 'project_id' => $project['id']]) ?>
        </li>
<?php endif ?>