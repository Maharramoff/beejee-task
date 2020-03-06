<div class="container p-3">
    <div class="row">
        <div>
            <div class="col-12">
                <a class="btn btn-primary btn-sm float-left mb-3" href="/tasks/create" role="button">Новая задача</a>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя пользователя</th>
                        <th scope="col">Email</th>
                        <th scope="col">Текст задачи</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($tasks as $task)
                    {
                        ?>
                        <tr>
                            <th scope="row"><?=$task['id']?></th>
                            <td><?=$helper::escapeHtml($task['user_name'])?></td>
                            <td><?=$helper::escapeHtml($task['user_email'])?></td>
                            <td><?=$helper::escapeHtml($task['text'])?></td>
                            <td>
                                <?php
                                if ($task['status'] == 1)
                                {
                                    ?>
                                    <span class="badge badge-success">Выполнено</span>
                                    <?php
                                }
                                if ($task['status'] >= 2)
                                {
                                    if ($task['status'] == 12)
                                    {
                                        ?>
                                        <span class="badge badge-success">Выполнено</span>
                                        <?php
                                    }

                                    ?>
                                    <span class="badge badge-info">Отредактировано администратором</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm mb-2 btn-block <?=($isAdmin ?: 'disabled')?>"
                                   href="/tasks/edit/<?=$task['id']?>">Отредактировать</a>
                                <a class="btn btn-success btn-sm btn-block <?=($isAdmin ?: 'disabled')?>"
                                   href="/tasks/complete/<?=$task['id']?>">Выполнить</a>
                            </td>
                        </tr>
                        <?php
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
