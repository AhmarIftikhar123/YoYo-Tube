<?php
namespace Src\App;
use Src\App\Exceptions\ViewNotFoundException;
class Views
{
          public function __construct(
                    private string $view,
                    private array $data = []
          ) {
          }
          public static function make($view, $data = []): self
          {
                    return new self($view, $data);
          }

          public function __toString()
          {
                    return $this->render();
          }

          public function render(): string
          {
                    $view_file = VIEWS_PATH . "/" . $this->view . ".php";
                    if (file_exists($view_file)) {
                              ob_start();
                              include_once $view_file;
                              return ob_get_clean();
                    }
                    throw new ViewNotFoundException("View $view_file not found");
          }
          public function __get($name)
          {
                    return $this->data[$name] ?? "";
          }
}