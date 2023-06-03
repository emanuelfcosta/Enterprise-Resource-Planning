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

/* header.html */
class __TwigTemplate_f2cb40e7dbbbd261523003da137cae6b extends Template
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
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <title>ERP - System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback\">
  <!-- Font Awesome Icons -->
  <link rel=\"stylesheet\" href=\"/res/admin/plugins/fontawesome-free/css/all.min.css\">
  <!-- Theme style -->
  <link rel=\"stylesheet\" href=\"/res/admin/dist/css/adminlte.min.css\">
   <!--sweet alert para mensagens-->
  <script src=\"https://unpkg.com/sweetalert/dist/sweetalert.min.js\"></script>

 


</head>




<body class=\"hold-transition sidebar-mini\">
<div class=\"wrapper\">

  
   

  
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class=\"main-sidebar sidebar-dark-primary elevation-4\">
    <!-- Brand Logo -->
    <a href=\"index3.html\" class=\"brand-link\">
      <img src=\"/res/admin/dist/img/AdminLTELogo.png\" alt=\"AdminLTE Logo\" class=\"brand-image img-circle elevation-3\" style=\"opacity: .8\">
      <span class=\"brand-text font-weight-light\">ERP - System</span>
    </a>

    <div class=\"container\">
      <div class=\"row justify-content-md-center\"> 
      <a href=\"/logout\" onclick=\"return confirm('Do you want to logout?')\" class=\"btn btn-danger btn-flat \">Logout</a>
      <a href=\"/users-pass\" onclick=\"return confirm('Do you want to change your password?')\" class=\"btn btn-primary btn-flat \"><i class=\"fa fa-key\"></i></a>
    </div>
    </div>

    
    <!-- Sidebar -->
    <div class=\"sidebar\">
      <!-- Sidebar user panel (optional) -->
     
      
    

      <!-- Sidebar Menu -->
      <nav class=\"mt-2\">
        <ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class=\"nav-item\">
            <a href=\"/groups\" class=\"nav-link\">
              
              <ion-icon name=\"apps-outline\"></ion-icon>
              <p>
                 Groups
              </p>
            </a>
          </li>
          <li class=\"nav-item\">
            <a href=\"/products\" class=\"nav-link\">
              <ion-icon name=\"business-outline\"></ion-icon>
              
              <p>
                Products
                
              </p>
            </a>
          </li>
          <li class=\"nav-item\">
            <a href=\"/clients\" class=\"nav-link\">
              <ion-icon name=\"person-outline\"></ion-icon>
              <p>
                Clients
                
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/suppliers\" class=\"nav-link\">
              <ion-icon name=\"car-sport-outline\"></ion-icon>
              <p>
                Suppliers
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/paymentmethods\" class=\"nav-link\">
              <ion-icon name=\"wallet-outline\"></ion-icon>
              <p>
                Payment Methods
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/costscenter\" class=\"nav-link\">
              <ion-icon name=\"rocket-outline\"></ion-icon>
              <p>
                Costs Center
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/sales\" class=\"nav-link\">
              <ion-icon name=\"bag-handle-outline\"></ion-icon>
              <p>
                Sales
              </p>
            </a>
          </li>


          <li class=\"nav-item\">
            <a href=\"/purchases\" class=\"nav-link\">
              <ion-icon name=\"bag-add-outline\"></ion-icon>
              <p>
                Purchases
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/accountpayable\" class=\"nav-link\">
              <ion-icon name=\"cloud-upload-outline\"></ion-icon>
              <p>
                Accounts Payable
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/accountreceivable\" class=\"nav-link\">
              <ion-icon name=\"download-outline\"></ion-icon>
              <p>
                Accounts Receivable
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/cashflow\" class=\"nav-link\">
              <ion-icon name=\"eye-outline\"></ion-icon>
              <p>
                Cash Flow
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/report\" class=\"nav-link\">
              <ion-icon name=\"desktop-outline\"></ion-icon>
              <p>
                Report
              </p>
            </a>
          </li>

          <li class=\"nav-item\">
            <a href=\"/users\" class=\"nav-link\">
              <ion-icon name=\"key-outline\"></ion-icon>
              <p>
                Users
              </p>
            </a>
          </li>



  




        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
";
    }

    public function getTemplateName()
    {
        return "header.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html", "/Users/emanuel/Documents/emanuel/projetos_php2023/proj_GIT_ERP/app/views/site/header.html");
    }
}
