<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* login.html */
class __TwigTemplate_f17d4f8ab6db5a4ac0eb61122356f00b extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <title>Inventory Control - Emanuel Florencio Costa</title>

  
<!-- Google Font: Source Sans Pro -->
<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback\">
<!-- Font Awesome Icons -->
<link rel=\"stylesheet\" href=\"/res/admin/plugins/fontawesome-free/css/all.min.css\">
<!-- icheck bootstrap -->
<link rel=\"stylesheet\" href=\"/res/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css\">
<!-- Theme style -->
<link rel=\"stylesheet\" href=\"/res/admin/dist/css/adminlte.min.css\">


</head>
<body class=\"hold-transition login-page\">
<div class=\"login-box\">
  <!-- /.login-logo -->
  <div class=\"card card-outline card-primary\">
    <div class=\"card-header text-center\">
      <a href=\"../../index2.html\" class=\"h1\"><b>ERP - System</b></a>

    </div>
    <div class=\"card-body\">
      <p class=\"login-box-msg\">Sign in to start your session</p>

      <a href=\"../../index2.html\" class=\"\"><b>ERP - System</b></a>

      <p class=\"login-box-msg\">Developed by Emanuel Costa</p>

      <form action=\"/login\" method=\"post\">
        <div class=\"input-group mb-3\">
          <input type=\"text\" class=\"form-control\" placeholder=\"login\" name=\"login\">
          <div class=\"input-group-append\">
            <div class=\"input-group-text\">
              <span class=\"fas fa-user\"></span>
            </div>
          </div>
        </div>
        <div class=\"input-group mb-3\">
          <input type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"password\">
          <div class=\"input-group-append\">
            <div class=\"input-group-text\">
              <span class=\"fas fa-lock\"></span>
            </div>
          </div>
        </div>
        <div class=\"row\">
          
          <!-- /.col -->
          
            <button type=\"submit\" class=\"btn btn-primary btn-block\" name=\"SendLogin\">Sign In</button>
          
          <!-- /.col -->
        </div>
      </form>

      ";
        // line 62
        echo ($context["msg_return"] ?? null);
        echo "

      
      <!-- /.social-auth-links -->
      <p class=\"text-success\">Login: admin</p>
      <p class=\"text-success\">Password: 123</p>

      <p class=\"text-danger\">Notice! We do not collect
         your data. Here we are just demonstrating
          how the system works. Source code is
           available on github</p>

      <a href=\"https://www.linkedin.com/in/emanuel-f-costa-0446b965/\" class=\"text-primary\" target=\"_blank\">Developed by Emanuel F. Costa</a>    
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src=\"/res/admin/plugins/jquery/jquery.min.js\"></script>
<!-- Bootstrap 4 -->
<script src=\"/res/admin/plugins/bootstrap/js/bootstrap.bundle.min.js\"></script>
<!-- AdminLTE App -->
<script src=\"/res/admin/dist/js/adminlte.min.js\"></script>




</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "login.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 62,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login.html", "/Users/emanuel/Documents/emanuel/projetos_php2023/proj_GIT_ERP/app/views/site/login.html");
    }
}
