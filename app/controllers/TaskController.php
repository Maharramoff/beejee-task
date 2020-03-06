<?php


namespace App\Controllers;


use App\Models\Task;
use BeeJee\Helper;
use Symfony\Component\HttpFoundation\ParameterBag;


class TaskController extends BaseController
{
    public function index($orderBy = 'id', $sortBy = 'asc', $page = 1)
    {
        $data['fields'] = [
            'id'         => ['name' => 'ID', 'sortable' => true, 'width' => '5'],
            'user_name'  => ['name' => 'Имя пользователя', 'sortable' => true, 'width' => '10'],
            'user_email' => ['name' => 'Email', 'sortable' => true, 'width' => '15'],
            'text'       => ['name' => 'Текст задачи', 'sortable' => true, 'width' => '25'],
            'status'     => ['name' => 'Статус', 'sortable' => true, 'width' => '25'],
        ];

        if(!isset($data['fields'][$orderBy]))
        {
            $orderBy = 'id';
        }

        $result                    = Task::allFiltered($orderBy, $sortBy, $page, 3);
        $data['tasks']             = $result['rows'];
        $data['pagination']        = Helper::paginate('/tasks/' . $orderBy . '/' . $sortBy, $result['maxPages'], $result['totalRows'], 3, $result['page']);
        $data['orderBy']           = $orderBy;
        $data['sortBy']            = $sortBy;
        $data['page']              = $result['page'];
        $data['fields']['options'] = ['name' => 'Действия', 'sortable' => false, 'width' => '20'];

        $this->view->setPath('task/index')->assign($data)->render();
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST')
        {
            if ($this->validateCreate($this->parameterBag))
            {
                $taskId = Task::create([
                    'user_name'  => $this->parameterBag->get('user_name'),
                    'user_email' => $this->parameterBag->get('user_email'),
                    'text'       => $this->parameterBag->get('text'),
                ]);

                if ($taskId)
                {
                    $this->setSuccessMessage('Вы успешно создали новую задачу.');
                }
                else
                {
                    $this->setErrorMessage('Невозможно создать запись в базе данных. Пожалуйста, попробуйте еще раз.');
                }
            }
        }

        $this->view->setPath('task/create')->render();
    }

    public function update(int $id)
    {
        // Only admins can edit task
        if (!$this->auth->isAdmin())
        {
            Helper::redirect('/auth/login');
        }

        $data['task'] = Task::find($id);

        // Task not found
        if (empty($data['task']))
        {
            Helper::redirect('/');
        }

        if ($this->request->getMethod() === 'POST')
        {
            // Check if current text differ posted one
            similar_text($data['task']['text'], $this->parameterBag->get('text'), $percent);

            if ($this->validateUpdate($this->parameterBag))
            {
                $taskId = Task::update([
                    'text'      => $this->parameterBag->get('text'),
                    'id'        => $id,
                    'completed' => $this->parameterBag->has('is_completed'),
                    'edited'    => $percent < 100 ? 1 : $data['task']['edited']
                ]);

                if ($taskId)
                {
                    $this->setSuccessMessage('Вы успешно отредактировали задачу.');
                    $data['task']['text'] = $this->parameterBag->get('text');
                }
            }
        }

        $this->view->setPath('task/edit')->assign($data)->render();
    }

    /**
     * Validate create request
     *
     * @param ParameterBag $parameterBag
     * @return bool
     */
    private function validateCreate(ParameterBag $parameterBag): bool
    {
        switch (true)
        {
            case count($parameterBag->all()) < 3:
                $this->emptyFieldsResponse();
                return false;

            case !$this->isValidEmail($parameterBag->get('user_email')):
                $this->setErrorMessage('Неправильно введен адрес электронной почты.');
                return false;

            default:
                return true;
        }
    }

    /**
     * Validate update request
     *
     * @param ParameterBag $parameterBag
     * @return bool
     */
    private function validateUpdate(ParameterBag $parameterBag): bool
    {
        if (empty($parameterBag->get('text')))
        {
            $this->setErrorMessage('Текст не должен быть пустым.');
            return false;
        }

        return true;
    }

    /**
     * Email validation
     *
     * @param string $email
     * @return bool
     */
    private function isValidEmail(string $email): bool
    {
        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate Email
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}