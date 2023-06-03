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

/* home.html */
class __TwigTemplate_9fd4b2a19500f3246c5abed460d42adf extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "index.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("index.html", "home.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "
<div class=\"content-header\">

    <div class=\"container\">
        <div class=\"row justify-content-end\">
          ";
        // line 9
        echo twig_escape_filter($this->env, ($context["user_name"] ?? null), "html", null, true);
        echo "  
        </div>
    </div>

    <div class=\"container\">
    <div class=\"row mb-2\">
    <div class=\"col-sm-6\">
    <h1 class=\"m-0\"> Home </h1>
    </div>
    <div class=\"col-sm-6\">
    <ol class=\"breadcrumb float-sm-right\">
    <li class=\"breadcrumb-item\"><a href=\"/\">Home</a></li>
   
    
    </ol>
    </div>
    </div>
    </div>


  <br>

<section class=\"content\">
<div class=\"row\">
    <div class=\"col-md-12\">

        <div class=\"box box-primary\">
                    
            


            <div class=\"box-body no-padding\">
               <h1>página principal home</h1>

               <p>
                This system is for demonstration. It's on github. was developed by Emanuel Costa.

               </p>



            </div>
        <!-- /.box-body -->
        </div>
     </div>
</div>   
</section>
";
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 9,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.html", "/Users/emanuel/Documents/emanuel/projetos_php2023/proj_GIT_ERP/app/views/site/home.html");
    }
}
