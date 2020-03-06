<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php
            include APP_PATH . 'views/layouts/alerts.php';
            ?>
            <div class="card">
                <div class="card-header">Редактирование задачи</div>
                <div class="card-body">
                    <form action="/tasks/edit/<?=$task['id']?>" method="post">

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">Имя пользователя</label>
                            <div class="col-md-6">
                                <input readonly type="text" id="user_name" class="form-control" name="user_name" value="<?=$helper::escapeHtml($task['user_name'])?>" autofocus required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input readonly type="email" id="user_email" class="form-control" name="user_email" value="<?=$helper::escapeHtml($task['user_email'])?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">Текст задачи</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="text" name="text" required><?=$helper::escapeHtml($task['text'])?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Подтвердить
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

