<?php


namespace BeeJee;

class View
{
    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The path to the view file.
     *
     * @var string
     */
    protected $path;

    function __construct()
    {
    }

    public function assign($key, string $value = null)
    {
        if (is_array($key))
        {
            $this->data = array_merge($this->data, $key);
        }
        else
        {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function render(): void
    {
        extract($this->data);

        require_once APP_PATH . 'views/layouts/header.php';

        if(null !== $this->path)
        {
            $bodyLayout = APP_PATH . 'views/' . $this->path . '.php';

            if (is_file($bodyLayout) && is_readable($bodyLayout))
            {
                require_once $bodyLayout;
            }
            else
            {
                exit('View file ' . $this->path . ' not found');
            }
        }

        require_once APP_PATH . 'views/layouts/footer.php';
    }

    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }
}