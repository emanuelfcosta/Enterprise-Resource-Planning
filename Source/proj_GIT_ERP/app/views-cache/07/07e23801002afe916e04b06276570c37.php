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

/* index.html */
class __TwigTemplate_46b3e2e6a60953ba54863dae84356899 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "
";
        // line 3
        $this->loadTemplate("header.html", "index.html", 3)->display($context);
        // line 4
        echo "
  <div class=\"content-wrapper\">   
    <div class=\"content\">
      
        

         ";
        // line 10
        $this->displayBlock('content', $context, $blocks);
        // line 13
        echo "         
       
         
    </div>
  </div>
  
  ";
        // line 19
        $this->loadTemplate("footer.html", "index.html", 19)->display($context);
    }

    // line 10
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 10,  61 => 19,  53 => 13,  51 => 10,  43 => 4,  41 => 3,  38 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "index.html", "/Users/emanuel/Documents/emanuel/projetos_php2023/proj_GIT_ERP/app/views/site/index.html");
    }
}
