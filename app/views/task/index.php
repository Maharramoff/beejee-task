<div class="container p-3">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary btn-sm float-left mb-3" href="/tasks/create" role="button">Новая задача</a>
            <?=$pagination?>
            <div class="table-responsive-md">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 5%">#</th>
                        <th scope="col" style="width: 10%">Имя пользователя</th>
                        <th scope="col" style="width: 15%">Email</th>
                        <th scope="col" style="width: 25%">Текст задачи</th>
                        <th scope="col" style="width: 25%">Статус</th>
                        <th scope="col" style="width: 20%">Действия</th>
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
                                if ($task['completed'])
                                {
                                    ?>
                                    <span class="badge badge-success">Выполнено</span>
                                    <br/>
                                    <?php
                                }
                                if ($task['edited'])
                                {
                                    ?>
                                    <span class="badge badge-info">Отредактировано администратором</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm mb-2 btn-block <?=($isAdmin ?: 'disabled')?>"
                                   href="/tasks/edit/<?=$task['id']?>">Отредактировать</a>
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

