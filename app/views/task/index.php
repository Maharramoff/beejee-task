<div class="container p-3">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary btn-sm float-left mb-3" href="/tasks/create" role="button">Новая задача</a>
            <?=$pagination?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <?
                        foreach ($fields as $key => $field)
                        {
                            ?>
                            <th scope="col" style="width: <?=$field['width']?>%; white-space: nowrap;">
                                <?php

                                if (!$field['sortable'])
                                {
                                    echo '<span style="color:#888;">' . $field['name'] . '</span>';
                                }
                                else
                                {
                                    if ($key === $orderBy)
                                    {
                                        ?>
                                        <a href="/tasks/<?=$key . '/' . ($sortBy == 'asc' ? 'desc' : 'asc') . '/' . $page?>">
                                            <u style="color:#000;"><?=($sortBy == 'asc' ? '&uarr;' : '&darr;')?> <?=$field['name']?></u>
                                        </a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="/tasks/<?=$key . '/asc/' . $page?>">
                                            <?=$field['name']?>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>
                            </th>
                            <?
                        }
                        ?>
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

