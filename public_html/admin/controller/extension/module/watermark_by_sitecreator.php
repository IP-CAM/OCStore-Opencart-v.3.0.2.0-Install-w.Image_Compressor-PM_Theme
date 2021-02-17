<?php
if (!class_exists('ControllerExtensionModuleWatermarkBySitecreator')) {
  class ControllerExtensionModuleWatermarkBySitecreator extends Controller
  {
    private $error = array();

    public function index()
    {
      $this->control();
      $this->controller_module_watermark_by_sitecreator->index();
    }

    public function uninstall()
    {
      if ($this->validate()) {
        $this->control();
        if(method_exists('ControllerModuleWatermarkBySitecreator', 'uninstall'))
          $this->controller_module_watermark_by_sitecreator->uninstall($this->registry);
      }
    }

    public function install()
    {
      if ($this->validate()) {
        $this->control();
        if(method_exists('ControllerModuleWatermarkBySitecreator', 'install'))
          $this->controller_module_watermark_by_sitecreator->install($this->registry);
      }
    }

    protected function validate()
    {
      if (!$this->user->hasPermission('modify', 'extension/module/watermark_by_sitecreator')) {
        $this->error['warning'] = $this->language->get('error_permission');
      }
      return !$this->error;
    }

    public function control()
    {
      $file = DIR_APPLICATION . 'controller/module/watermark_by_sitecreator.php';
      $class = 'Controllermodulewatermarkbysitecreator';
      if (file_exists($file)) {
        require_once $file;
        $this->registry->set('controller_module_watermark_by_sitecreator', new $class($this->registry));
      } else {
        trigger_error('Error: Could not load controller ' . 'module/watermark_by_sitecreator' . '!');
        exit();
      }
    }
  }
}
?>