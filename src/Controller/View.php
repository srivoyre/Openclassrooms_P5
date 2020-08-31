<?php

namespace App\src\Controller;

use App\src\Request;

/**
 * Class View
 * @package App\src\controller
 */
class View
{
    private $file;
    private $title;
    private $script;
    private $request;
    private $session;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
    }

    /**
     * @param string $template
     * @param array $data
     */
    public function render(string $template, $data = [])
    {
        $this->file = '../src/view/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../src/view/base.php', [
            'title' => $this->title,
            'script' => $this->script,
            'content' => $content,
            'session' => $this->session
        ]);

        echo filter_var($view);
    }

    /**
     * @param string $file
     * @param array $data
     * @return false|string
     */
    private function renderFile(string $file, array $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }

        header('Location: index.php?route=notFound');
    }
}