<?php


namespace App\Controllers;


use App\Models\Task;
use Symfony\Component\HttpFoundation\ParameterBag;


class TaskController extends BaseController
{
    public function show(int $id)
    {
        $this->view->setPath('task/show')->assign('foo', $id)->render();
    }

    public function index()
    {
        $data['tasks'] = Task::all();
        $this->view->setPath('task/index')->assign($data)->render();
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST')
        {
            if ($this->validate($this->parameterBag))
            {
                $taskId = Task::create([
                    'user_name'  => $this->parameterBag->get('user_name'),
                    'user_email' => $this->parameterBag->get('user_email'),
                    'text'       => $this->parameterBag->get('text'),
                ]);

                if ($taskId)
                {
                    $this->successResponse();
                }
                else
                {
                    $this->setErrorMessage('DB error');
                }
            }
        }

        $this->view->setPath('task/create')->render();
    }

    /**
     * Validate request
     *
     * @param ParameterBag $parameterBag
     * @return bool
     */
    private function validate(ParameterBag $parameterBag): bool
    {
        switch (true)
        {
            case count($parameterBag->all()) < 3:
                $this->emptyFieldsResponse();
                return false;

            case !$this->isValidEmail($parameterBag->get('user_email')):
                $this->emailNotValidResponse();
                return false;

            default:
                return true;
        }
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

    private function emailNotValidResponse()
    {
        $this->setErrorMessage('Неправильно введен адрес электронной почты');
    }

    private function successResponse()
    {
        $this->setSuccessMessage('Вы успешно создали новую задачу');
    }
}