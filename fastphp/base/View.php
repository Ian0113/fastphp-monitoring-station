<?php
namespace fastphp\base;

/**
 * 视图基类
 */
class View
{
    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }

    // 分配变量
    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    // 渲染显示
    public function render()
    {
        extract($this->variables);
        $defaultLayout = APP_PATH . 'app/views/layouts/layout.php';

        $controllerLayout = APP_PATH . 'app/views/' . $this->_controller . '/layout.php';

        if (is_file($controllerLayout)) {
            include_once ($controllerLayout);
        } else {
            include_once ($defaultLayout);
        }
    }
}
