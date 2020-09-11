<?php

namespace App\Src\Controller;

use App\Src\Request;

/**
 * Class View
 * @package App\Src\Controller
 */
class View
{
    private $file;
    private $title;
    private $h1;
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
     * @return void
     */
    public function render(string $template, $data = [])
    {
        $this->file = '../src/View/'.$template.'.php';
        $content = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../src/View/base.php', [
            'title' => $this->title,
            'h1' => $this->h1,
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